<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\JenisUjianModel;
use App\Models\KelasModel;
use App\Models\SekolahModel;
use Config\Database;

class JenisUjianController extends Controller
{
    protected $db;
    protected $jenisUjianModel;
    protected $kelasModel;
    protected $sekolahModel;

    public function __construct()
    {
        $this->db             = Database::connect();
        $this->jenisUjianModel = new JenisUjianModel();
        $this->kelasModel     = new KelasModel();
        $this->sekolahModel   = new SekolahModel();
    }

    public function daftarJenisUjian()
    {
        $data['jenis_ujian'] = $this->db->table('jenis_ujian ju')
            ->select('ju.*, k.nama_kelas, k.tahun_ajaran, s.nama_sekolah, s.sekolah_id,
                 g.nama_lengkap as guru_pembuat, u.username as user_pembuat,
                 COUNT(DISTINCT uj.id_ujian) as total_ujian')
            ->join('kelas k', 'k.kelas_id = ju.kelas_id', 'left')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id', 'left')
            ->join('users u', 'u.user_id = ju.created_by', 'left')
            ->join('guru g', 'g.user_id = ju.created_by', 'left')
            ->join('ujian uj', 'uj.jenis_ujian_id = ju.jenis_ujian_id', 'left')
            ->groupBy('ju.jenis_ujian_id, ju.nama_jenis, ju.deskripsi, ju.kelas_id, ju.created_by, ju.created_at, ju.updated_at,
                  k.nama_kelas, k.tahun_ajaran, s.nama_sekolah, s.sekolah_id, g.nama_lengkap, u.username')
            ->orderBy('ju.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data['sekolah'] = $this->sekolahModel->findAll();

        $data['kelas'] = $this->db->table('kelas k')
            ->select('k.kelas_id, k.nama_kelas, k.tahun_ajaran, s.nama_sekolah, s.sekolah_id')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id')
            ->orderBy('s.nama_sekolah', 'ASC')
            ->orderBy('k.nama_kelas', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/jenis_ujian/daftar', $data);
    }

    public function jenisUjian()
    {
        $data['jenis_ujian'] = $this->db->table('jenis_ujian ju')
            ->select('ju.*, k.nama_kelas, k.tahun_ajaran, s.nama_sekolah, u.username as creator_name, g.nama_lengkap as guru_nama')
            ->join('kelas k', 'k.kelas_id = ju.kelas_id', 'left')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id', 'left')
            ->join('users u', 'u.user_id = ju.created_by', 'left')
            ->join('guru g', 'g.user_id = u.user_id', 'left')
            ->orderBy('ju.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data['semua_kelas'] = $this->db->table('kelas k')
            ->select('k.kelas_id, k.nama_kelas, k.tahun_ajaran, s.nama_sekolah')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id')
            ->orderBy('s.nama_sekolah', 'ASC')
            ->orderBy('k.nama_kelas', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/jenis_ujian', $data);
    }

    public function tambahJenisUjian()
    {
        $kelasId = $this->request->getPost('kelas_id');
        $userId  = session()->get('user_id');

        $rules = [
            'nama_jenis' => 'required|min_length[3]|max_length[100]',
            'deskripsi'  => 'required|min_length[10]',
            'kelas_id'   => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $kelas = $this->kelasModel->find($kelasId);
        if (!$kelas) {
            session()->setFlashdata('error', 'Kelas tidak ditemukan.');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'nama_jenis'  => $this->request->getPost('nama_jenis'),
                'deskripsi'   => $this->request->getPost('deskripsi'),
                'kelas_id'    => $kelasId,
                'created_by'  => $userId,
            ];

            $this->jenisUjianModel->insert($data);
            session()->setFlashdata('success', 'Mata Pelajaran berhasil ditambahkan!');
            return redirect()->to(base_url('admin/jenis-ujian'));
        } catch (\Exception $e) {
            log_message('error', 'Error adding Mata Pelajaran: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menambah Mata Pelajaran: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function hapusJenisUjian($jenisUjianId)
    {
        try {
            $jenisUjian = $this->jenisUjianModel->find($jenisUjianId);
            if (!$jenisUjian) {
                session()->setFlashdata('error', 'Mata Pelajaran tidak ditemukan.');
                return redirect()->to(base_url('admin/jenis-ujian'));
            }

            $ujianTerkait = $this->db->table('ujian')
                ->where('jenis_ujian_id', $jenisUjianId)
                ->countAllResults();

            if ($ujianTerkait > 0) {
                session()->setFlashdata('error', "Tidak dapat menghapus Mata Pelajaran ini karena masih ada {$ujianTerkait} ujian yang menggunakan Mata Pelajaran ini. Harap hapus ujian terkait terlebih dahulu.");
                return redirect()->to(base_url('admin/jenis-ujian'));
            }

            $this->jenisUjianModel->delete($jenisUjianId);
            session()->setFlashdata('success', 'Mata Pelajaran berhasil dihapus!');
        } catch (\Exception $e) {
            log_message('error', 'Error deleting Mata Pelajaran: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus Mata Pelajaran.');
        }

        return redirect()->to(base_url('admin/jenis-ujian'));
    }
}
