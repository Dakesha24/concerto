<?php

namespace App\Controllers\Guru;

use CodeIgniter\Controller;
use App\Models\GuruModel;
use Config\Database;

class ProfilController extends Controller
{
    protected $guruModel;
    protected $db;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->db = Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        // Ambil data guru dengan join ke users dan sekolah
        $guru = $this->guruModel
            ->select('guru.*, users.username, users.email, sekolah.nama_sekolah')
            ->join('users', 'users.user_id = guru.user_id', 'left')
            ->join('sekolah', 'sekolah.sekolah_id = guru.sekolah_id', 'left')
            ->where('users.user_id', $userId)
            ->first();

        $sekolahModel = new \App\Models\SekolahModel();
        $data = [
            'guru' => $guru,
            'sekolah' => $sekolahModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('guru/profil', $data);
    }

    public function save()
    {
        $userId = session()->get('user_id');
        $existingGuru = $this->guruModel->where('user_id', $userId)->first();

        // Validasi input
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'nip' => 'required|min_length[5]',
            'mata_pelajaran' => 'required',
            'email' => 'required|valid_email',
            'sekolah_id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Update data users
        $this->db->table('users')->where('user_id', $userId)->update([
            'email' => $this->request->getPost('email')
        ]);

        // Data guru
        $dataGuru = [
            'user_id' => $userId,
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nip' => $this->request->getPost('nip'),
            'mata_pelajaran' => $this->request->getPost('mata_pelajaran'),
            'sekolah_id' => $this->request->getPost('sekolah_id')
        ];

        try {
            if ($existingGuru) {
                $this->guruModel->update($existingGuru['guru_id'], $dataGuru);
                session()->setFlashdata('success', 'Profil berhasil diperbarui!');
            } else {
                $this->guruModel->insert($dataGuru);
                session()->setFlashdata('success', 'Profil berhasil disimpan!');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data.');
            log_message('error', $e->getMessage());
        }

        return redirect()->to(base_url('guru/profil'));
    }
}
