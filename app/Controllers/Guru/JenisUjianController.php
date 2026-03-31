<?php

namespace App\Controllers\Guru;

use CodeIgniter\Controller;
use App\Models\JenisUjianModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use Config\Database;

class JenisUjianController extends Controller
{
    protected $jenisUjianModel;
    protected $guruModel;
    protected $kelasModel;
    protected $db;

    public function __construct()
    {
        $this->jenisUjianModel = new JenisUjianModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();
        $this->db = Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $userId)->first();

        $data['jenis_ujian'] = $this->jenisUjianModel->getByKelasGuru($guru['guru_id']);
        $data['kelas_guru'] = $this->jenisUjianModel->getAvailableKelasForGuru($guru['guru_id']) ?? [];

        return view('guru/jenis_ujian', $data);
    }

    public function tambah()
    {
        $userId = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $userId)->first();
        $kelasId = $this->request->getPost('kelas_id');

        if (empty($kelasId)) {
            return redirect()->to('guru/jenis-ujian')->with('error', 'Kelas harus dipilih.');
        }

        $kelasAccess = $this->db->table('kelas_guru')->where(['guru_id' => $guru['guru_id'], 'kelas_id' => $kelasId])->get()->getRowArray();
        if (!$kelasAccess) {
            return redirect()->to('guru/jenis-ujian')->with('error', 'Anda tidak memiliki akses ke kelas tersebut.');
        }

        $data = [
            'nama_jenis' => $this->request->getPost('nama_jenis'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'kelas_id' => $kelasId,
            'created_by' => $userId
        ];

        try {
            $this->jenisUjianModel->insert($data);
            return redirect()->to('guru/jenis-ujian')->with('success', 'Mata Pelajaran berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->to('guru/jenis-ujian')->with('error', 'Gagal menambahkan data');
        }
    }

    public function edit($id)
    {
        $data = [
            'nama_jenis' => $this->request->getPost('nama_jenis'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'kelas_id' => $this->request->getPost('kelas_id')
        ];

        try {
            $this->jenisUjianModel->update($id, $data);
            return redirect()->to('guru/jenis-ujian')->with('success', 'Mata Pelajaran berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->to('guru/jenis-ujian')->with('error', 'Gagal memperbarui data');
        }
    }

    public function hapus($id)
    {
        try {
            $this->jenisUjianModel->delete($id);
            return redirect()->to('guru/jenis-ujian')->with('success', 'Mata Pelajaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('guru/jenis-ujian')->with('error', 'Gagal menghapus data');
        }
    }
}
