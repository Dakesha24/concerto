<?php

namespace App\Controllers\Guru;

use CodeIgniter\Controller;
use App\Models\UjianModel;
use App\Models\JenisUjianModel;
use App\Models\GuruModel;
use App\Models\SoalUjianModel;
use Config\Database;

class UjianController extends Controller
{
    protected $ujianModel;
    protected $jenisUjianModel;
    protected $guruModel;
    protected $soalUjianModel;
    protected $db;

    public function __construct()
    {
        $this->ujianModel = new UjianModel();
        $this->jenisUjianModel = new JenisUjianModel();
        $this->guruModel = new GuruModel();
        $this->soalUjianModel = new SoalUjianModel();
        $this->db = Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $userId)->first();

        $data['ujian'] = $this->ujianModel->getByKelasGuru($guru['guru_id']);
        $data['jenis_ujian'] = $this->jenisUjianModel->getByKelasGuru($guru['guru_id']);
        $data['kelas_guru'] = $this->db->table('kelas')
            ->select('kelas.*')
            ->join('kelas_guru', 'kelas_guru.kelas_id = kelas.kelas_id')
            ->where('kelas_guru.guru_id', $guru['guru_id'])
            ->get()->getResultArray();

        return view('guru/ujian', $data);
    }

    public function tambah()
    {
        $userId = session()->get('user_id');

        $useWaktu   = $this->request->getPost('use_waktu')    ? 1 : 0;
        $useSeMin   = $this->request->getPost('use_se_min')   ? 1 : 0;
        $useDeltaSe = $this->request->getPost('use_delta_se') ? 1 : 0;
        $useMaxSoal = $this->request->getPost('use_max_soal') ? 1 : 0;

        if (!$useWaktu && !$useSeMin && !$useDeltaSe && !$useMaxSoal) {
            return redirect()->to('guru/ujian')->with('error', 'Minimal satu stopping rule harus diaktifkan.');
        }

        $data = [
            'jenis_ujian_id'        => $this->request->getPost('jenis_ujian_id'),
            'nama_ujian'            => $this->request->getPost('nama_ujian'),
            'kode_ujian'            => $this->request->getPost('kode_ujian'),
            'deskripsi'             => $this->request->getPost('deskripsi'),
            'se_awal'               => $this->request->getPost('se_awal'),
            'se_minimum'            => $this->request->getPost('se_minimum'),
            'delta_se_minimum'      => $this->request->getPost('delta_se_minimum'),
            'maksimal_soal_tampil'  => $this->request->getPost('maksimal_soal_tampil') ?: 30,
            'durasi'                => $this->request->getPost('durasi'),
            'kelas_id'              => $this->request->getPost('kelas_id'),
            'created_by'            => $userId,
            'use_waktu'             => $useWaktu,
            'use_se_min'            => $useSeMin,
            'use_delta_se'          => $useDeltaSe,
            'use_max_soal'          => $useMaxSoal,
            'tampilkan_pembahasan'  => $this->request->getPost('tampilkan_pembahasan') ? 1 : 0,
        ];

        try {
            $this->ujianModel->insert($data);
            return redirect()->to('guru/ujian')->with('success', 'Ujian berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->to('guru/ujian')->with('error', 'Gagal menambahkan ujian');
        }
    }

    public function edit($id)
    {
        $useWaktu   = $this->request->getPost('use_waktu')    ? 1 : 0;
        $useSeMin   = $this->request->getPost('use_se_min')   ? 1 : 0;
        $useDeltaSe = $this->request->getPost('use_delta_se') ? 1 : 0;
        $useMaxSoal = $this->request->getPost('use_max_soal') ? 1 : 0;

        if (!$useWaktu && !$useSeMin && !$useDeltaSe && !$useMaxSoal) {
            return redirect()->to('guru/ujian')->with('error', 'Minimal satu stopping rule harus diaktifkan.');
        }

        $data = [
            'jenis_ujian_id'        => $this->request->getPost('jenis_ujian_id'),
            'nama_ujian'            => $this->request->getPost('nama_ujian'),
            'kode_ujian'            => $this->request->getPost('kode_ujian'),
            'deskripsi'             => $this->request->getPost('deskripsi'),
            'se_awal'               => $this->request->getPost('se_awal'),
            'se_minimum'            => $this->request->getPost('se_minimum'),
            'delta_se_minimum'      => $this->request->getPost('delta_se_minimum'),
            'maksimal_soal_tampil'  => $this->request->getPost('maksimal_soal_tampil') ?: 30,
            'durasi'                => $this->request->getPost('durasi'),
            'kelas_id'              => $this->request->getPost('kelas_id'),
            'use_waktu'             => $useWaktu,
            'use_se_min'            => $useSeMin,
            'use_delta_se'          => $useDeltaSe,
            'use_max_soal'          => $useMaxSoal,
            'tampilkan_pembahasan'  => $this->request->getPost('tampilkan_pembahasan') ? 1 : 0,
        ];

        try {
            $this->ujianModel->update($id, $data);
            return redirect()->to('guru/ujian')->with('success', 'Ujian berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->to('guru/ujian')->with('error', 'Gagal memperbarui ujian');
        }
    }

    public function hapus($id)
    {
        $soalTerkait = $this->soalUjianModel->where('ujian_id', $id)->countAllResults();
        if ($soalTerkait > 0) {
            return redirect()->to('guru/ujian')->with('error', 'Hapus soal-soal terkait terlebih dahulu.');
        }

        try {
            $this->ujianModel->delete($id);
            return redirect()->to('guru/ujian')->with('success', 'Ujian berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('guru/ujian')->with('error', 'Gagal menghapus ujian');
        }
    }
}
