<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\JenisUjianModel;
use App\Models\KelasModel;
use App\Models\SoalUjianModel;
use Config\Database;

class BankSoalController extends Controller
{
    protected $db;
    protected $jenisUjianModel;
    protected $kelasModel;
    protected $soalUjianModel;

    public function __construct()
    {
        $this->db             = Database::connect();
        $this->jenisUjianModel = new JenisUjianModel();
        $this->kelasModel     = new KelasModel();
        $this->soalUjianModel = new SoalUjianModel();
    }

    public function bankSoal()
    {
        $kategoriList = $this->db->table('bank_ujian')
            ->select('kategori, COUNT(*) as jumlah_bank, GROUP_CONCAT(DISTINCT jenis_ujian_id) as jenis_ujian_ids')
            ->groupBy('kategori')
            ->orderBy('kategori', 'ASC')
            ->get()
            ->getResultArray();

        $jenisUjianList = $this->jenisUjianModel->findAll();

        $data = [
            'kategoriList'   => $kategoriList,
            'jenisUjianList' => $jenisUjianList,
        ];

        return view('admin/bank_soal/index', $data);
    }

    public function tambahBankSoal()
    {
        $rules = [
            'kategori'       => 'required',
            'jenis_ujian_id' => 'required|numeric',
            'nama_ujian'     => 'required|min_length[3]',
            'deskripsi'      => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existing = $this->db->table('bank_ujian')
            ->where('kategori', $this->request->getPost('kategori'))
            ->where('jenis_ujian_id', $this->request->getPost('jenis_ujian_id'))
            ->where('nama_ujian', $this->request->getPost('nama_ujian'))
            ->get()->getRowArray();

        if ($existing) {
            session()->setFlashdata('error', 'Bank soal dengan kategori, Mata Pelajaran, dan nama ujian yang sama sudah ada.');
            return redirect()->back()->withInput();
        }

        try {
            $userId = session()->get('user_id');

            if (!$userId) {
                session()->setFlashdata('error', 'Session expired. Please login again.');
                return redirect()->to(base_url('admin/login'));
            }

            $bankUjianData = [
                'kategori'       => $this->request->getPost('kategori'),
                'jenis_ujian_id' => $this->request->getPost('jenis_ujian_id'),
                'nama_ujian'     => $this->request->getPost('nama_ujian'),
                'deskripsi'      => $this->request->getPost('deskripsi'),
                'created_by'     => $userId,
                'created_at'     => date('Y-m-d H:i:s'),
            ];

            $result = $this->db->table('bank_ujian')->insert($bankUjianData);

            if ($result) {
                session()->setFlashdata('success', 'Bank soal berhasil ditambahkan!');
            } else {
                session()->setFlashdata('error', 'Gagal menyimpan bank soal.');
            }

            return redirect()->to(base_url('admin/bank-soal'));
        } catch (\Exception $e) {
            log_message('error', 'Error adding bank soal: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menambah bank soal: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function bankSoalKategori($kategori)
    {
        $jenisUjianList = $this->db->table('bank_ujian')
            ->select('bank_ujian.jenis_ujian_id, jenis_ujian.nama_jenis, COUNT(*) as jumlah_ujian')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = bank_ujian.jenis_ujian_id')
            ->where('bank_ujian.kategori', $kategori)
            ->groupBy('bank_ujian.jenis_ujian_id, jenis_ujian.nama_jenis')
            ->orderBy('jenis_ujian.nama_jenis', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'kategori'       => $kategori,
            'jenisUjianList' => $jenisUjianList,
        ];

        return view('admin/bank_soal/kategori', $data);
    }

    public function editKategori()
    {
        $old_kategori = $this->request->getPost('old_kategori_name');
        $new_kategori = trim($this->request->getPost('new_kategori_name'));

        if (empty($old_kategori) || empty($new_kategori)) {
            session()->setFlashdata('error', 'Nama kategori lama dan baru tidak boleh kosong.');
            return redirect()->to(base_url('admin/bank-soal'));
        }

        if ($old_kategori === $new_kategori) {
            session()->setFlashdata('success', 'Tidak ada perubahan pada nama kategori.');
            return redirect()->to(base_url('admin/bank-soal'));
        }

        $exists = $this->db->table('bank_ujian')->where('kategori', $new_kategori)->countAllResults() > 0;
        if ($exists) {
            session()->setFlashdata('error', "Kategori '{$new_kategori}' sudah ada. Silakan gunakan nama lain.");
            return redirect()->to(base_url('admin/bank-soal'));
        }

        try {
            $this->db->table('bank_ujian')
                ->where('kategori', $old_kategori)
                ->set(['kategori' => $new_kategori])
                ->update();

            session()->setFlashdata('success', "Kategori '{$old_kategori}' berhasil diubah menjadi '{$new_kategori}'.");
        } catch (\Exception $e) {
            log_message('error', 'Error editing kategori bank soal: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat mengubah kategori.');
        }

        return redirect()->to(base_url('admin/bank-soal'));
    }

    public function hapusKategori($kategori)
    {
        $kategori = urldecode($kategori);

        try {
            $soalCount = $this->db->table('soal_ujian su')
                ->join('bank_ujian bu', 'su.bank_ujian_id = bu.bank_ujian_id')
                ->where('bu.kategori', $kategori)
                ->where('su.is_bank_soal', true)
                ->countAllResults();

            if ($soalCount > 0) {
                session()->setFlashdata('error', "Tidak dapat menghapus kategori '{$kategori}' karena masih berisi {$soalCount} soal. Hapus soal-soal di dalamnya terlebih dahulu.");
                return redirect()->to(base_url('admin/bank-soal'));
            }

            $this->db->table('bank_ujian')->where('kategori', $kategori)->delete();
            session()->setFlashdata('success', "Kategori '{$kategori}' dan semua bank ujian di dalamnya yang tidak memiliki soal berhasil dihapus.");
        } catch (\Exception $e) {
            log_message('error', 'Error deleting kategori bank soal: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus kategori.');
        }

        return redirect()->to(base_url('admin/bank-soal'));
    }

    public function editJenisUjian($jenisUjianId)
    {
        $redirectUrl = $this->request->getPost('_redirect_url') ?: base_url('admin/jenis-ujian');

        $rules = [
            'nama_jenis' => 'required|min_length[3]|max_length[100]',
            'deskripsi'  => 'required|min_length[10]',
            'kelas_id'   => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to($redirectUrl)->withInput()->with('errors', $this->validator->getErrors());
        }

        $jenisUjian = $this->jenisUjianModel->find($jenisUjianId);
        if (!$jenisUjian) {
            session()->setFlashdata('error', 'Mata Pelajaran tidak ditemukan.');
            return redirect()->to($redirectUrl);
        }

        $kelasId = $this->request->getPost('kelas_id');
        $kelas   = $this->kelasModel->find($kelasId);
        if (!$kelas) {
            session()->setFlashdata('error', 'Kelas tidak ditemukan.');
            return redirect()->to($redirectUrl)->withInput();
        }

        try {
            $data = [
                'nama_jenis' => $this->request->getPost('nama_jenis'),
                'deskripsi'  => $this->request->getPost('deskripsi'),
                'kelas_id'   => $kelasId,
            ];

            $this->jenisUjianModel->update($jenisUjianId, $data);
            session()->setFlashdata('success', 'Mata Pelajaran berhasil diperbarui!');
            return redirect()->to($redirectUrl);
        } catch (\Exception $e) {
            log_message('error', 'Error updating Mata Pelajaran: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat memperbarui Mata Pelajaran: ' . $e->getMessage());
            return redirect()->to($redirectUrl)->withInput();
        }
    }

    public function bankSoalJenisUjian($kategori, $jenisUjianId)
    {
        $ujianList = $this->db->table('bank_ujian')
            ->select('bank_ujian.*, users.username as creator_name,
                 (SELECT COUNT(*) FROM soal_ujian WHERE soal_ujian.bank_ujian_id = bank_ujian.bank_ujian_id AND soal_ujian.is_bank_soal = 1) as jumlah_soal')
            ->join('users', 'users.user_id = bank_ujian.created_by')
            ->where('bank_ujian.kategori', $kategori)
            ->where('bank_ujian.jenis_ujian_id', $jenisUjianId)
            ->orderBy('bank_ujian.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $jenisUjian = $this->jenisUjianModel->find($jenisUjianId);

        $data = [
            'kategori'    => $kategori,
            'jenisUjian'  => $jenisUjian,
            'ujianList'   => $ujianList,
        ];

        return view('admin/bank_soal/jenis_ujian', $data);
    }

    public function bankSoalUjian($kategori, $jenisUjianId, $bankUjianId)
    {
        $bankUjian = $this->db->table('bank_ujian')
            ->select('bank_ujian.*, jenis_ujian.nama_jenis, users.username as creator_name')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = bank_ujian.jenis_ujian_id')
            ->join('users', 'users.user_id = bank_ujian.created_by')
            ->where('bank_ujian.bank_ujian_id', $bankUjianId)
            ->get()
            ->getRowArray();

        if (!$bankUjian) {
            session()->setFlashdata('error', 'Bank ujian tidak ditemukan');
            return redirect()->to(base_url('admin/bank-soal'));
        }

        $soalList = $this->db->table('soal_ujian')
            ->select('soal_ujian.*, users.username as creator_name')
            ->join('users', 'users.user_id = soal_ujian.created_by', 'left')
            ->where('bank_ujian_id', $bankUjianId)
            ->where('is_bank_soal', true)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'kategori'  => $kategori,
            'bankUjian' => $bankUjian,
            'soalList'  => $soalList,
            'canEdit'   => true,
        ];

        return view('admin/bank_soal/ujian', $data);
    }

    public function tambahSoalBankUjian()
    {
        $bankUjianId = $this->request->getPost('bank_ujian_id');
        $userId      = session()->get('user_id');

        $bankUjian = $this->db->table('bank_ujian')->where('bank_ujian_id', $bankUjianId)->get()->getRowArray();
        if (!$bankUjian) {
            return redirect()->back()->with('error', 'Bank ujian tidak ditemukan');
        }

        $rules = [
            'kode_soal'         => 'required|alpha_numeric_punct|min_length[3]|max_length[50]',
            'pertanyaan'        => 'required',
            'pilihan_a'         => 'required',
            'pilihan_b'         => 'required',
            'pilihan_c'         => 'required',
            'pilihan_d'         => 'required',
            'jawaban_benar'     => 'required|in_list[A,B,C,D,E]',
            'tingkat_kesulitan' => 'required|decimal',
            'foto'              => 'max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]|ext_in[foto,png,jpg,jpeg]',
            'pembahasan'        => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            $errorMessage = 'Validasi gagal: ' . implode(', ', $this->validator->getErrors());
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        $data = [
            'ujian_id'          => null,
            'bank_ujian_id'     => $bankUjianId,
            'is_bank_soal'      => true,
            'created_by'        => $userId,
            'kode_soal'         => $this->request->getPost('kode_soal'),
            'pertanyaan'        => $this->request->getPost('pertanyaan'),
            'pilihan_a'         => $this->request->getPost('pilihan_a'),
            'pilihan_b'         => $this->request->getPost('pilihan_b'),
            'pilihan_c'         => $this->request->getPost('pilihan_c'),
            'pilihan_d'         => $this->request->getPost('pilihan_d'),
            'pilihan_e'         => $this->request->getPost('pilihan_e'),
            'jawaban_benar'     => $this->request->getPost('jawaban_benar'),
            'tingkat_kesulitan' => $this->request->getPost('tingkat_kesulitan'),
            'pembahasan'        => $this->request->getPost('pembahasan'),
        ];

        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $newName    = $fotoFile->getRandomName();
            $uploadPath = FCPATH . 'uploads/soal';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $fotoFile->move($uploadPath, $newName);
            $data['foto'] = $newName;
        }

        try {
            $this->soalUjianModel->insert($data);
            session()->setFlashdata('success', 'Soal berhasil ditambahkan ke bank ujian!');
            return redirect()->back();
        } catch (\Exception $e) {
            log_message('error', 'Error saat menambahkan soal bank ujian: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan soal: ' . $e->getMessage());
        }
    }

    public function editSoalBankUjian($soalId)
    {
        $soal = $this->soalUjianModel->find($soalId);
        if (!$soal || !$soal['is_bank_soal']) {
            return redirect()->back()->with('error', 'Soal tidak ditemukan');
        }

        $rules = [
            'kode_soal'         => 'required|alpha_numeric_punct|min_length[3]|max_length[50]',
            'pertanyaan'        => 'required',
            'pilihan_a'         => 'required',
            'pilihan_b'         => 'required',
            'pilihan_c'         => 'required',
            'pilihan_d'         => 'required',
            'jawaban_benar'     => 'required|in_list[A,B,C,D,E]',
            'tingkat_kesulitan' => 'required|decimal',
            'foto'              => 'max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]|ext_in[foto,png,jpg,jpeg]',
            'pembahasan'        => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            $errorMessage = 'Validasi gagal: ' . implode(', ', $this->validator->getErrors());
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        $data = [
            'kode_soal'         => $this->request->getPost('kode_soal'),
            'pertanyaan'        => $this->request->getPost('pertanyaan'),
            'pilihan_a'         => $this->request->getPost('pilihan_a'),
            'pilihan_b'         => $this->request->getPost('pilihan_b'),
            'pilihan_c'         => $this->request->getPost('pilihan_c'),
            'pilihan_d'         => $this->request->getPost('pilihan_d'),
            'pilihan_e'         => $this->request->getPost('pilihan_e'),
            'jawaban_benar'     => $this->request->getPost('jawaban_benar'),
            'tingkat_kesulitan' => $this->request->getPost('tingkat_kesulitan'),
            'pembahasan'        => $this->request->getPost('pembahasan'),
        ];

        $uploadPath = FCPATH . 'uploads/soal';
        $fotoFile   = $this->request->getFile('foto');

        if ($fotoFile->isValid() && !$fotoFile->hasMoved()) {
            if (!empty($soal['foto'])) {
                $fotoPath = $uploadPath . '/' . $soal['foto'];
                if (file_exists($fotoPath)) {
                    unlink($fotoPath);
                }
            }
            $newName = $fotoFile->getRandomName();
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $fotoFile->move($uploadPath, $newName);
            $data['foto'] = $newName;
        }

        if ($this->request->getPost('hapus_foto') == '1' && !empty($soal['foto'])) {
            $fotoPath = $uploadPath . '/' . $soal['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
            $data['foto'] = null;
        }

        try {
            $this->soalUjianModel->update($soalId, $data);
            session()->setFlashdata('success', 'Soal berhasil diupdate!');
            return redirect()->back();
        } catch (\Exception $e) {
            log_message('error', 'Error saat mengupdate soal bank ujian: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui soal: ' . $e->getMessage());
        }
    }

    public function hapusSoalBankUjian($soalId)
    {
        $soal = $this->soalUjianModel->find($soalId);
        if (!$soal || !$soal['is_bank_soal']) {
            return redirect()->back()->with('error', 'Soal tidak ditemukan');
        }

        if (!empty($soal['foto'])) {
            $fotoPath = FCPATH . 'uploads/soal/' . $soal['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        try {
            $this->soalUjianModel->delete($soalId);
            session()->setFlashdata('success', 'Soal berhasil dihapus!');
            return redirect()->back();
        } catch (\Exception $e) {
            log_message('error', 'Error saat menghapus soal bank ujian: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus soal.');
        }
    }

    public function hapusBankUjian($bankUjianId)
    {
        $bankUjian = $this->db->table('bank_ujian')->where('bank_ujian_id', $bankUjianId)->get()->getRowArray();
        if (!$bankUjian) {
            session()->setFlashdata('error', 'Bank ujian tidak ditemukan.');
            return redirect()->to(base_url('admin/bank-soal'));
        }

        try {
            $this->db->transStart();

            $jumlahSoal = $this->db->table('soal_ujian')
                ->where('bank_ujian_id', $bankUjianId)
                ->where('is_bank_soal', true)
                ->countAllResults();

            if ($jumlahSoal > 0) {
                session()->setFlashdata('error', "Tidak dapat menghapus bank ujian karena masih memiliki {$jumlahSoal} soal. Hapus soal terlebih dahulu.");
                return redirect()->back();
            }

            $this->db->table('bank_ujian')->where('bank_ujian_id', $bankUjianId)->delete();
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            session()->setFlashdata('success', 'Bank ujian berhasil dihapus!');
        } catch (\Exception $e) {
            log_message('error', 'Error deleting bank ujian: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus bank ujian.');
        }

        return redirect()->to(base_url('admin/bank-soal/kategori/' . urlencode($bankUjian['kategori']) . '/jenis-ujian/' . $bankUjian['jenis_ujian_id']));
    }

    // ===== API / AJAX =====

    public function getKategoriTersedia()
    {
        try {
            $kategoriData = $this->db->table('bank_ujian')
                ->select('kategori')
                ->distinct()
                ->orderBy('kategori', 'ASC')
                ->get()
                ->getResultArray();

            $kategoriList = array_column($kategoriData, 'kategori');

            return $this->response->setJSON(['status' => 'success', 'data' => $kategoriList]);
        } catch (\Exception $e) {
            log_message('error', '[BankSoalController::getKategoriTersedia] ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal memuat kategori.']);
        }
    }

    public function getJenisUjianByKategori()
    {
        $kategori = $this->request->getGet('kategori');
        if (!$kategori) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Kategori harus dipilih']);
        }

        try {
            $jenisUjian = $this->db->table('bank_ujian')
                ->select('bank_ujian.jenis_ujian_id, jenis_ujian.nama_jenis, COUNT(*) as jumlah_bank')
                ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = bank_ujian.jenis_ujian_id')
                ->where('bank_ujian.kategori', $kategori)
                ->groupBy('bank_ujian.jenis_ujian_id, jenis_ujian.nama_jenis')
                ->orderBy('jenis_ujian.nama_jenis', 'ASC')
                ->get()->getResultArray();

            return $this->response->setJSON(['status' => 'success', 'data' => $jenisUjian]);
        } catch (\Exception $e) {
            log_message('error', '[BankSoalController::getJenisUjianByKategori] ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal memuat mata pelajaran.']);
        }
    }

    public function getBankUjianByKategoriJenis()
    {
        $kategori     = $this->request->getGet('kategori');
        $jenisUjianId = $this->request->getGet('jenis_ujian_id');

        if (!$kategori || !$jenisUjianId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Kategori dan Mata Pelajaran harus dipilih']);
        }

        try {
            $bankUjian = $this->db->table('bank_ujian')
                ->select('bank_ujian.*, users.username as creator_name, (SELECT COUNT(*) FROM soal_ujian WHERE soal_ujian.bank_ujian_id = bank_ujian.bank_ujian_id AND soal_ujian.is_bank_soal = 1) as jumlah_soal')
                ->join('users', 'users.user_id = bank_ujian.created_by')
                ->where('bank_ujian.kategori', $kategori)
                ->where('bank_ujian.jenis_ujian_id', $jenisUjianId)
                ->orderBy('bank_ujian.created_at', 'DESC')
                ->get()->getResultArray();

            return $this->response->setJSON(['status' => 'success', 'data' => $bankUjian]);
        } catch (\Exception $e) {
            log_message('error', '[BankSoalController::getBankUjianByKategoriJenis] ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal memuat bank ujian.']);
        }
    }

    public function getSoalBankUjian()
    {
        $bankUjianId = $this->request->getGet('bank_ujian_id');

        if (!$bankUjianId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Bank ujian harus dipilih']);
        }

        try {
            $bankUjian = $this->db->table('bank_ujian')->where('bank_ujian_id', $bankUjianId)->get()->getRowArray();
            if (!$bankUjian) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Bank ujian tidak ditemukan']);
            }

            $soalList = $this->soalUjianModel
                ->select('soal_ujian.*')
                ->where('bank_ujian_id', $bankUjianId)
                ->where('is_bank_soal', true)
                ->orderBy('created_at', 'DESC')
                ->findAll();

            return $this->response->setJSON(['status' => 'success', 'data' => $soalList, 'bank_ujian' => $bankUjian]);
        } catch (\Exception $e) {
            log_message('error', '[BankSoalController::getSoalBankUjian] ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal memuat soal.']);
        }
    }
}
