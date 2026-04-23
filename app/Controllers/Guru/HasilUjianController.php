<?php

namespace App\Controllers\Guru;

use CodeIgniter\Controller;
use App\Models\JadwalUjianModel;
use App\Models\GuruModel;
use App\Models\PesertaUjianModel;
use App\Models\HasilUjianModel;
use App\Traits\CATTrait;
use Config\Database;

class HasilUjianController extends Controller
{
    use CATTrait;

    protected $jadwalUjianModel;
    protected $guruModel;
    protected $pesertaUjianModel;
    protected $hasilUjianModel;
    protected $db;

    public function __construct()
    {
        $this->jadwalUjianModel = new JadwalUjianModel();
        $this->guruModel = new GuruModel();
        $this->pesertaUjianModel = new PesertaUjianModel();
        $this->hasilUjianModel = new HasilUjianModel();
        $this->db = Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $userId)->first();

        $daftarUjian = $this->jadwalUjianModel
            ->select('jadwal_ujian.*, ujian.nama_ujian, ujian.deskripsi, ujian.kode_ujian, jenis_ujian.nama_jenis, kelas.nama_kelas,
             (SELECT COUNT(*) FROM peserta_ujian WHERE peserta_ujian.jadwal_id = jadwal_ujian.jadwal_id AND peserta_ujian.status = "selesai") as jumlah_peserta,
             (SELECT AVG(TIME_TO_SEC(TIMEDIFF(peserta_ujian.waktu_selesai, peserta_ujian.waktu_mulai))) 
             FROM peserta_ujian 
             WHERE peserta_ujian.jadwal_id = jadwal_ujian.jadwal_id AND peserta_ujian.status = "selesai") as rata_rata_durasi_detik,
             DATE_FORMAT(jadwal_ujian.tanggal_mulai, "%d/%m/%Y %H:%i") as tanggal_mulai_format')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = ujian.jenis_ujian_id')
            ->join('kelas', 'kelas.kelas_id = jadwal_ujian.kelas_id')
            ->where('jadwal_ujian.guru_id', $guru['guru_id'])
            ->orderBy('jadwal_ujian.tanggal_mulai', 'DESC')
            ->findAll();

        foreach ($daftarUjian as &$ujian) {
            if ($ujian['rata_rata_durasi_detik']) {
                $menit = floor($ujian['rata_rata_durasi_detik'] / 60);
                $detik = $ujian['rata_rata_durasi_detik'] % 60;
                $ujian['rata_rata_durasi_format'] = sprintf('%d menit %d detik', $menit, $detik);
            } else {
                $ujian['rata_rata_durasi_format'] = '-';
            }
        }

        return view('guru/hasil_ujian', ['daftarUjian' => $daftarUjian]);
    }

    public function siswa($jadwalId)
    {
        $ujian = $this->db->table('jadwal_ujian ju')
            ->select('ju.*, u.nama_ujian, j.nama_jenis, k.nama_kelas, g.nama_lengkap as nama_guru')
            ->join('ujian u', 'u.id_ujian = ju.ujian_id', 'left')
            ->join('jenis_ujian j', 'j.jenis_ujian_id = u.jenis_ujian_id', 'left')
            ->join('kelas k', 'k.kelas_id = ju.kelas_id', 'left')
            ->join('guru g', 'g.guru_id = ju.guru_id', 'left')
            ->where('ju.jadwal_id', $jadwalId)
            ->get()->getRowArray();

        if (!$ujian) return redirect()->to('guru/hasil-ujian');

        $hasilSiswa = $this->db->table('peserta_ujian pu')
            ->select('pu.*, s.nama_lengkap, s.nomor_peserta, TIMEDIFF(pu.waktu_selesai, pu.waktu_mulai) as durasi_pengerjaan')
            ->join('siswa s', 's.siswa_id = pu.siswa_id')
            ->where('pu.jadwal_id', $jadwalId)
            ->get()->getResultArray();

        $ujianId = (int)$ujian['ujian_id'];
        foreach ($hasilSiswa as &$siswa) {
            if ($siswa['status'] === 'selesai') {
                $lastResult  = $this->hasilUjianModel->select('theta_saat_ini')->where('peserta_ujian_id', $siswa['peserta_ujian_id'])->orderBy('waktu_menjawab', 'DESC')->first();
                $theta_akhir = $lastResult ? (float)$lastResult['theta_saat_ini'] : 0;
                $skor_akhir  = $this->hitungKemampuanKognitif($theta_akhir, $ujianId);
                $siswa['skor']                = $skor_akhir;
                $siswa['klasifikasi_kognitif'] = $this->getKlasifikasiKognitif($skor_akhir);
            }
        }

        return view('guru/daftar_siswa', ['ujian' => $ujian, 'hasilSiswa' => $hasilSiswa]);
    }

    public function detail($pesertaUjianId)
    {
        $hasil = $this->pesertaUjianModel
            ->select('peserta_ujian.*, jadwal_ujian.*, ujian.*, siswa.nama_lengkap, siswa.nomor_peserta, kelas.nama_kelas, guru.nama_lengkap as nama_guru, sekolah.nama_sekolah,
            TIME_TO_SEC(TIMEDIFF(peserta_ujian.waktu_selesai, peserta_ujian.waktu_mulai)) as durasi_total_detik,
            DATE_FORMAT(peserta_ujian.waktu_mulai, "%d/%m/%Y %H:%i:%s") as waktu_mulai_format,
            DATE_FORMAT(peserta_ujian.waktu_selesai, "%d/%m/%Y %H:%i:%s") as waktu_selesai_format')
            ->join('jadwal_ujian', 'jadwal_ujian.jadwal_id = peserta_ujian.jadwal_id')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->join('siswa', 'siswa.siswa_id = peserta_ujian.siswa_id')
            ->join('kelas', 'kelas.kelas_id = jadwal_ujian.kelas_id')
            ->join('sekolah', 'sekolah.sekolah_id = kelas.sekolah_id')
            ->join('guru', 'guru.guru_id = jadwal_ujian.guru_id')
            ->where('peserta_ujian.peserta_ujian_id', $pesertaUjianId)
            ->first();

        $detailJawaban = $this->hasilUjianModel
            ->select('hasil_ujian.*, soal_ujian.pertanyaan, soal_ujian.kode_soal, soal_ujian.jawaban_benar, soal_ujian.tingkat_kesulitan, soal_ujian.pembahasan,
            DATE_FORMAT(hasil_ujian.waktu_menjawab, "%H:%i:%s") as waktu_menjawab_format')
            ->join('soal_ujian', 'soal_ujian.soal_id = hasil_ujian.soal_id')
            ->where('hasil_ujian.peserta_ujian_id', $pesertaUjianId)
            ->orderBy('hasil_ujian.waktu_menjawab', 'ASC')
            ->findAll();

        $detailJawabanDenganDurasi = $this->hitungDurasiPerSoal($detailJawaban, $hasil['waktu_mulai']);
        $totalSoal    = count($detailJawabanDenganDurasi);
        $jawabanBenar = array_reduce($detailJawaban, fn($c, $i) => $c + ($i['is_correct'] ? 1 : 0), 0);
        $lastResult   = end($detailJawaban);
        $theta_akhir  = $lastResult ? (float)$lastResult['theta_saat_ini'] : 0;
        $skor_akhir   = $this->hitungKemampuanKognitif($theta_akhir, (int)$hasil['id_ujian']);

        $durasiDetik = (int)($hasil['durasi_total_detik'] ?? 0);
        $hasil['durasi_total_format'] = sprintf('%02d:%02d:%02d', floor($durasiDetik / 3600), floor(($durasiDetik % 3600) / 60), $durasiDetik % 60);
        $rataDetik = $totalSoal > 0 ? (int)floor($durasiDetik / $totalSoal) : 0;
        $rataRataWaktuFormat = sprintf('%d menit %d detik', floor($rataDetik / 60), $rataDetik % 60);

        $data = [
            'hasil'              => $hasil,
            'detailJawaban'      => $detailJawabanDenganDurasi,
            'totalSoal'          => $totalSoal,
            'jawabanBenar'       => $jawabanBenar,
            'rataRataWaktuFormat' => $rataRataWaktuFormat,
            'kemampuanKognitif'  => [
                'skor'              => $skor_akhir,
                'total_benar'       => $jawabanBenar,
                'total_salah'       => $totalSoal - $jawabanBenar,
                'rata_rata_pilihan' => 0,
            ],
            'klasifikasiKognitif' => $this->getKlasifikasiKognitif($skor_akhir)
        ];

        return view('guru/detail_hasil', $data);
    }

    public function downloadExcel($pesertaUjianId)
    {
        // Logika download Excel dipindahkan ke sini
        // (Sesuai dengan fungsi downloadExcelHTML di Guru.php)
    }

    public function downloadPDF($pesertaUjianId)
    {
        // Logika download PDF dipindahkan ke sini
        // (Sesuai dengan fungsi downloadPDFHTML di Guru.php)
    }
}
