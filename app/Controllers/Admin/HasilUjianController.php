<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class HasilUjianController extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function daftarHasilUjian()
    {
        $daftarUjian = $this->db->table('jadwal_ujian ju')
            ->select('ju.jadwal_id, ju.status as status_ujian, ju.tanggal_mulai, ju.tanggal_selesai, ju.kode_akses,
             u.nama_ujian, u.deskripsi, j.nama_jenis, k.nama_kelas, k.tahun_ajaran,
             s.nama_sekolah, g.nama_lengkap as nama_guru,
             COUNT(DISTINCT pu.peserta_ujian_id) as jumlah_peserta,
             COUNT(DISTINCT CASE WHEN pu.status = "selesai" THEN pu.peserta_ujian_id END) as peserta_selesai,
             COUNT(DISTINCT CASE WHEN pu.status = "sedang_mengerjakan" THEN pu.peserta_ujian_id END) as peserta_sedang_mengerjakan,
             COUNT(DISTINCT CASE WHEN pu.status = "belum_mulai" THEN pu.peserta_ujian_id END) as peserta_belum_mulai,
             AVG(CASE WHEN pu.status = "selesai" THEN TIME_TO_SEC(TIMEDIFF(pu.waktu_selesai, pu.waktu_mulai)) END) as rata_rata_durasi_detik,
             MIN(CASE WHEN pu.status = "selesai" THEN TIME_TO_SEC(TIMEDIFF(pu.waktu_selesai, pu.waktu_mulai)) END) as durasi_tercepat_detik,
             MAX(CASE WHEN pu.status = "selesai" THEN TIME_TO_SEC(TIMEDIFF(pu.waktu_selesai, pu.waktu_mulai)) END) as durasi_terlama_detik,
             DATE_FORMAT(ju.tanggal_mulai, "%d/%m/%Y %H:%i") as tanggal_mulai_format,
             DATE_FORMAT(ju.tanggal_selesai, "%d/%m/%Y %H:%i") as tanggal_selesai_format')
            ->join('ujian u', 'u.id_ujian = ju.ujian_id', 'left')
            ->join('jenis_ujian j', 'j.jenis_ujian_id = u.jenis_ujian_id', 'left')
            ->join('kelas k', 'k.kelas_id = ju.kelas_id', 'left')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id', 'left')
            ->join('guru g', 'g.guru_id = ju.guru_id', 'left')
            ->join('peserta_ujian pu', 'pu.jadwal_id = ju.jadwal_id', 'left')
            ->groupBy('ju.jadwal_id, ju.status, ju.tanggal_mulai, ju.tanggal_selesai, ju.kode_akses,
                       u.nama_ujian, u.deskripsi, j.nama_jenis, k.nama_kelas, k.tahun_ajaran, s.nama_sekolah, g.nama_lengkap')
            ->orderBy('ju.tanggal_mulai', 'DESC')
            ->get()->getResultArray();

        foreach ($daftarUjian as &$ujian) {
            $ujian['rata_rata_durasi_format']  = $this->formatDurasi($ujian['rata_rata_durasi_detik']);
            $ujian['durasi_tercepat_format']   = $this->formatDurasi($ujian['durasi_tercepat_detik']);
            $ujian['durasi_terlama_format']    = $this->formatDurasi($ujian['durasi_terlama_detik']);
            $ujian['status_class']             = $this->getStatusClass($ujian['status_ujian']);
            $ujian['status_text']              = $this->getStatusText($ujian['status_ujian']);
        }

        $data['daftarUjian'] = $daftarUjian;
        return view('admin/hasil/daftar', $data);
    }

    public function hasilUjianSiswa($jadwalId)
    {
        $ujian = $this->db->table('jadwal_ujian ju')
            ->select('ju.*, u.nama_ujian, u.deskripsi, u.kode_ujian, j.nama_jenis, k.nama_kelas, k.tahun_ajaran,
                     s.nama_sekolah, g.nama_lengkap as nama_guru,
                     DATE_FORMAT(ju.tanggal_mulai, "%d/%m/%Y %H:%i") as tanggal_mulai_format,
                     DATE_FORMAT(ju.tanggal_selesai, "%d/%m/%Y %H:%i") as tanggal_selesai_format')
            ->join('ujian u', 'u.id_ujian = ju.ujian_id', 'left')
            ->join('jenis_ujian j', 'j.jenis_ujian_id = u.jenis_ujian_id', 'left')
            ->join('kelas k', 'k.kelas_id = ju.kelas_id', 'left')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id', 'left')
            ->join('guru g', 'g.guru_id = ju.guru_id', 'left')
            ->where('ju.jadwal_id', $jadwalId)
            ->get()->getRowArray();

        if (!$ujian) {
            session()->setFlashdata('error', 'Jadwal ujian tidak ditemukan');
            return redirect()->to(base_url('admin/hasil-ujian'));
        }

        $hasilSiswa = $this->db->table('peserta_ujian pu')
            ->select('pu.peserta_ujian_id, pu.status, pu.waktu_mulai, pu.waktu_selesai,
                     siswa.siswa_id, siswa.nama_lengkap, siswa.nomor_peserta, siswa.jenis_kelamin,
                     u.username,
                     TIME_TO_SEC(TIMEDIFF(pu.waktu_selesai, pu.waktu_mulai)) as durasi_detik,
                     DATE_FORMAT(pu.waktu_mulai, "%d/%m/%Y %H:%i:%s") as waktu_mulai_format,
                     DATE_FORMAT(pu.waktu_selesai, "%d/%m/%Y %H:%i:%s") as waktu_selesai_format')
            ->join('siswa', 'siswa.siswa_id = pu.siswa_id', 'left')
            ->join('users u', 'u.user_id = siswa.user_id', 'left')
            ->where('pu.jadwal_id', $jadwalId)
            ->orderBy('siswa.nama_lengkap', 'ASC')
            ->get()->getResultArray();

        foreach ($hasilSiswa as &$siswa) {
            if ($siswa['status'] === 'selesai') {
                $lastResult    = $this->db->table('hasil_ujian')
                    ->select('theta_saat_ini, se_saat_ini')
                    ->where('peserta_ujian_id', $siswa['peserta_ujian_id'])
                    ->orderBy('waktu_menjawab', 'DESC')->limit(1)->get()->getRowArray();

                $theta_akhir   = $lastResult ? (float) $lastResult['theta_saat_ini'] : 0;
                $skor_akhir    = $this->hitungKemampuanKognitif($theta_akhir);

                $siswa['theta_akhir']         = $theta_akhir;
                $siswa['skor']                = $skor_akhir;
                $siswa['nilai']               = min(100, max(0, round($skor_akhir)));
                $siswa['se_akhir']            = $lastResult ? $lastResult['se_saat_ini'] : null;
                $siswa['jawaban_benar']       = $this->db->table('hasil_ujian')->where(['peserta_ujian_id' => $siswa['peserta_ujian_id'], 'is_correct' => 1])->countAllResults();
                $siswa['total_soal']          = $this->db->table('hasil_ujian')->where('peserta_ujian_id', $siswa['peserta_ujian_id'])->countAllResults();
                $siswa['klasifikasi_kognitif'] = $this->getKlasifikasiKognitif($skor_akhir);
                $siswa['durasi_format']        = $this->formatDurasi($siswa['durasi_detik']);
            } else {
                $siswa['theta_akhir']          = null;
                $siswa['skor']                 = null;
                $siswa['nilai']                = null;
                $siswa['se_akhir']             = null;
                $siswa['jawaban_benar']        = 0;
                $siswa['total_soal']           = 0;
                $siswa['klasifikasi_kognitif'] = $this->getKlasifikasiKognitif(0);
                $siswa['durasi_format']        = '-';
            }
        }

        $data = ['ujian' => $ujian, 'hasilSiswa' => $hasilSiswa];
        return view('admin/hasil/siswa', $data);
    }

    public function detailHasilSiswa($pesertaUjianId)
    {
        $hasil = $this->getHasilLengkap($pesertaUjianId);
        if (!$hasil) {
            session()->setFlashdata('error', 'Data hasil ujian tidak ditemukan');
            return redirect()->to(base_url('admin/hasil-ujian'));
        }

        $detailJawaban          = $this->getDetailJawaban($pesertaUjianId);
        $detailDenganDurasi     = $this->hitungDurasiPerSoal($detailJawaban, $hasil['waktu_mulai']);
        $totalSoal              = count($detailDenganDurasi);
        $jawabanBenar           = array_reduce($detailDenganDurasi, fn($c, $i) => $c + ($i['is_correct'] ? 1 : 0), 0);

        $lastResult             = end($detailDenganDurasi);
        $theta_akhir            = $lastResult ? (float) $lastResult['theta_saat_ini'] : 0;
        $skor_akhir             = $this->hitungKemampuanKognitif($theta_akhir);
        $klasifikasiKognitif    = $this->getKlasifikasiKognitif($skor_akhir);

        $hasil = $this->appendDurasiFormat($hasil, $totalSoal);

        $data = [
            'hasil'               => $hasil,
            'detailJawaban'       => $detailDenganDurasi,
            'totalSoal'           => $totalSoal,
            'jawabanBenar'        => $jawabanBenar,
            'kemampuanKognitif'   => ['skor' => $skor_akhir, 'total_benar' => $jawabanBenar, 'total_salah' => $totalSoal - $jawabanBenar, 'rata_rata_pilihan' => 0],
            'klasifikasiKognitif' => $klasifikasiKognitif,
            'rataRataWaktuFormat' => $hasil['rata_rata_waktu_format'],
        ];

        return view('admin/hasil/detail', $data);
    }

    public function downloadExcelHTML($pesertaUjianId)
    {
        $hasil = $this->getHasilLengkap($pesertaUjianId);
        if (!$hasil) {
            return redirect()->to(base_url('admin/hasil-ujian'));
        }

        $detailJawaban       = $this->getDetailJawaban($pesertaUjianId);
        $detailDenganDurasi  = $this->hitungDurasiPerSoal($detailJawaban, $hasil['waktu_mulai']);
        $totalSoal           = count($detailDenganDurasi);
        $jawabanBenar        = array_reduce($detailDenganDurasi, fn($c, $i) => $c + ($i['is_correct'] ? 1 : 0), 0);

        $lastResult          = end($detailDenganDurasi);
        $theta_akhir         = $lastResult ? (float) $lastResult['theta_saat_ini'] : 0;
        $skor_akhir          = $this->hitungKemampuanKognitif($theta_akhir);
        $klasifikasiKognitif = $this->getKlasifikasiKognitif($skor_akhir);

        $hasil = $this->appendDurasiFormat($hasil, $totalSoal);

        $data = [
            'hasil'               => $hasil,
            'detailJawaban'       => $detailDenganDurasi,
            'finalScore'          => $skor_akhir,
            'lastTheta'           => $theta_akhir,
            'jawabanBenar'        => $jawabanBenar,
            'kemampuanKognitif'   => ['skor' => $skor_akhir, 'total_benar' => $jawabanBenar, 'total_salah' => $totalSoal - $jawabanBenar, 'rata_rata_pilihan' => 0],
            'klasifikasiKognitif' => $klasifikasiKognitif,
            'rataRataWaktuFormat' => $hasil['rata_rata_waktu_format'],
        ];

        $filename = 'hasil_ujian_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $hasil['nama_lengkap']) . '_' . date('dmY') . '.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo view('admin/hasil/download_excel', $data);
        exit;
    }

    public function downloadPDFHTML($pesertaUjianId)
    {
        $hasil = $this->getHasilLengkap($pesertaUjianId);
        if (!$hasil) {
            session()->setFlashdata('error', 'Data hasil ujian tidak ditemukan.');
            return redirect()->to(base_url('admin/hasil-ujian'));
        }

        $detailJawaban       = $this->getDetailJawaban($pesertaUjianId);
        $detailDenganDurasi  = $this->hitungDurasiPerSoal($detailJawaban, $hasil['waktu_mulai']);
        $totalSoal           = count($detailDenganDurasi);
        $jawabanBenar        = array_reduce($detailDenganDurasi, fn($c, $i) => $c + ($i['is_correct'] ? 1 : 0), 0);

        $lastResult          = end($detailDenganDurasi);
        $theta_akhir         = $lastResult ? (float) $lastResult['theta_saat_ini'] : 0;
        $skor_akhir          = $this->hitungKemampuanKognitif($theta_akhir);
        $klasifikasiKognitif = $this->getKlasifikasiKognitif($skor_akhir);

        $hasil = $this->appendDurasiFormat($hasil, $totalSoal);

        $data = [
            'hasil'               => $hasil,
            'detailJawaban'       => $detailDenganDurasi,
            'jawabanBenar'        => $jawabanBenar,
            'totalSoal'           => $totalSoal,
            'kemampuanKognitif'   => ['skor' => $skor_akhir, 'total_benar' => $jawabanBenar, 'total_salah' => $totalSoal - $jawabanBenar, 'rata_rata_pilihan' => 0],
            'klasifikasiKognitif' => $klasifikasiKognitif,
            'rataRataWaktuFormat' => $hasil['rata_rata_waktu_format'],
            'thetaData'           => json_encode(array_column($detailDenganDurasi, 'theta_saat_ini')),
            'seData'              => json_encode(array_column($detailDenganDurasi, 'se_saat_ini')),
            'labels'              => json_encode(array_column($detailDenganDurasi, 'nomor_soal')),
        ];

        $html = view('admin/hasil/download_pdf', $data);
        header('Content-Type: text/html');
        header('Content-Disposition: inline; filename="laporan_hasil_ujian.html"');
        echo $html;
        exit;
    }

    public function hapusHasilSiswa($pesertaUjianId)
    {
        try {
            $this->db->transStart();

            $peserta = $this->db->table('peserta_ujian')->where('peserta_ujian_id', $pesertaUjianId)->get()->getRowArray();
            if (!$peserta) {
                session()->setFlashdata('error', 'Data peserta tidak ditemukan');
                return redirect()->back();
            }

            $this->db->table('hasil_ujian')->where('peserta_ujian_id', $pesertaUjianId)->delete();
            $this->db->table('peserta_ujian')->where('peserta_ujian_id', $pesertaUjianId)->update([
                'status'        => 'belum_mulai',
                'waktu_mulai'   => null,
                'waktu_selesai' => null,
            ]);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            session()->setFlashdata('success', 'Hasil ujian siswa berhasil dihapus dan direset!');
        } catch (\Exception $e) {
            log_message('error', 'Error deleting hasil siswa: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus hasil ujian: ' . $e->getMessage());
        }

        return redirect()->to(base_url('admin/hasil-ujian/siswa/' . $peserta['jadwal_id']));
    }

    // ===== Private Helpers =====

    private function getHasilLengkap($pesertaUjianId)
    {
        return $this->db->table('peserta_ujian pu')
            ->select('pu.*, ju.*, u.nama_ujian, u.deskripsi, u.kode_ujian, j.nama_jenis,
                  siswa.nama_lengkap, siswa.nomor_peserta,
                  k.nama_kelas, k.tahun_ajaran, s.nama_sekolah,
                  g.nama_lengkap as nama_guru,
                  TIMEDIFF(pu.waktu_selesai, pu.waktu_mulai) as durasi_total,
                  TIME_TO_SEC(TIMEDIFF(pu.waktu_selesai, pu.waktu_mulai)) as durasi_total_detik,
                  DATE_FORMAT(pu.waktu_mulai, "%d/%m/%Y %H:%i:%s") as waktu_mulai_format,
                  DATE_FORMAT(pu.waktu_selesai, "%d/%m/%Y %H:%i:%s") as waktu_selesai_format')
            ->join('jadwal_ujian ju', 'ju.jadwal_id = pu.jadwal_id', 'left')
            ->join('ujian u', 'u.id_ujian = ju.ujian_id', 'left')
            ->join('jenis_ujian j', 'j.jenis_ujian_id = u.jenis_ujian_id', 'left')
            ->join('siswa', 'siswa.siswa_id = pu.siswa_id', 'left')
            ->join('kelas k', 'k.kelas_id = ju.kelas_id', 'left')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id', 'left')
            ->join('guru g', 'g.guru_id = ju.guru_id', 'left')
            ->where('pu.peserta_ujian_id', $pesertaUjianId)
            ->get()->getRowArray();
    }

    private function getDetailJawaban($pesertaUjianId)
    {
        return $this->db->table('hasil_ujian')
            ->select('hasil_ujian.*, s.pertanyaan, s.kode_soal, s.pilihan_a, s.pilihan_b, s.pilihan_c, s.pilihan_d,
                  s.jawaban_benar, s.tingkat_kesulitan, s.foto, s.pembahasan,
                  DATE_FORMAT(hasil_ujian.waktu_menjawab, "%H:%i:%s") as waktu_menjawab_format')
            ->join('soal_ujian s', 's.soal_id = hasil_ujian.soal_id', 'left')
            ->where('hasil_ujian.peserta_ujian_id', $pesertaUjianId)
            ->orderBy('hasil_ujian.waktu_menjawab', 'ASC')
            ->get()->getResultArray();
    }

    private function appendDurasiFormat($hasil, $totalSoal)
    {
        $hasil['durasi_total_format'] = $this->formatDurasi($hasil['durasi_total_detik']);

        if ($totalSoal > 0 && !empty($hasil['durasi_total_detik'])) {
            $rataRata = $hasil['durasi_total_detik'] / $totalSoal;
            $hasil['rata_rata_waktu_format'] = sprintf('%d menit %d detik', floor($rataRata / 60), (int) $rataRata % 60);
        } else {
            $hasil['rata_rata_waktu_format'] = '-';
        }

        return $hasil;
    }

    private function hitungDurasiPerSoal($detailJawaban, $waktuMulaiUjian)
    {
        $hasil            = [];
        $waktuSebelumnya  = $waktuMulaiUjian;

        foreach ($detailJawaban as $index => $jawaban) {
            $durasiDetik = strtotime($jawaban['waktu_menjawab']) - strtotime($waktuSebelumnya);
            $jawaban['durasi_pengerjaan_detik']  = $durasiDetik;
            $jawaban['durasi_pengerjaan_format'] = sprintf('%d menit %d detik', floor($durasiDetik / 60), $durasiDetik % 60);
            $jawaban['nomor_soal']               = $index + 1;
            $hasil[]                             = $jawaban;
            $waktuSebelumnya                     = $jawaban['waktu_menjawab'];
        }

        return $hasil;
    }

    private function hitungKemampuanKognitif($theta)
    {
        return max(0, round(50 + (16.67 * (float) $theta), 2));
    }

    private function getKlasifikasiKognitif($skor)
    {
        if ($skor < 25) {
            return ['kategori' => 'Sangat Rendah', 'class' => 'text-danger', 'bg_class' => 'bg-danger'];
        } elseif ($skor < 42) {
            return ['kategori' => 'Rendah', 'class' => 'text-orange', 'bg_class' => 'bg-orange'];
        } elseif ($skor < 58) {
            return ['kategori' => 'Cukup', 'class' => 'text-warning', 'bg_class' => 'bg-warning'];
        } elseif ($skor < 75) {
            return ['kategori' => 'Baik', 'class' => 'text-info', 'bg_class' => 'bg-info'];
        } else {
            return ['kategori' => 'Sangat Baik', 'class' => 'text-success', 'bg_class' => 'bg-success'];
        }
    }

    private function formatDurasi($detik)
    {
        if (empty($detik)) {
            return '-';
        }
        return sprintf('%02d:%02d:%02d', floor($detik / 3600), floor(($detik % 3600) / 60), $detik % 60);
    }

    private function getStatusClass($status)
    {
        $map = ['belum_mulai' => 'secondary', 'sedang_berlangsung' => 'warning', 'selesai' => 'success'];
        return $map[$status] ?? 'secondary';
    }

    private function getStatusText($status)
    {
        $map = ['belum_mulai' => 'Belum Mulai', 'sedang_berlangsung' => 'Sedang Berlangsung', 'selesai' => 'Selesai'];
        return $map[$status] ?? 'Tidak Diketahui';
    }
}
