<?php

namespace App\Controllers\Guru;

use CodeIgniter\Controller;
use App\Models\SoalUjianModel;
use App\Models\UjianModel;
use App\Models\GuruModel;
use App\Models\HasilUjianModel;
use Config\Database;

class SoalController extends Controller
{
    protected $soalUjianModel;
    protected $ujianModel;
    protected $guruModel;
    protected $hasilUjianModel;
    protected $db;

    public function __construct()
    {
        $this->soalUjianModel = new SoalUjianModel();
        $this->ujianModel = new UjianModel();
        $this->guruModel = new GuruModel();
        $this->hasilUjianModel = new HasilUjianModel();
        $this->db = Database::connect();
    }

    public function index($ujianId)
    {
        $userId = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $userId)->first();

        if (!$this->ujianModel->hasAccess($ujianId, $guru['guru_id'])) {
            return redirect()->to('guru/ujian')->with('error', 'Akses ditolak.');
        }

        $data = [
            'ujian' => $this->ujianModel->find($ujianId),
            'soal' => $this->soalUjianModel->where('ujian_id', $ujianId)->findAll()
        ];

        return view('guru/kelola_soal', $data);
    }

    public function tambah()
    {
        $data = [
            'ujian_id' => $this->request->getPost('ujian_id'),
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'kode_soal' => $this->request->getPost('kode_soal'),
            'pilihan_a' => $this->request->getPost('pilihan_a'),
            'pilihan_b' => $this->request->getPost('pilihan_b'),
            'pilihan_c' => $this->request->getPost('pilihan_c'),
            'pilihan_d' => $this->request->getPost('pilihan_d'),
            'pilihan_e' => $this->request->getPost('pilihan_e'),
            'jawaban_benar' => $this->request->getPost('jawaban_benar'),
            'tingkat_kesulitan' => $this->request->getPost('tingkat_kesulitan'),
            'pembahasan' => $this->request->getPost('pembahasan'),
            'created_by' => session()->get('user_id')
        ];

        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $newName = $fotoFile->getRandomName();
            $fotoFile->move(FCPATH . 'uploads/soal', $newName);
            $data['foto'] = $newName;
        }

        try {
            $this->soalUjianModel->insert($data);
            return redirect()->to('guru/soal/' . $data['ujian_id'])->with('success', 'Soal berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan soal');
        }
    }

    public function edit($id)
    {
        $soal = $this->soalUjianModel->find($id);
        $data = [
            'kode_soal' => $this->request->getPost('kode_soal'),
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'pilihan_a' => $this->request->getPost('pilihan_a'),
            'pilihan_b' => $this->request->getPost('pilihan_b'),
            'pilihan_c' => $this->request->getPost('pilihan_c'),
            'pilihan_d' => $this->request->getPost('pilihan_d'),
            'pilihan_e' => $this->request->getPost('pilihan_e'),
            'jawaban_benar' => $this->request->getPost('jawaban_benar'),
            'tingkat_kesulitan' => $this->request->getPost('tingkat_kesulitan'),
            'pembahasan' => $this->request->getPost('pembahasan')
        ];

        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile->isValid() && !$fotoFile->hasMoved()) {
            if (!empty($soal['foto']) && file_exists(FCPATH . 'uploads/soal/' . $soal['foto'])) {
                unlink(FCPATH . 'uploads/soal/' . $soal['foto']);
            }
            $newName = $fotoFile->getRandomName();
            $fotoFile->move(FCPATH . 'uploads/soal', $newName);
            $data['foto'] = $newName;
        }

        try {
            $this->soalUjianModel->update($id, $data);
            return redirect()->to('guru/soal/' . $this->request->getPost('ujian_id'))->with('success', 'Soal berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui soal');
        }
    }

    public function hapus($id, $ujianId)
    {
        $isAnswered = $this->hasilUjianModel->where('soal_id', $id)->countAllResults() > 0;
        if ($isAnswered) {
            return redirect()->back()->with('error', 'Soal sudah memiliki riwayat jawaban siswa.');
        }

        $soal = $this->soalUjianModel->find($id);
        if ($soal && !empty($soal['foto']) && file_exists(FCPATH . 'uploads/soal/' . $soal['foto'])) {
            unlink(FCPATH . 'uploads/soal/' . $soal['foto']);
        }

        $this->soalUjianModel->delete($id);
        return redirect()->to('guru/soal/' . $ujianId)->with('success', 'Soal berhasil dihapus');
    }

    public function import()
    {
        // Logika import dari bank soal dipindahkan ke sini
    }
}
