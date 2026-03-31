<?php

namespace App\Controllers\Guru;

use CodeIgniter\Controller;
use App\Models\JadwalUjianModel;
use App\Models\UjianModel;
use App\Models\GuruModel;
use Config\Database;

class JadwalController extends Controller
{
    protected $jadwalUjianModel;
    protected $ujianModel;
    protected $guruModel;
    protected $db;

    public function __construct()
    {
        $this->jadwalUjianModel = new JadwalUjianModel();
        $this->ujianModel = new UjianModel();
        $this->guruModel = new GuruModel();
        $this->db = Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $userId)->first();

        $data['jadwal'] = $this->db->table('jadwal_ujian')
            ->select('jadwal_ujian.*, ujian.nama_ujian, ujian.kode_ujian, kelas.nama_kelas, guru.nama_lengkap')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->join('kelas', 'kelas.kelas_id = jadwal_ujian.kelas_id')
            ->join('guru', 'guru.guru_id = jadwal_ujian.guru_id')
            ->join('kelas_guru', 'kelas_guru.kelas_id = jadwal_ujian.kelas_id')
            ->where('kelas_guru.guru_id', $guru['guru_id'])
            ->orderBy('jadwal_ujian.tanggal_mulai', 'DESC')
            ->get()->getResultArray();

        $data['ujian_tambah'] = $this->ujianModel->getByKelasGuru($guru['guru_id']);
        $data['kelas'] = $this->db->table('kelas')
            ->select('kelas.*')
            ->join('kelas_guru', 'kelas_guru.kelas_id = kelas.kelas_id')
            ->where('kelas_guru.guru_id', $guru['guru_id'])
            ->get()->getResultArray();

        return view('guru/jadwal_ujian', $data);
    }

    public function tambah()
    {
        $data = [
            'ujian_id' => $this->request->getPost('ujian_id'),
            'kelas_id' => $this->request->getPost('kelas_id'),
            'guru_id' => $this->request->getPost('guru_id'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'kode_akses' => $this->request->getPost('kode_akses'),
            'status' => 'belum_mulai'
        ];

        try {
            $this->jadwalUjianModel->insert($data);
            return redirect()->to('guru/jadwal-ujian')->with('success', 'Jadwal berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->to('guru/jadwal-ujian')->with('error', 'Gagal menambahkan jadwal');
        }
    }

    public function edit($id)
    {
        $data = [
            'ujian_id' => $this->request->getPost('ujian_id'),
            'kelas_id' => $this->request->getPost('kelas_id'),
            'guru_id' => $this->request->getPost('guru_id'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'kode_akses' => $this->request->getPost('kode_akses'),
            'status' => $this->request->getPost('status')
        ];

        try {
            $this->jadwalUjianModel->update($id, $data);
            return redirect()->to('guru/jadwal-ujian')->with('success', 'Jadwal berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->to('guru/jadwal-ujian')->with('error', 'Gagal memperbarui jadwal');
        }
    }

    public function hapus($id)
    {
        try {
            $this->jadwalUjianModel->delete($id);
            return redirect()->to('guru/jadwal-ujian')->with('success', 'Jadwal berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('guru/jadwal-ujian')->with('error', 'Gagal menghapus jadwal');
        }
    }
}
