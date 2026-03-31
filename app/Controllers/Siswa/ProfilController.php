<?php

namespace App\Controllers\Siswa;

use CodeIgniter\Controller;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\SekolahModel;

class ProfilController extends Controller
{
    protected $siswaModel;
    protected $kelasModel;
    protected $sekolahModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
        $this->sekolahModel = new SekolahModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        // Ambil data siswa dengan JOIN untuk mendapatkan sekolah_id dari kelas
        $siswa = $this->siswaModel
            ->select('siswa.*, kelas.sekolah_id')
            ->join('kelas', 'kelas.kelas_id = siswa.kelas_id', 'left')
            ->where('siswa.user_id', $userId)
            ->first();

        $data = [
            'siswa' => $siswa,
            'sekolah' => $this->sekolahModel->findAll(),
            'kelas' => [], // Kosongkan karena akan di-load via AJAX
            'isNewUser' => !$this->siswaModel->checkSiswaExists($userId)
        ];

        return view('siswa/profil', $data);
    }

    public function save()
    {
        $userId = session()->get('user_id');
        $data = [
            'user_id' => $userId,
            'nomor_peserta' => $this->request->getPost('nomor_peserta'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'kelas_id' => $this->request->getPost('kelas_id')
        ];

        $rules = [
            'nomor_peserta' => 'required|min_length[5]',
            'nama_lengkap' => 'required|min_length[3]',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'sekolah_id' => 'required|numeric',
            'kelas_id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $existingSiswa = $this->siswaModel->where('user_id', $userId)->first();

        try {
            if ($existingSiswa) {
                $this->siswaModel->update($existingSiswa['siswa_id'], $data);
                session()->setFlashdata('success', 'Profil berhasil diperbarui!');
            } else {
                $this->siswaModel->insert($data);
                session()->setFlashdata('success', 'Profil berhasil disimpan!');
            }
            return redirect()->to(base_url('siswa/profil'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function getKelasBySekolah($sekolahId)
    {
        try {
            $kelas = $this->kelasModel
                ->where('sekolah_id', $sekolahId)
                ->orderBy('nama_kelas', 'ASC')
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'kelas' => $kelas
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error memuat data kelas'
            ]);
        }
    }
}
