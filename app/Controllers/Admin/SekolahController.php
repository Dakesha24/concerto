<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\SekolahModel;
use App\Models\KelasModel;
use App\Models\GuruModel;
use App\Models\SiswaModel;
use Config\Database;

class SekolahController extends Controller
{
    protected $db;
    protected $sekolahModel;
    protected $kelasModel;
    protected $guruModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->db           = Database::connect();
        $this->sekolahModel = new SekolahModel();
        $this->kelasModel   = new KelasModel();
        $this->guruModel    = new GuruModel();
        $this->siswaModel   = new SiswaModel();
    }

    // ===== SEKOLAH =====

    public function daftarSekolah()
    {
        $data['sekolah'] = $this->db->table('sekolah s')
            ->select('s.sekolah_id, s.nama_sekolah, s.alamat, s.telepon, s.email,
                 COUNT(DISTINCT g.guru_id) as total_guru,
                 COUNT(DISTINCT k.kelas_id) as total_kelas')
            ->join('guru g', 'g.sekolah_id = s.sekolah_id', 'left')
            ->join('kelas k', 'k.sekolah_id = s.sekolah_id', 'left')
            ->groupBy('s.sekolah_id, s.nama_sekolah, s.alamat, s.telepon, s.email')
            ->orderBy('s.nama_sekolah', 'ASC')
            ->get()->getResultArray();

        return view('admin/sekolah/daftar', $data);
    }

    public function formTambahSekolah()
    {
        return view('admin/sekolah/tambah');
    }

    public function tambahSekolah()
    {
        $rules = [
            'nama_sekolah' => 'required|min_length[3]',
            'alamat'       => 'permit_empty',
            'telepon'      => 'permit_empty|min_length[10]',
            'email'        => 'permit_empty|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $this->sekolahModel->insert([
                'nama_sekolah' => $this->request->getPost('nama_sekolah'),
                'alamat'       => $this->request->getPost('alamat'),
                'telepon'      => $this->request->getPost('telepon'),
                'email'        => $this->request->getPost('email'),
            ]);
            session()->setFlashdata('success', 'Sekolah berhasil ditambahkan!');
            return redirect()->to(base_url('admin/sekolah'));
        } catch (\Exception $e) {
            log_message('error', 'Error adding sekolah: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menambah sekolah.');
            return redirect()->back()->withInput();
        }
    }

    public function formEditSekolah($sekolahId)
    {
        $sekolah = $this->sekolahModel->find($sekolahId);
        if (!$sekolah) {
            session()->setFlashdata('error', 'Data sekolah tidak ditemukan');
            return redirect()->to(base_url('admin/sekolah'));
        }

        $data['sekolah'] = $sekolah;
        return view('admin/sekolah/edit', $data);
    }

    public function editSekolah($sekolahId)
    {
        $sekolah = $this->sekolahModel->find($sekolahId);
        if (!$sekolah) {
            session()->setFlashdata('error', 'Data sekolah tidak ditemukan');
            return redirect()->to(base_url('admin/sekolah'));
        }

        $rules = [
            'nama_sekolah' => 'required|min_length[3]',
            'alamat'       => 'permit_empty',
            'telepon'      => 'permit_empty|min_length[10]',
            'email'        => 'permit_empty|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $this->sekolahModel->update($sekolahId, [
                'nama_sekolah' => $this->request->getPost('nama_sekolah'),
                'alamat'       => $this->request->getPost('alamat'),
                'telepon'      => $this->request->getPost('telepon'),
                'email'        => $this->request->getPost('email'),
            ]);
            session()->setFlashdata('success', 'Data sekolah berhasil diperbarui!');
            return redirect()->to(base_url('admin/sekolah'));
        } catch (\Exception $e) {
            log_message('error', 'Error updating sekolah: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat memperbarui sekolah.');
            return redirect()->back()->withInput();
        }
    }

    public function hapusSekolah($sekolahId)
    {
        try {
            $totalGuru = $this->guruModel->where('sekolah_id', $sekolahId)->countAllResults();

            if ($totalGuru > 0) {
                session()->setFlashdata('error', "Tidak dapat menghapus sekolah karena masih memiliki {$totalGuru} guru.");
                return redirect()->to(base_url('admin/sekolah'));
            }

            $this->sekolahModel->delete($sekolahId);
            session()->setFlashdata('success', 'Sekolah berhasil dihapus!');
        } catch (\Exception $e) {
            log_message('error', 'Error deleting sekolah: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus sekolah.');
        }

        return redirect()->to(base_url('admin/sekolah'));
    }

    // ===== KELAS =====

    public function daftarKelasBySekolah($sekolahId)
    {
        $sekolah = $this->sekolahModel->find($sekolahId);
        if (!$sekolah) {
            session()->setFlashdata('error', 'Sekolah tidak ditemukan');
            return redirect()->to(base_url('admin/sekolah'));
        }

        $kelas = $this->db->table('kelas k')
            ->select('k.*, COUNT(DISTINCT s.siswa_id) as total_siswa, COUNT(DISTINCT kg.guru_id) as total_guru')
            ->join('siswa s', 's.kelas_id = k.kelas_id', 'left')
            ->join('kelas_guru kg', 'kg.kelas_id = k.kelas_id', 'left')
            ->where('k.sekolah_id', $sekolahId)
            ->groupBy('k.kelas_id')
            ->orderBy('k.tahun_ajaran', 'DESC')
            ->orderBy('k.nama_kelas', 'ASC')
            ->get()->getResultArray();

        $sekolah['total_guru'] = $this->db->table('guru')->where('sekolah_id', $sekolahId)->countAllResults();

        $data = ['sekolah' => $sekolah, 'kelas' => $kelas];
        return view('admin/sekolah/kelas', $data);
    }

    public function formTambahKelasSekolah($sekolahId)
    {
        $sekolah = $this->sekolahModel->find($sekolahId);
        if (!$sekolah) {
            session()->setFlashdata('error', 'Sekolah tidak ditemukan');
            return redirect()->to(base_url('admin/sekolah'));
        }

        $data = ['sekolah' => $sekolah, 'sekolah_id' => $sekolahId];
        return view('admin/sekolah/tambah_kelas', $data);
    }

    public function tambahKelasSekolah($sekolahId)
    {
        $sekolah = $this->sekolahModel->find($sekolahId);
        if (!$sekolah) {
            session()->setFlashdata('error', 'Sekolah tidak ditemukan');
            return redirect()->to(base_url('admin/sekolah'));
        }

        $rules = [
            'nama_kelas'   => 'required|min_length[2]',
            'tahun_ajaran' => 'required|regex_match[/^\d{4}\/\d{4}$/]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $this->kelasModel->insert([
                'sekolah_id'   => $sekolahId,
                'nama_kelas'   => $this->request->getPost('nama_kelas'),
                'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
            ]);
            session()->setFlashdata('success', 'Kelas berhasil ditambahkan!');
            return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas'));
        } catch (\Exception $e) {
            log_message('error', 'Error adding kelas: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menambah kelas.');
            return redirect()->back()->withInput();
        }
    }

    public function formEditKelasSekolah($sekolahId, $kelasId)
    {
        $sekolah = $this->sekolahModel->find($sekolahId);
        if (!$sekolah) {
            session()->setFlashdata('error', 'Sekolah tidak ditemukan');
            return redirect()->to(base_url('admin/sekolah'));
        }

        $kelas = $this->kelasModel->find($kelasId);
        if (!$kelas || $kelas['sekolah_id'] != $sekolahId) {
            session()->setFlashdata('error', 'Kelas tidak ditemukan atau tidak berada di sekolah ini');
            return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas'));
        }

        $data = ['sekolah' => $sekolah, 'kelas' => $kelas];
        return view('admin/sekolah/edit_kelas', $data);
    }

    public function editKelasSekolah($sekolahId, $kelasId)
    {
        $sekolah = $this->sekolahModel->find($sekolahId);
        if (!$sekolah) {
            session()->setFlashdata('error', 'Sekolah tidak ditemukan');
            return redirect()->to(base_url('admin/sekolah'));
        }

        $kelas = $this->kelasModel->find($kelasId);
        if (!$kelas || $kelas['sekolah_id'] != $sekolahId) {
            session()->setFlashdata('error', 'Kelas tidak ditemukan atau tidak berada di sekolah ini');
            return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas'));
        }

        $rules = [
            'nama_kelas'   => 'required|min_length[2]',
            'tahun_ajaran' => 'required|regex_match[/^\d{4}\/\d{4}$/]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $this->kelasModel->update($kelasId, [
                'nama_kelas'   => $this->request->getPost('nama_kelas'),
                'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
            ]);
            session()->setFlashdata('success', 'Data kelas berhasil diperbarui!');
            return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas'));
        } catch (\Exception $e) {
            log_message('error', 'Error updating kelas: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat memperbarui kelas.');
            return redirect()->back()->withInput();
        }
    }

    public function hapusKelasSekolah($sekolahId, $kelasId)
    {
        try {
            $sekolah = $this->sekolahModel->find($sekolahId);
            if (!$sekolah) {
                session()->setFlashdata('error', 'Sekolah tidak ditemukan');
                return redirect()->to(base_url('admin/sekolah'));
            }

            $kelas = $this->kelasModel->find($kelasId);
            if (!$kelas || $kelas['sekolah_id'] != $sekolahId) {
                session()->setFlashdata('error', 'Kelas tidak ditemukan atau tidak berada di sekolah ini');
                return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas'));
            }

            $totalSiswa = $this->siswaModel->where('kelas_id', $kelasId)->countAllResults();
            $totalGuru  = $this->db->table('kelas_guru')->where('kelas_id', $kelasId)->countAllResults();

            if ($totalSiswa > 0) {
                session()->setFlashdata('error', "Tidak dapat menghapus kelas karena masih memiliki {$totalSiswa} siswa.");
                return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas'));
            }

            if ($totalGuru > 0) {
                session()->setFlashdata('error', "Tidak dapat menghapus kelas karena masih memiliki {$totalGuru} guru pengajar.");
                return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas'));
            }

            $this->kelasModel->delete($kelasId);
            session()->setFlashdata('success', 'Kelas berhasil dihapus!');
        } catch (\Exception $e) {
            log_message('error', 'Error deleting kelas: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus kelas.');
        }

        return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas'));
    }

    public function detailKelasSekolah($sekolahId, $kelasId)
    {
        $sekolah = $this->sekolahModel->find($sekolahId);
        if (!$sekolah) {
            session()->setFlashdata('error', 'Sekolah tidak ditemukan');
            return redirect()->to(base_url('admin/sekolah'));
        }

        $kelas = $this->db->table('kelas k')
            ->select('k.*, s.nama_sekolah, s.sekolah_id')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id')
            ->where('k.kelas_id', $kelasId)
            ->where('k.sekolah_id', $sekolahId)
            ->get()->getRowArray();

        if (!$kelas) {
            session()->setFlashdata('error', 'Kelas tidak ditemukan atau tidak berada di sekolah ini');
            return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas'));
        }

        $daftarGuru = $this->db->table('kelas_guru kg')
            ->select('kg.*, g.guru_id, g.nama_lengkap, g.nip, g.mata_pelajaran,
                 u.user_id, u.username, u.status,
                 GROUP_CONCAT(DISTINCT CASE WHEN k2.kelas_id != kg.kelas_id THEN k2.nama_kelas END ORDER BY k2.nama_kelas SEPARATOR ", ") as kelas_lain')
            ->join('guru g', 'g.guru_id = kg.guru_id')
            ->join('users u', 'u.user_id = g.user_id')
            ->join('kelas_guru kg2', 'kg2.guru_id = g.guru_id', 'left')
            ->join('kelas k2', 'k2.kelas_id = kg2.kelas_id', 'left')
            ->where('kg.kelas_id', $kelasId)
            ->groupBy('kg.kelas_guru_id, kg.kelas_id, kg.guru_id, kg.created_at, kg.updated_at,
                  g.guru_id, g.nama_lengkap, g.nip, g.mata_pelajaran, u.user_id, u.username, u.status')
            ->orderBy('g.nama_lengkap', 'ASC')
            ->get()->getResultArray();

        $daftarSiswa = $this->db->table('siswa s')
            ->select('s.*, u.user_id, u.username, u.status')
            ->join('users u', 'u.user_id = s.user_id')
            ->where('s.kelas_id', $kelasId)
            ->orderBy('s.nama_lengkap', 'ASC')
            ->get()->getResultArray();

        $assignedGuruIds = array_column($daftarGuru, 'guru_id');
        $whereNotIn      = !empty($assignedGuruIds) ? $assignedGuruIds : [0];

        $availableGuru = $this->db->table('guru g')
            ->select('g.guru_id, g.nama_lengkap, g.mata_pelajaran,
                 GROUP_CONCAT(DISTINCT k.nama_kelas ORDER BY k.nama_kelas SEPARATOR ", ") as kelas_diajar')
            ->join('users u', 'u.user_id = g.user_id')
            ->join('kelas_guru kg', 'kg.guru_id = g.guru_id', 'left')
            ->join('kelas k', 'k.kelas_id = kg.kelas_id', 'left')
            ->where('g.sekolah_id', $sekolahId)
            ->where('u.status', 'active')
            ->whereNotIn('g.guru_id', $whereNotIn)
            ->groupBy('g.guru_id, g.nama_lengkap, g.mata_pelajaran')
            ->orderBy('g.nama_lengkap', 'ASC')
            ->get()->getResultArray();

        $data = [
            'sekolah'       => $sekolah,
            'kelas'         => $kelas,
            'daftarGuru'    => $daftarGuru,
            'daftarSiswa'   => $daftarSiswa,
            'availableGuru' => $availableGuru,
        ];

        return view('admin/sekolah/detail_kelas', $data);
    }

    public function assignGuruKelasSekolah($sekolahId, $kelasId)
    {
        $guruId = $this->request->getPost('guru_id');
        if (!$guruId) {
            session()->setFlashdata('error', 'Guru harus dipilih');
            return redirect()->back();
        }

        try {
            $guru = $this->db->table('guru')
                ->where('guru_id', $guruId)->where('sekolah_id', $sekolahId)
                ->get()->getRowArray();

            if (!$guru) {
                session()->setFlashdata('error', 'Guru tidak ditemukan atau tidak berada di sekolah ini');
                return redirect()->back();
            }

            $exists = $this->db->table('kelas_guru')
                ->where('kelas_id', $kelasId)->where('guru_id', $guruId)->countAllResults();

            if ($exists > 0) {
                session()->setFlashdata('error', 'Guru sudah mengajar di kelas ini');
                return redirect()->back();
            }

            $this->db->table('kelas_guru')->insert([
                'kelas_id'   => $kelasId,
                'guru_id'    => $guruId,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            session()->setFlashdata('success', 'Guru berhasil di-assign ke kelas!');
        } catch (\Exception $e) {
            log_message('error', 'Error assigning guru: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat assign guru.');
        }

        return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas/' . $kelasId . '/detail'));
    }

    public function removeGuruKelasSekolah($sekolahId, $kelasId, $guruId)
    {
        try {
            $this->db->table('kelas_guru')
                ->where('kelas_id', $kelasId)->where('guru_id', $guruId)->delete();

            session()->setFlashdata('success', 'Guru berhasil dikeluarkan dari kelas!');
        } catch (\Exception $e) {
            log_message('error', 'Error removing guru: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat mengeluarkan guru.');
        }

        return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas/' . $kelasId . '/detail'));
    }

    public function transferSiswaSekolah($sekolahId, $kelasId, $siswaId)
    {
        $sekolah = $this->sekolahModel->find($sekolahId);
        if (!$sekolah) {
            session()->setFlashdata('error', 'Sekolah tidak ditemukan');
            return redirect()->to(base_url('admin/sekolah'));
        }

        $siswa = $this->db->table('siswa s')
            ->select('s.*, u.username, k.nama_kelas, k.sekolah_id, sk.nama_sekolah')
            ->join('users u', 'u.user_id = s.user_id')
            ->join('kelas k', 'k.kelas_id = s.kelas_id')
            ->join('sekolah sk', 'sk.sekolah_id = k.sekolah_id')
            ->where('s.siswa_id', $siswaId)
            ->where('s.kelas_id', $kelasId)
            ->where('k.sekolah_id', $sekolahId)
            ->get()->getRowArray();

        if (!$siswa) {
            session()->setFlashdata('error', 'Siswa tidak ditemukan atau tidak berada di kelas/sekolah ini');
            return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas/' . $kelasId . '/detail'));
        }

        $kelasLain = $this->db->table('kelas k')
            ->select('k.kelas_id, k.nama_kelas, k.tahun_ajaran, COUNT(s.siswa_id) as jumlah_siswa')
            ->join('siswa s', 's.kelas_id = k.kelas_id', 'left')
            ->where('k.sekolah_id', $sekolahId)
            ->where('k.kelas_id !=', $kelasId)
            ->groupBy('k.kelas_id, k.nama_kelas, k.tahun_ajaran')
            ->orderBy('k.tahun_ajaran', 'DESC')
            ->orderBy('k.nama_kelas', 'ASC')
            ->get()->getResultArray();

        $data = [
            'sekolah'   => $sekolah,
            'siswa'     => $siswa,
            'kelasAsal' => $kelasId,
            'kelasLain' => $kelasLain,
        ];

        return view('admin/sekolah/transfer_siswa', $data);
    }

    public function prosesTransferSiswaSekolah()
    {
        $siswaId       = $this->request->getPost('siswa_id');
        $sekolahId     = $this->request->getPost('sekolah_id');
        $kelasAsalId   = $this->request->getPost('kelas_asal_id');
        $kelasTujuanId = $this->request->getPost('kelas_tujuan_id');

        if (!$siswaId || !$sekolahId || !$kelasAsalId || !$kelasTujuanId) {
            session()->setFlashdata('error', 'Data tidak lengkap');
            return redirect()->back();
        }

        try {
            $kelasTujuan = $this->db->table('kelas')
                ->where('kelas_id', $kelasTujuanId)->where('sekolah_id', $sekolahId)
                ->get()->getRowArray();

            if (!$kelasTujuan) {
                session()->setFlashdata('error', 'Kelas tujuan tidak valid');
                return redirect()->back();
            }

            $siswa    = $this->db->table('siswa')->select('nama_lengkap')->where('siswa_id', $siswaId)->get()->getRowArray();
            $kelasAsal = $this->db->table('kelas')->select('nama_kelas')->where('kelas_id', $kelasAsalId)->get()->getRowArray();

            $this->db->table('siswa')->where('siswa_id', $siswaId)->update(['kelas_id' => $kelasTujuanId]);

            session()->setFlashdata(
                'success',
                "Siswa <strong>{$siswa['nama_lengkap']}</strong> berhasil dipindahkan dari " .
                "<strong>{$kelasAsal['nama_kelas']}</strong> ke <strong>{$kelasTujuan['nama_kelas']}</strong>."
            );
        } catch (\Exception $e) {
            log_message('error', 'Error transferring siswa: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat memindahkan siswa: ' . $e->getMessage());
        }

        return redirect()->to(base_url('admin/sekolah/' . $sekolahId . '/kelas/' . $kelasAsalId . '/detail'));
    }
}
