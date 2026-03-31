<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\UjianModel;
use App\Models\JenisUjianModel;
use App\Models\KelasModel;
use App\Models\SoalUjianModel;
use App\Models\SekolahModel;
use App\Models\GuruModel;

class UjianController extends Controller
{
    protected $ujianModel;
    protected $jenisUjianModel;
    protected $kelasModel;
    protected $soalUjianModel;
    protected $sekolahModel;
    protected $guruModel;

    public function __construct()
    {
        $this->ujianModel      = new UjianModel();
        $this->jenisUjianModel = new JenisUjianModel();
        $this->kelasModel      = new KelasModel();
        $this->soalUjianModel  = new SoalUjianModel();
        $this->sekolahModel    = new SekolahModel();
        $this->guruModel       = new GuruModel();
    }

    public function ujian()
    {
        $data['ujian'] = $this->ujianModel
            ->select('ujian.*, jenis_ujian.nama_jenis, kelas.nama_kelas, sekolah.nama_sekolah, g.nama_lengkap as guru_pembuat')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = ujian.jenis_ujian_id', 'left')
            ->join('kelas', 'kelas.kelas_id = ujian.kelas_id', 'left')
            ->join('sekolah', 'sekolah.sekolah_id = kelas.sekolah_id', 'left')
            ->join('users u', 'u.user_id = ujian.created_by', 'left')
            ->join('guru g', 'g.user_id = u.user_id', 'left')
            ->orderBy('ujian.created_at', 'DESC')
            ->findAll();

        $data['jenis_ujian'] = $this->jenisUjianModel
            ->select('jenis_ujian.*, kelas.nama_kelas, sekolah.nama_sekolah')
            ->join('kelas', 'kelas.kelas_id = jenis_ujian.kelas_id', 'left')
            ->join('sekolah', 'sekolah.sekolah_id = kelas.sekolah_id', 'left')
            ->findAll();

        $data['kelas_guru'] = $this->kelasModel
            ->select('kelas.*, sekolah.nama_sekolah')
            ->join('sekolah', 'sekolah.sekolah_id = kelas.sekolah_id', 'left')
            ->orderBy('sekolah.nama_sekolah', 'ASC')
            ->orderBy('kelas.nama_kelas', 'ASC')
            ->findAll();

        $data['sekolah'] = $this->sekolahModel->orderBy('nama_sekolah', 'ASC')->findAll();

        return view('admin/ujian/daftar', $data);
    }

    public function tambahUjian()
    {
        $rules = [
            'jenis_ujian_id'    => 'required|numeric',
            'nama_ujian'        => 'required|min_length[3]|max_length[255]',
            'kode_ujian'        => 'required|alpha_numeric_punct|min_length[3]|max_length[50]',
            'deskripsi'         => 'required|min_length[10]',
            'se_awal'           => 'required|decimal',
            'se_minimum'        => 'required|decimal',
            'delta_se_minimum'  => 'required|decimal',
            'durasi'            => 'required',
            'kelas_id'          => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'jenis_ujian_id'    => $this->request->getPost('jenis_ujian_id'),
            'nama_ujian'        => $this->request->getPost('nama_ujian'),
            'kode_ujian'        => $this->request->getPost('kode_ujian'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'se_awal'           => $this->request->getPost('se_awal'),
            'se_minimum'        => $this->request->getPost('se_minimum'),
            'delta_se_minimum'  => $this->request->getPost('delta_se_minimum'),
            'durasi'            => $this->request->getPost('durasi'),
            'kelas_id'          => $this->request->getPost('kelas_id') ?: null,
            'created_by'        => session()->get('user_id'),
        ];

        try {
            $this->ujianModel->insert($data);
            return redirect()->to('admin/ujian/')->with('success', 'Ujian berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->to('admin/ujian/')->with('error', 'Gagal menambahkan ujian: ' . $e->getMessage());
        }
    }

    public function editUjian($id)
    {
        $ujian = $this->ujianModel->find($id);
        if (!$ujian) {
            return redirect()->to('admin/ujian/')->with('error', 'Ujian tidak ditemukan.');
        }

        $rules = [
            'jenis_ujian_id'    => 'required|numeric',
            'nama_ujian'        => 'required|min_length[3]|max_length[255]',
            'kode_ujian'        => "required|alpha_numeric_punct|min_length[3]|max_length[50]|is_unique[ujian.kode_ujian,id_ujian,{$id}]",
            'deskripsi'         => 'required|min_length[10]',
            'se_awal'           => 'required|decimal',
            'se_minimum'        => 'required|decimal',
            'delta_se_minimum'  => 'required|decimal',
            'durasi'            => 'required',
            'kelas_id'          => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'jenis_ujian_id'    => $this->request->getPost('jenis_ujian_id'),
            'nama_ujian'        => $this->request->getPost('nama_ujian'),
            'kode_ujian'        => $this->request->getPost('kode_ujian'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'se_awal'           => $this->request->getPost('se_awal'),
            'se_minimum'        => $this->request->getPost('se_minimum'),
            'delta_se_minimum'  => $this->request->getPost('delta_se_minimum'),
            'durasi'            => $this->request->getPost('durasi'),
            'kelas_id'          => $this->request->getPost('kelas_id') ?: null,
        ];

        try {
            $this->ujianModel->update($id, $data);
            return redirect()->to('admin/ujian/')->with('success', 'Ujian berhasil diperbarui.');
        } catch (\Exception $e) {
            log_message('error', 'Admin gagal mengupdate ujian: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data ujian.');
        }
    }

    public function hapusUjian($id)
    {
        $soalTerkait = $this->soalUjianModel->where('ujian_id', $id)->countAllResults();
        if ($soalTerkait > 0) {
            return redirect()->to('admin/ujian/')
                ->with('error', 'Gagal! Tidak dapat menghapus ujian karena masih ada ' . $soalTerkait . ' soal terkait.');
        }

        try {
            $this->ujianModel->delete($id);
            return redirect()->to('admin/ujian/')->with('success', 'Ujian berhasil dihapus secara permanen.');
        } catch (\Exception $e) {
            log_message('error', 'Admin gagal menghapus ujian: ' . $e->getMessage());
            return redirect()->to('admin/ujian/')->with('error', 'Terjadi kesalahan saat menghapus ujian.');
        }
    }
}
