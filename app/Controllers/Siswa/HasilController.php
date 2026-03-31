<?php

namespace App\Controllers\Siswa;

use CodeIgniter\Controller;
use App\Models\PesertaUjianModel;
use App\Models\SiswaModel;
use App\Models\HasilUjianModel;
use App\Models\JadwalUjianModel;
use App\Traits\CATTrait;

class HasilController extends Controller
{
    use CATTrait;

    protected $pesertaUjianModel;
    protected $siswaModel;
    protected $hasilUjianModel;
    protected $jadwalUjianModel;

    public function __construct()
    {
        $this->pesertaUjianModel = new PesertaUjianModel();
        $this->siswaModel = new SiswaModel();
        $this->hasilUjianModel = new HasilUjianModel();
        $this->jadwalUjianModel = new JadwalUjianModel();
    }

    public function index()
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('user_id');
        $siswa = $this->siswaModel->where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->to(base_url('siswa/profil'))
                ->with('error', 'Lengkapi profil siswa terlebih dahulu sebelum melihat hasil ujian.');
        }

        $riwayatUjian = $this->pesertaUjianModel
            ->select('
                peserta_ujian.*, 
                jadwal_ujian.*, 
                ujian.nama_ujian, 
                ujian.kode_ujian,
                ujian.deskripsi, 
                ujian.durasi,
                jenis_ujian.nama_jenis,
                TIMEDIFF(peserta_ujian.waktu_selesai, peserta_ujian.waktu_mulai) as durasi_pengerjaan,
                TIME_TO_SEC(TIMEDIFF(peserta_ujian.waktu_selesai, peserta_ujian.waktu_mulai)) as durasi_detik,
                DATE_FORMAT(peserta_ujian.waktu_mulai, "%d/%m/%Y %H:%i:%s") as waktu_mulai_format,
                DATE_FORMAT(peserta_ujian.waktu_selesai, "%d/%m/%Y %H:%i:%s") as waktu_selesai_format
            ')
            ->join('jadwal_ujian', 'jadwal_ujian.jadwal_id = peserta_ujian.jadwal_id')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = ujian.jenis_ujian_id')
            ->where('peserta_ujian.siswa_id', $siswa['siswa_id'])
            ->where('peserta_ujian.status', 'selesai')
            ->orderBy('peserta_ujian.waktu_selesai', 'DESC')
            ->findAll();

        foreach ($riwayatUjian as &$ujian) {
            $ujian['jumlah_soal'] = $this->hasilUjianModel
                ->where('peserta_ujian_id', $ujian['peserta_ujian_id'])
                ->countAllResults();

            if ($ujian['durasi_detik']) {
                $jam = floor($ujian['durasi_detik'] / 3600);
                $menit = floor(($ujian['durasi_detik'] % 3600) / 60);
                $detik = $ujian['durasi_detik'] % 60;
                $ujian['durasi_format'] = sprintf('%02d:%02d:%02d', $jam, $menit, $detik);
            }
        }

        return view('siswa/hasil', ['riwayatUjian' => $riwayatUjian]);
    }

    public function detail($pesertaUjianId)
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('user_id');
        $siswa = $this->siswaModel->where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->to(base_url('siswa/profil'))
                ->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $hasil = $this->pesertaUjianModel
            ->select('
                peserta_ujian.*, 
                jadwal_ujian.*, 
                ujian.*, 
                jenis_ujian.nama_jenis,
                TIMEDIFF(peserta_ujian.waktu_selesai, peserta_ujian.waktu_mulai) as durasi_total,
                TIME_TO_SEC(TIMEDIFF(peserta_ujian.waktu_selesai, peserta_ujian.waktu_mulai)) as durasi_total_detik,
                DATE_FORMAT(peserta_ujian.waktu_mulai, "%d/%m/%Y %H:%i:%s") as waktu_mulai_format,
                DATE_FORMAT(peserta_ujian.waktu_selesai, "%d/%m/%Y %H:%i:%s") as waktu_selesai_format
            ')
            ->join('jadwal_ujian', 'jadwal_ujian.jadwal_id = peserta_ujian.jadwal_id')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = ujian.jenis_ujian_id')
            ->where('peserta_ujian.peserta_ujian_id', $pesertaUjianId)
            ->where('peserta_ujian.siswa_id', $siswa['siswa_id'])
            ->first();

        if (!$hasil) {
            return redirect()->to(base_url('siswa/hasil'));
        }

        $detailJawaban = $this->hasilUjianModel
            ->select('
                hasil_ujian.*, 
                soal_ujian.pertanyaan, 
                soal_ujian.kode_soal,
                soal_ujian.jawaban_benar, 
                soal_ujian.tingkat_kesulitan, 
                soal_ujian.pembahasan,
                DATE_FORMAT(hasil_ujian.waktu_menjawab, "%H:%i:%s") as waktu_menjawab_format
            ')
            ->join('soal_ujian', 'soal_ujian.soal_id = hasil_ujian.soal_id')
            ->where('hasil_ujian.peserta_ujian_id', $pesertaUjianId)
            ->orderBy('hasil_ujian.waktu_menjawab', 'ASC')
            ->findAll();

        $detailJawabanDenganDurasi = $this->hitungDurasiPerSoal($detailJawaban, $hasil['waktu_mulai']);
        $totalSoal = count($detailJawabanDenganDurasi);
        $jawabanBenar = array_reduce($detailJawabanDenganDurasi, function ($carry, $item) {
            return $carry + ($item['is_correct'] ? 1 : 0);
        }, 0);

        $lastResult = $this->hasilUjianModel->select('theta_saat_ini')->where('peserta_ujian_id', $pesertaUjianId)->orderBy('waktu_menjawab', 'DESC')->first();
        $theta_akhir = $lastResult ? (float)$lastResult['theta_saat_ini'] : 0;
        $skor_akhir = $this->hitungKemampuanKognitif($theta_akhir);
        $klasifikasiKognitif = $this->getKlasifikasiKognitif($skor_akhir);

        $data = [
            'hasil' => $hasil,
            'detailJawaban' => $detailJawabanDenganDurasi,
            'totalSoal' => $totalSoal,
            'jawabanBenar' => $jawabanBenar,
            'skor' => $skor_akhir,
            'klasifikasiKognitif' => $klasifikasiKognitif,
            'kemampuanKognitif' => [
                'skor' => $skor_akhir,
                'total_benar' => $jawabanBenar,
                'total_salah' => $totalSoal - $jawabanBenar,
                'rata_rata_pilihan' => 0
            ]
        ];

        return view('siswa/detail_hasil', $data);
    }

    public function unduh($pesertaUjianId)
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('user_id');
        $siswa = $this->siswaModel->where('user_id', $userId)->first();

        if (!$siswa) {
            return redirect()->to(base_url('siswa/profil'))
                ->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $hasil = $this->pesertaUjianModel
            ->select('peserta_ujian.*, jadwal_ujian.*, ujian.*, jenis_ujian.nama_jenis, TIME_TO_SEC(TIMEDIFF(peserta_ujian.waktu_selesai, peserta_ujian.waktu_mulai)) as durasi_total_detik')
            ->join('jadwal_ujian', 'jadwal_ujian.jadwal_id = peserta_ujian.jadwal_id')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = ujian.jenis_ujian_id')
            ->where('peserta_ujian.peserta_ujian_id', $pesertaUjianId)
            ->first();

        if (!$hasil || $hasil['siswa_id'] != $siswa['siswa_id']) {
            return redirect()->to(base_url('siswa/hasil'));
        }

        $detailJawaban = $this->hasilUjianModel
            ->select('hasil_ujian.*, soal_ujian.pertanyaan, soal_ujian.jawaban_benar')
            ->join('soal_ujian', 'soal_ujian.soal_id = hasil_ujian.soal_id')
            ->where('hasil_ujian.peserta_ujian_id', $pesertaUjianId)
            ->orderBy('hasil_ujian.waktu_menjawab', 'ASC')
            ->findAll();

        $detailJawabanDenganDurasi = $this->hitungDurasiPerSoal($detailJawaban, $hasil['waktu_mulai']);
        $totalSoal = count($detailJawabanDenganDurasi);
        $jawabanBenar = array_reduce($detailJawabanDenganDurasi, function ($carry, $item) {
            return $carry + ($item['is_correct'] ? 1 : 0);
        }, 0);

        $lastResult = $this->hasilUjianModel->select('theta_saat_ini')->where('peserta_ujian_id', $pesertaUjianId)->orderBy('waktu_menjawab', 'DESC')->first();
        $theta_akhir = $lastResult ? (float)$lastResult['theta_saat_ini'] : 0;
        $skor_akhir = $this->hitungKemampuanKognitif($theta_akhir);

        $data = [
            'hasil' => $hasil,
            'detailJawaban' => $detailJawabanDenganDurasi,
            'totalSoal' => $totalSoal,
            'jawabanBenar' => $jawabanBenar,
            'siswa' => $siswa,
            'skor' => $skor_akhir,
            'klasifikasiKognitif' => $this->getKlasifikasiKognitif($skor_akhir),
            'kemampuanKognitif' => ['skor' => $skor_akhir, 'total_benar' => $jawabanBenar, 'total_salah' => $totalSoal - $jawabanBenar, 'rata_rata_pilihan' => 0]
        ];

        return view('siswa/cetak_hasil_ujian', $data);
    }
}
