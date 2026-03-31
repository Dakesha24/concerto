<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\JenisUjianModel;
use App\Models\UjianModel;
use Config\Database;

class ApiController extends Controller
{
    protected $db;
    protected $jenisUjianModel;
    protected $ujianModel;

    public function __construct()
    {
        $this->db             = Database::connect();
        $this->jenisUjianModel = new JenisUjianModel();
        $this->ujianModel     = new UjianModel();
    }

    public function getKelasBySekolah($sekolahId)
    {
        $kelas = $this->db->table('kelas')
            ->select('kelas_id, nama_kelas, tahun_ajaran')
            ->where('sekolah_id', $sekolahId)
            ->orderBy('tahun_ajaran', 'DESC')
            ->orderBy('nama_kelas', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON(['status' => 'success', 'data' => $kelas]);
    }

    public function getJenisUjianByKelas($kelasId)
    {
        try {
            $jenisUjian = $this->jenisUjianModel
                ->select('jenis_ujian.*, kelas.nama_kelas, sekolah.nama_sekolah')
                ->join('kelas', 'kelas.kelas_id = jenis_ujian.kelas_id', 'left')
                ->join('sekolah', 'sekolah.sekolah_id = kelas.sekolah_id', 'left')
                ->groupStart()
                ->where('jenis_ujian.kelas_id', $kelasId)
                ->orWhere('jenis_ujian.kelas_id', null)
                ->groupEnd()
                ->orderBy('jenis_ujian.nama_jenis', 'ASC')
                ->findAll();

            return $this->response->setJSON(['status' => 'success', 'data' => $jenisUjian]);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching jenis ujian by kelas: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengambil data mata pelajaran']);
        }
    }

    public function getUjianByKelas($kelasId)
    {
        try {
            $ujian = $this->ujianModel
                ->select('ujian.*, jenis_ujian.nama_jenis')
                ->join('jenis_ujian', 'jenis_ujian.jenis_ujian_id = ujian.jenis_ujian_id', 'left')
                ->groupStart()
                ->where('ujian.kelas_id', $kelasId)
                ->orWhere('ujian.kelas_id', null)
                ->groupEnd()
                ->orderBy('ujian.nama_ujian', 'ASC')
                ->findAll();

            return $this->response->setJSON(['status' => 'success', 'data' => $ujian]);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching ujian by kelas: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengambil data ujian']);
        }
    }
}
