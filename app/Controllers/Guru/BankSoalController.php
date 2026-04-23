<?php

namespace App\Controllers\Guru;

use CodeIgniter\Controller;
use App\Models\GuruModel;
use App\Models\JenisUjianModel;
use App\Models\SoalUjianModel;
use Config\Database;

class BankSoalController extends Controller
{
    protected $guruModel;
    protected $jenisUjianModel;
    protected $soalUjianModel;
    protected $db;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->jenisUjianModel = new JenisUjianModel();
        $this->soalUjianModel = new SoalUjianModel();
        $this->db = Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $userId)->first();

        if (!$guru) {
            return redirect()->to('login')->with('error', 'Data guru tidak ditemukan.');
        }

        $kelasGuru = $this->db->table('kelas_guru')
            ->select('kelas.kelas_id, kelas.nama_kelas')
            ->join('kelas', 'kelas.kelas_id = kelas_guru.kelas_id')
            ->where('kelas_guru.guru_id', $guru['guru_id'])
            ->get()->getResultArray();

        $data = [
            'kelasGuru' => $kelasGuru,
            'jenis_ujian' => $this->jenisUjianModel->findAll()
        ];

        return view('guru/bank_soal/index', $data);
    }

    public function tambah()
    {
        $data = [
            'kategori' => $this->request->getPost('kategori'),
            'jenis_ujian_id' => $this->request->getPost('jenis_ujian_id'),
            'nama_ujian' => $this->request->getPost('nama_ujian'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'created_by' => session()->get('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            $this->db->table('bank_ujian')->insert($data);
            return redirect()->to('guru/bank-soal')->with('success', 'Bank soal berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->to('guru/bank-soal')->with('error', 'Gagal menambahkan bank soal');
        }
    }

    public function kategori($kategori)
    {
        $kategori = $this->normalizeKategori($kategori);

        if (!$this->guruHasKategoriAccess($kategori)) {
            return redirect()->to('guru/bank-soal')->with('error', 'Anda tidak memiliki akses ke kategori bank soal tersebut.');
        }

        $jenisUjianList = $this->db->table('bank_ujian')
            ->select('bank_ujian.jenis_ujian_id, jenis_ujian.nama_jenis, COUNT(*) as jumlah_ujian')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = bank_ujian.jenis_ujian_id')
            ->where('bank_ujian.kategori', $kategori)
            ->groupBy('bank_ujian.jenis_ujian_id')
            ->get()->getResultArray();

        return view('guru/bank_soal/kategori', ['kategori' => $kategori, 'jenisUjianList' => $jenisUjianList]);
    }

    public function jenisUjian($kategori, $jenisUjianId)
    {
        $kategori = $this->normalizeKategori($kategori);

        if (!$this->guruHasKategoriAccess($kategori)) {
            return redirect()->to('guru/bank-soal')->with('error', 'Anda tidak memiliki akses ke kategori bank soal tersebut.');
        }

        $ujianList = $this->db->table('bank_ujian')
            ->select('bank_ujian.*, users.username as creator_name')
            ->join('users', 'users.user_id = bank_ujian.created_by')
            ->where('bank_ujian.kategori', $kategori)
            ->where('bank_ujian.jenis_ujian_id', $jenisUjianId)
            ->orderBy('bank_ujian.created_at', 'DESC')
            ->get()->getResultArray();

        $jenisUjian = $this->jenisUjianModel->find($jenisUjianId);

        return view('guru/bank_soal/jenis_ujian', [
            'kategori' => $kategori,
            'jenisUjian' => $jenisUjian,
            'ujianList' => $ujianList,
        ]);
    }

    public function ujian($kategori, $jenisUjianId, $bankUjianId)
    {
        $kategori = $this->normalizeKategori($kategori);

        if (!$this->guruHasKategoriAccess($kategori)) {
            return redirect()->to('guru/bank-soal')->with('error', 'Anda tidak memiliki akses ke kategori bank soal tersebut.');
        }

        $userId = (int) session()->get('user_id');

        $bankUjian = $this->db->table('bank_ujian')
            ->select('bank_ujian.*, jenis_ujian.nama_jenis, users.username as creator_name')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = bank_ujian.jenis_ujian_id')
            ->join('users', 'users.user_id = bank_ujian.created_by')
            ->where('bank_ujian.bank_ujian_id', $bankUjianId)
            ->get()
            ->getRowArray();

        if (!$bankUjian) {
            return redirect()->to('guru/bank-soal')->with('error', 'Bank ujian tidak ditemukan');
        }

        $soalList = $this->soalUjianModel
            ->where('bank_ujian_id', $bankUjianId)
            ->where('is_bank_soal', true)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $canAddSoal = $this->canAddSoalToBank($bankUjian, $kategori);
        $showActionColumn = false;

        foreach ($soalList as $soal) {
            if ($this->canManageSoal($bankUjian, $soal)) {
                $showActionColumn = true;
                break;
            }
        }

        return view('guru/bank_soal/ujian', [
            'kategori' => $kategori,
            'bankUjian' => $bankUjian,
            'soalList' => $soalList,
            'currentUserId' => $userId,
            'canAddSoal' => $canAddSoal,
            'showActionColumn' => $showActionColumn
        ]);
    }

    public function tambahSoalBankUjian()
    {
        $bankUjianId = (int) $this->request->getPost('bank_ujian_id');
        $bankUjian = $this->db->table('bank_ujian')->where('bank_ujian_id', $bankUjianId)->get()->getRowArray();

        if (!$bankUjian) {
            return redirect()->back()->with('error', 'Bank ujian tidak ditemukan');
        }

        if (!$this->canAddSoalToBank($bankUjian)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menambah soal pada bank ujian ini.');
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
            'foto'              => 'max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]|ext_in[foto,png,jpg,jpeg,gif]',
            'pembahasan'        => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . implode(', ', $this->validator->getErrors()));
        }

        $data = [
            'ujian_id'          => null,
            'bank_ujian_id'     => $bankUjianId,
            'is_bank_soal'      => true,
            'created_by'        => session()->get('user_id'),
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
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/soal';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $fotoFile->getRandomName();
            $fotoFile->move($uploadPath, $newName);
            $data['foto'] = $newName;
        }

        try {
            $this->soalUjianModel->insert($data);
            return redirect()->back()->with('success', 'Soal berhasil ditambahkan ke bank ujian.');
        } catch (\Exception $e) {
            log_message('error', 'Error saat menambahkan soal bank ujian guru: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan soal.');
        }
    }

    public function editSoalBankUjian($soalId)
    {
        $soal = $this->soalUjianModel->find($soalId);

        if (!$soal || empty($soal['is_bank_soal'])) {
            return redirect()->back()->with('error', 'Soal tidak ditemukan');
        }

        $bankUjian = $this->db->table('bank_ujian')->where('bank_ujian_id', $soal['bank_ujian_id'])->get()->getRowArray();
        if (!$bankUjian || !$this->canManageSoal($bankUjian, $soal)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah soal ini.');
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
            'foto'              => 'max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]|ext_in[foto,png,jpg,jpeg,gif]',
            'pembahasan'        => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . implode(', ', $this->validator->getErrors()));
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

        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/soal';
        $fotoFile = $this->request->getFile('foto');

        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            if (!empty($soal['foto'])) {
                $oldFotoPath = $uploadPath . '/' . $soal['foto'];
                if (file_exists($oldFotoPath)) {
                    unlink($oldFotoPath);
                }
            }

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $fotoFile->getRandomName();
            $fotoFile->move($uploadPath, $newName);
            $data['foto'] = $newName;
        }

        if ($this->request->getPost('hapus_foto') == '1' && !empty($soal['foto'])) {
            $oldFotoPath = $uploadPath . '/' . $soal['foto'];
            if (file_exists($oldFotoPath)) {
                unlink($oldFotoPath);
            }
            $data['foto'] = null;
        }

        try {
            $this->soalUjianModel->update($soalId, $data);
            return redirect()->back()->with('success', 'Soal berhasil diperbarui.');
        } catch (\Exception $e) {
            log_message('error', 'Error saat mengubah soal bank ujian guru: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui soal.');
        }
    }

    public function hapusSoalBankUjian($soalId)
    {
        $soal = $this->soalUjianModel->find($soalId);

        if (!$soal || empty($soal['is_bank_soal'])) {
            return redirect()->back()->with('error', 'Soal tidak ditemukan');
        }

        $bankUjian = $this->db->table('bank_ujian')->where('bank_ujian_id', $soal['bank_ujian_id'])->get()->getRowArray();
        if (!$bankUjian || !$this->canManageSoal($bankUjian, $soal)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus soal ini.');
        }

        if (!empty($soal['foto'])) {
            $fotoPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/soal/' . $soal['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        try {
            $this->soalUjianModel->delete($soalId);
            return redirect()->back()->with('success', 'Soal berhasil dihapus.');
        } catch (\Exception $e) {
            log_message('error', 'Error saat menghapus soal bank ujian guru: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus soal.');
        }
    }

    public function getJenisUjianByKategoriKelas()
    {
        $kategori = $this->normalizeKategori((string) $this->request->getGet('kategori'));
        $userId = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $userId)->first();

        if (!$guru || $kategori === '') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Kategori harus dipilih']);
        }

        if (!$this->guruHasKategoriAccess($kategori)) {
            return $this->response->setStatusCode(403)->setJSON(['status' => 'error', 'message' => 'Akses kategori ditolak']);
        }

        try {
            if ($kategori === 'umum') {
                $jenisUjian = $this->db->table('jenis_ujian')
                    ->select('jenis_ujian_id, nama_jenis')
                    ->groupStart()
                    ->where('kelas_id', null)
                    ->orWhere('kelas_id', 0)
                    ->groupEnd()
                    ->orderBy('nama_jenis', 'ASC')
                    ->get()
                    ->getResultArray();
            } else {
                $jenisUjian = $this->db->table('jenis_ujian')
                    ->select('jenis_ujian.jenis_ujian_id, jenis_ujian.nama_jenis')
                    ->join('kelas', 'kelas.kelas_id = jenis_ujian.kelas_id')
                    ->join('kelas_guru', 'kelas_guru.kelas_id = kelas.kelas_id')
                    ->where('kelas.nama_kelas', $kategori)
                    ->where('kelas_guru.guru_id', $guru['guru_id'])
                    ->orderBy('jenis_ujian.nama_jenis', 'ASC')
                    ->get()
                    ->getResultArray();
            }

            return $this->response->setJSON(['status' => 'success', 'data' => $jenisUjian]);
        } catch (\Exception $e) {
            log_message('error', 'Error memuat jenis ujian guru per kategori: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Gagal memuat mata pelajaran']);
        }
    }

    private function guruHasKategoriAccess(string $kategori): bool
    {
        $kategori = $this->normalizeKategori($kategori);

        if ($kategori === 'umum') {
            return true;
        }

        $userId = session()->get('user_id');
        $guru = $this->guruModel->where('user_id', $userId)->first();

        if (!$guru) {
            return false;
        }

        return $this->db->table('kelas_guru')
            ->join('kelas', 'kelas.kelas_id = kelas_guru.kelas_id')
            ->where('kelas_guru.guru_id', $guru['guru_id'])
            ->where('LOWER(TRIM(kelas.nama_kelas))', strtolower($kategori))
            ->countAllResults() > 0;
    }

    private function canAddSoalToBank(array $bankUjian, ?string $requestedKategori = null): bool
    {
        $kategori = $requestedKategori ?: ((string) ($bankUjian['kategori'] ?? ''));
        $kategori = $this->normalizeKategori($kategori);

        if ($kategori === '') {
            $kategori = $this->normalizeKategori((string) ($bankUjian['kategori'] ?? ''));
        }

        if (!$this->guruHasKategoriAccess($kategori)) {
            return false;
        }

        return true;
    }

    private function normalizeKategori(string $kategori): string
    {
        return strtolower(trim($kategori));
    }

    private function canManageSoal(array $bankUjian, array $soal): bool
    {
        $userId = (int) session()->get('user_id');

        if ((int) ($bankUjian['created_by'] ?? 0) === $userId) {
            return true;
        }

        return (int) ($soal['created_by'] ?? 0) === $userId;
    }
}
