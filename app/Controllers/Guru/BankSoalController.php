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
        $jenisUjianList = $this->db->table('bank_ujian')
            ->select('bank_ujian.jenis_ujian_id, jenis_ujian.nama_jenis, COUNT(*) as jumlah_ujian')
            ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = bank_ujian.jenis_ujian_id')
            ->where('bank_ujian.kategori', $kategori)
            ->groupBy('bank_ujian.jenis_ujian_id')
            ->get()->getResultArray();

        return view('guru/bank_soal/kategori', ['kategori' => $kategori, 'jenisUjianList' => $jenisUjianList]);
    }

    public function ujian($kategori, $jenisUjianId, $bankUjianId)
    {
        $bankUjian = $this->db->table('bank_ujian')->where('bank_ujian_id', $bankUjianId)->get()->getRowArray();
        $soalList = $this->soalUjianModel->where('bank_ujian_id', $bankUjianId)->findAll();

        return view('guru/bank_soal/ujian', [
            'kategori' => $kategori,
            'bankUjian' => $bankUjian,
            'soalList' => $soalList,
            'canEdit' => ($bankUjian['created_by'] == session()->get('user_id'))
        ]);
    }
}
