<?php

namespace App\Controllers\Siswa;

use CodeIgniter\Controller;
use App\Models\JadwalUjianModel;
use App\Models\PesertaUjianModel;
use App\Models\SiswaModel;
use App\Models\SoalUjianModel;
use App\Models\HasilUjianModel;
use App\Traits\CATTrait;

class UjianController extends Controller
{
    use CATTrait;

    protected $jadwalUjianModel;
    protected $pesertaUjianModel;
    protected $siswaModel;
    protected $soalUjianModel;
    protected $hasilUjianModel;

    public function __construct()
    {
        $this->jadwalUjianModel = new JadwalUjianModel();
        $this->pesertaUjianModel = new PesertaUjianModel();
        $this->siswaModel = new SiswaModel();
        $this->soalUjianModel = new SoalUjianModel();
        $this->hasilUjianModel = new HasilUjianModel();
    }

    public function index()
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('user_id');
        $siswa = $this->siswaModel->where('user_id', $userId)->first();

        if (!$siswa) {
            session()->setFlashdata('error', 'Silahkan lengkapi profil Anda terlebih dahulu');
            return redirect()->to(base_url('siswa/profil'));
        }

        $jadwalUjian = $this->jadwalUjianModel
            ->select('jadwal_ujian.*, ujian.nama_ujian, ujian.kode_ujian, ujian.deskripsi, ujian.durasi, peserta_ujian.status as status_peserta')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->join('peserta_ujian', 'peserta_ujian.jadwal_id = jadwal_ujian.jadwal_id AND peserta_ujian.siswa_id = ' . $siswa['siswa_id'], 'left')
            ->where('jadwal_ujian.kelas_id', $siswa['kelas_id'])
            ->where('jadwal_ujian.tanggal_selesai >=', date('Y-m-d H:i:s'))
            ->where('jadwal_ujian.status !=', 'selesai')
            ->findAll();

        $data = [
            'jadwalUjian' => $jadwalUjian,
            'siswa' => $siswa
        ];

        return view('siswa/ujian', $data);
    }

    public function mulai()
    {
        if (!session()->get('user_id')) {
            session()->setFlashdata('error', 'Silahkan login terlebih dahulu');
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('user_id');
        $siswa = $this->siswaModel->where('user_id', $userId)->first();

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan. Silahkan lengkapi profil terlebih dahulu');
            return redirect()->to(base_url('siswa/profil'));
        }

        $jadwalId = $this->request->getPost('jadwal_id');
        $kodeAkses = $this->request->getPost('kode_akses');

        if (!$jadwalId || !$kodeAkses) {
            session()->setFlashdata('error', 'Data tidak lengkap');
            return redirect()->back();
        }

        $jadwal = $this->jadwalUjianModel->find($jadwalId);
        if (!$jadwal || $jadwal['kode_akses'] != $kodeAkses) {
            session()->setFlashdata('error', 'Kode akses ujian tidak valid!');
            return redirect()->back();
        }

        $peserta = $this->pesertaUjianModel
            ->where('jadwal_id', $jadwalId)
            ->where('siswa_id', $siswa['siswa_id'])
            ->first();

        try {
            if (!$peserta) {
                $dataPeserta = [
                    'jadwal_id' => $jadwalId,
                    'siswa_id' => $siswa['siswa_id'],
                    'status' => 'belum_mulai'
                ];
                $this->pesertaUjianModel->insert($dataPeserta);
            }
            return redirect()->to(base_url("siswa/ujian/soal/$jadwalId"));
        } catch (\Exception $e) {
            log_message('error', 'Error saat mendaftarkan peserta: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat memulai ujian.');
            return redirect()->back();
        }
    }

    public function soal($jadwalId)
    {
        session()->set('current_jadwal_id', $jadwalId);

        if (!session()->get('user_id')) {
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('user_id');
        $siswa = $this->siswaModel->where('user_id', $userId)->first();

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan');
            return redirect()->to(base_url('siswa/profil'));
        }

        $ujianInfo = $this->jadwalUjianModel
            ->select('jadwal_ujian.*, ujian.*, ujian.kode_ujian, jenis_ujian.nama_jenis')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = ujian.jenis_ujian_id')
            ->where('jadwal_ujian.jadwal_id', $jadwalId)
            ->first();

        if (!$ujianInfo) {
            session()->setFlashdata('error', 'Data ujian tidak ditemukan');
            return redirect()->to(base_url('siswa/ujian'));
        }

        $peserta = $this->pesertaUjianModel
            ->where('jadwal_id', $jadwalId)
            ->where('siswa_id', $siswa['siswa_id'])
            ->first();

        if (!$peserta) {
            session()->setFlashdata('error', 'Anda belum terdaftar sebagai peserta ujian');
            return redirect()->to(base_url('siswa/ujian'));
        }

        if ($peserta['status'] === 'selesai') {
            session()->setFlashdata('error', 'Anda sudah menyelesaikan ujian ini');
            return redirect()->to(base_url('siswa/ujian'));
        }

        // Inisialisasi CAT jika baru mulai
        if ($peserta['status'] === 'belum_mulai') {
            $waktuMulai = date('Y-m-d H:i:s');
            $this->pesertaUjianModel->update($peserta['peserta_ujian_id'], [
                'status' => 'sedang_mengerjakan',
                'waktu_mulai' => $waktuMulai
            ]);

            $catParams = [
                'theta' => 0,
                'SE' => 1,
                'answered_questions' => [],
                'current_question' => null,
                'total_questions' => 0
            ];
            session()->set('cat_params', $catParams);
        } else {
            $waktuMulai = $peserta['waktu_mulai'];
            $catParams = session()->get('cat_params');
        }

        if (!$catParams) {
            $catParams = [
                'theta' => 0,
                'SE' => 1,
                'answered_questions' => [],
                'current_question' => null,
                'total_questions' => 0
            ];
            session()->set('cat_params', $catParams);
        }

        // Pilih soal berikutnya jika belum ada (Adaptif)
        if (!isset($catParams['current_question']) || $catParams['current_question'] === null) {
            $nextQuestion = $this->soalUjianModel
                ->select('*, kode_soal, ABS(tingkat_kesulitan - 0) as distance')
                ->where('ujian_id', $ujianInfo['id_ujian'])
                ->orderBy('distance', 'ASC')
                ->first();

            if ($nextQuestion) {
                $catParams['current_question'] = $nextQuestion;
                session()->set('cat_params', $catParams);
            } else {
                session()->setFlashdata('error', 'Tidak ada soal yang tersedia');
                return redirect()->to(base_url('siswa/ujian'));
            }
        }

        // Cek durasi
        $durasi = explode(':', $ujianInfo['durasi']);
        $durasiDetik = ($durasi[0] * 3600) + ($durasi[1] * 60) + (isset($durasi[2]) ? $durasi[2] : 0);
        $waktuSelesai = strtotime($waktuMulai) + $durasiDetik;
        $sisaWaktu = $waktuSelesai - time();

        if ($sisaWaktu <= 0) {
            $this->pesertaUjianModel->update($peserta['peserta_ujian_id'], [
                'status' => 'selesai',
                'waktu_selesai' => date('Y-m-d H:i:s')
            ]);
            session()->remove('cat_params');
            return redirect()->to(base_url("siswa/ujian/selesai/{$jadwalId}"));
        }

        $data = [
            'ujian' => $ujianInfo,
            'soal' => $catParams['current_question'],
            'sisa_waktu' => $sisaWaktu,
            'total_soal' => 'Adaptif',
            'soal_dijawab' => count($catParams['answered_questions'])
        ];

        return view('siswa/soal', $data);
    }

    public function simpanJawaban()
    {
        $soalId = $this->request->getPost('soal_id');
        $jawaban = $this->request->getPost('jawaban');

        if (!$soalId || !$jawaban) {
            session()->setFlashdata('error', 'Data jawaban tidak lengkap');
            return redirect()->back();
        }

        $soal = $this->soalUjianModel->find($soalId);
        $current_jadwal_id = session()->get('current_jadwal_id');
        $catParams = session()->get('cat_params');

        if (!$soal || !$current_jadwal_id || !$catParams) {
            return redirect()->to(base_url('siswa/ujian'));
        }

        $ujianInfo = $this->jadwalUjianModel
            ->select('jadwal_ujian.*, ujian.*')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->where('jadwal_ujian.jadwal_id', $current_jadwal_id)
            ->first();

        $isBenar = ($jawaban === $soal['jawaban_benar']);
        $theta = $catParams['theta'];
        $b = $soal['tingkat_kesulitan'];

        // Perhitungan probabilitas IRT 1PL
        $e = 2.71828;
        $Pi = pow($e, ($theta - $b)) / (1 + pow($e, ($theta - $b)));
        $Qi = 1 - $Pi;
        $Ii = $Pi * $Qi;

        $totalIi = 0;
        foreach ($catParams['answered_questions'] as $answeredSoalId) {
            $answeredSoal = $this->soalUjianModel->find($answeredSoalId);
            $bi = $answeredSoal['tingkat_kesulitan'];
            $Pi_ans = pow($e, ($theta - $bi)) / (1 + pow($e, ($theta - $bi)));
            $totalIi += ($Pi_ans * (1 - $Pi_ans));
        }
        $totalIi += $Ii;

        $SE_old = $catParams['SE'];
        $SE_new = $totalIi > 0 ? 1 / sqrt($totalIi) : 1;
        $delta_SE = $SE_old - $SE_new;

        // Pemilihan soal berikutnya (Step-up/Step-down)
        if ($isBenar) {
            $theta = $b;
            $nextQuestion = $this->soalUjianModel
                ->where('ujian_id', $soal['ujian_id'])
                ->where('tingkat_kesulitan >', $b);
        } else {
            $theta = $b;
            $nextQuestion = $this->soalUjianModel
                ->where('ujian_id', $soal['ujian_id'])
                ->where('tingkat_kesulitan <', $b);
        }

        if (!empty($catParams['answered_questions'])) {
            $nextQuestion->whereNotIn('soal_id', $catParams['answered_questions']);
        }

        $nextQuestion = $nextQuestion->orderBy('tingkat_kesulitan', $isBenar ? 'ASC' : 'DESC')->first();

        // Update CAT params
        $catParams['theta'] = $theta;
        $catParams['SE'] = $SE_new;
        if (!in_array($soalId, $catParams['answered_questions'])) {
            $catParams['answered_questions'][] = $soalId;
        }
        $catParams['current_question'] = $nextQuestion;
        $catParams['total_questions'] = count($catParams['answered_questions']);
        session()->set('cat_params', $catParams);

        // Simpan ke database
        $siswaId = $this->siswaModel->where('user_id', session()->get('user_id'))->first()['siswa_id'];
        $peserta = $this->pesertaUjianModel->where(['jadwal_id' => $current_jadwal_id, 'siswa_id' => $siswaId])->first();

        $this->hasilUjianModel->insert([
            'peserta_ujian_id' => $peserta['peserta_ujian_id'],
            'soal_id' => $soalId,
            'jawaban_siswa' => $jawaban,
            'is_correct' => $isBenar,
            'theta_saat_ini' => $theta,
            'pi_saat_ini' => $Pi,
            'qi_saat_ini' => $Qi,
            'ii_saat_ini' => $Ii,
            'se_saat_ini' => $SE_new,
            'delta_se_saat_ini' => $delta_SE
        ]);

        // Cek kondisi berhenti CAT
        $shouldStop = ($SE_new < (float)$ujianInfo['se_minimum']) 
                    || (abs($delta_SE) < (float)$ujianInfo['delta_se_minimum']) 
                    || !$nextQuestion;

        if ($shouldStop) {
            $this->pesertaUjianModel->update($peserta['peserta_ujian_id'], [
                'status' => 'selesai',
                'waktu_selesai' => date('Y-m-d H:i:s')
            ]);
            return redirect()->to(base_url("siswa/ujian/selesai/{$current_jadwal_id}"));
        }

        return redirect()->back();
    }

    public function selesai($jadwalId)
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('login'));
        }

        $siswaId = $this->siswaModel->where('user_id', session()->get('user_id'))->first()['siswa_id'];
        $peserta = $this->pesertaUjianModel->where(['jadwal_id' => $jadwalId, 'siswa_id' => $siswaId])->first();

        if (!$peserta) {
            return redirect()->to(base_url('siswa/ujian'));
        }

        $this->pesertaUjianModel->update($peserta['peserta_ujian_id'], [
            'status' => 'selesai',
            'waktu_selesai' => date('Y-m-d H:i:s')
        ]);

        $ujianInfo = $this->jadwalUjianModel
            ->select('jadwal_ujian.*, ujian.nama_ujian, ujian.deskripsi')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->where('jadwal_ujian.jadwal_id', $jadwalId)
            ->first();

        $catParams = session()->get('cat_params');
        $nilaiAkhir = $catParams ? $catParams['theta'] : 0;
        $totalSoal = $catParams ? count($catParams['answered_questions']) : 0;

        session()->remove('cat_params');

        $data = [
            'ujian' => $ujianInfo,
            'peserta' => $peserta,
            'nilai_akhir' => $nilaiAkhir,
            'total_soal' => $totalSoal
        ];

        return view('siswa/selesai_ujian', $data);
    }
}
