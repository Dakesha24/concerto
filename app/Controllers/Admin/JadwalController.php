<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\JadwalUjianModel;
use App\Models\UjianModel;
use App\Models\KelasModel;
use App\Models\SekolahModel;
use App\Models\PesertaUjianModel;
use App\Models\JenisUjianModel;
use Config\Database;

class JadwalController extends Controller
{
    protected $db;
    protected $jadwalUjianModel;
    protected $ujianModel;
    protected $kelasModel;
    protected $sekolahModel;
    protected $pesertaUjianModel;
    protected $jenisUjianModel;

    public function __construct()
    {
        $this->db                = Database::connect();
        $this->jadwalUjianModel  = new JadwalUjianModel();
        $this->ujianModel        = new UjianModel();
        $this->kelasModel        = new KelasModel();
        $this->sekolahModel      = new SekolahModel();
        $this->pesertaUjianModel = new PesertaUjianModel();
        $this->jenisUjianModel   = new JenisUjianModel();
    }

    public function jadwalUjian()
    {
        $data['jadwal'] = $this->db->table('jadwal_ujian')
            ->select('jadwal_ujian.*, ujian.nama_ujian, ujian.kode_ujian, kelas.nama_kelas, sekolah.nama_sekolah, sekolah.sekolah_id, guru.nama_lengkap')
            ->join('ujian', 'ujian.id_ujian = jadwal_ujian.ujian_id')
            ->join('kelas', 'kelas.kelas_id = jadwal_ujian.kelas_id')
            ->join('sekolah', 'sekolah.sekolah_id = kelas.sekolah_id')
            ->join('guru', 'guru.guru_id = jadwal_ujian.guru_id')
            ->orderBy('jadwal_ujian.tanggal_mulai', 'DESC')
            ->get()->getResultArray();

        $data['sekolah'] = $this->sekolahModel->orderBy('nama_sekolah', 'ASC')->findAll();

        $data['guru'] = $this->db->table('guru')
            ->select('guru.*, sekolah.nama_sekolah')
            ->join('sekolah', 'sekolah.sekolah_id = guru.sekolah_id')
            ->orderBy('sekolah.nama_sekolah', 'ASC')
            ->orderBy('guru.nama_lengkap', 'ASC')
            ->get()->getResultArray();

        return view('admin/jadwal/jadwal_ujian', $data);
    }

    public function tambahJadwal()
    {
        $sekolah_id       = $this->request->getPost('sekolah_id');
        $ujian_id         = $this->request->getPost('ujian_id');
        $kelas_id         = $this->request->getPost('kelas_id');
        $guru_pengawas_id = $this->request->getPost('guru_id');

        $kelas = $this->kelasModel->find($kelas_id);
        if (!$kelas || $kelas['sekolah_id'] != $sekolah_id) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Data kelas tidak valid atau tidak sesuai dengan sekolah yang dipilih.');
        }

        $ujian = $this->ujianModel->find($ujian_id);
        if (!$ujian) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Ujian tidak ditemukan.');
        }

        if ($ujian['kelas_id'] !== null && $ujian['kelas_id'] != $kelas_id) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Ujian ini tidak tersedia untuk kelas yang dipilih.');
        }

        $existing = $this->jadwalUjianModel->where('ujian_id', $ujian_id)->where('kelas_id', $kelas_id)->first();
        if ($existing) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Jadwal ujian untuk kelas ini sudah ada.');
        }

        $tanggalMulai   = $this->request->getPost('tanggal_mulai');
        $tanggalSelesai = $this->request->getPost('tanggal_selesai');

        if (strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Waktu selesai harus lebih besar dari waktu mulai.');
        }

        $data = [
            'ujian_id'        => $ujian_id,
            'kelas_id'        => $kelas_id,
            'guru_id'         => $guru_pengawas_id,
            'tanggal_mulai'   => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'kode_akses'      => $this->request->getPost('kode_akses'),
            'status'          => 'belum_mulai',
        ];

        try {
            $this->jadwalUjianModel->insert($data);
            return redirect()->to('admin/jadwal-ujian')->with('success', 'Jadwal ujian berhasil ditambahkan');
        } catch (\Exception $e) {
            log_message('error', 'Admin gagal menambahkan jadwal: ' . $e->getMessage());
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Gagal menambahkan jadwal ujian: ' . $e->getMessage());
        }
    }

    public function editJadwal($id)
    {
        $jadwal = $this->jadwalUjianModel->find($id);
        if (!$jadwal) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Jadwal ujian tidak ditemukan.');
        }

        $sekolah_id       = $this->request->getPost('sekolah_id');
        $ujian_id         = $this->request->getPost('ujian_id');
        $kelas_id         = $this->request->getPost('kelas_id');
        $guru_pengawas_id = $this->request->getPost('guru_id');

        $kelas = $this->kelasModel->find($kelas_id);
        if (!$kelas || $kelas['sekolah_id'] != $sekolah_id) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Data kelas tidak valid atau tidak sesuai dengan sekolah yang dipilih.');
        }

        $ujian = $this->ujianModel->find($ujian_id);
        if (!$ujian) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Ujian tidak ditemukan.');
        }

        if ($ujian['kelas_id'] !== null && $ujian['kelas_id'] != $kelas_id) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Ujian ini tidak tersedia untuk kelas yang dipilih.');
        }

        $existing = $this->jadwalUjianModel->where('ujian_id', $ujian_id)->where('kelas_id', $kelas_id)->where('jadwal_id !=', $id)->first();
        if ($existing) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Jadwal ujian untuk kelas ini sudah ada.');
        }

        $tanggalMulai   = $this->request->getPost('tanggal_mulai');
        $tanggalSelesai = $this->request->getPost('tanggal_selesai');

        if (strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Waktu selesai harus lebih besar dari waktu mulai.');
        }

        $data = [
            'ujian_id'        => $ujian_id,
            'kelas_id'        => $kelas_id,
            'guru_id'         => $guru_pengawas_id,
            'tanggal_mulai'   => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'kode_akses'      => $this->request->getPost('kode_akses'),
            'status'          => $this->request->getPost('status'),
        ];

        try {
            $this->jadwalUjianModel->update($id, $data);
            return redirect()->to('admin/jadwal-ujian')->with('success', 'Jadwal ujian berhasil diupdate');
        } catch (\Exception $e) {
            log_message('error', 'Admin gagal mengupdate jadwal: ' . $e->getMessage());
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Gagal mengupdate jadwal ujian: ' . $e->getMessage());
        }
    }

    public function hapusJadwal($id)
    {
        $pesertaTerkait = $this->pesertaUjianModel->where('jadwal_id', $id)->countAllResults();
        if ($pesertaTerkait > 0) {
            return redirect()->to('admin/jadwal-ujian')
                ->with('error', 'Gagal! Jadwal ini tidak dapat dihapus karena sudah memiliki ' . $pesertaTerkait . ' peserta terdaftar.');
        }

        try {
            $this->jadwalUjianModel->delete($id);
            return redirect()->to('admin/jadwal-ujian')->with('success', 'Jadwal ujian berhasil dihapus.');
        } catch (\Exception $e) {
            log_message('error', 'Admin gagal hapus jadwal: ' . $e->getMessage());
            return redirect()->to('admin/jadwal-ujian')->with('error', 'Terjadi kesalahan saat menghapus jadwal ujian.');
        }
    }
}
