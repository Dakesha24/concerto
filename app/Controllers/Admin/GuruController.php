<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\GuruModel;
use App\Models\SekolahModel;
use App\Models\JenisUjianModel;
use Config\Database;

class GuruController extends Controller
{
    protected $db;
    protected $userModel;
    protected $guruModel;
    protected $jenisUjianModel;

    public function __construct()
    {
        $this->db        = Database::connect();
        $this->userModel = new UserModel();
        $this->guruModel = new GuruModel();
        $this->jenisUjianModel = new JenisUjianModel();
    }

    public function daftarGuru()
    {
        $data['guru'] = $this->db->table('users u')
            ->select('u.user_id, u.username, u.email, u.status, u.created_at,
                 g.guru_id, g.nip, g.nama_lengkap, g.mata_pelajaran, g.sekolah_id,
                 s.nama_sekolah,
                 COUNT(DISTINCT kg.kelas_id) as total_kelas')
            ->join('guru g', 'g.user_id = u.user_id', 'left')
            ->join('sekolah s', 's.sekolah_id = g.sekolah_id', 'left')
            ->join('kelas_guru kg', 'kg.guru_id = g.guru_id', 'left')
            ->where('u.role', 'guru')
            ->groupBy('u.user_id, u.username, u.email, u.status, u.created_at,
                  g.guru_id, g.nip, g.nama_lengkap, g.mata_pelajaran, g.sekolah_id, s.nama_sekolah')
            ->orderBy('g.nama_lengkap', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/guru/daftar', $data);
    }

    public function formTambahGuru()
    {
        $sekolahModel    = new SekolahModel();
        $data['sekolah'] = $sekolahModel->findAll();

        $data['kelas'] = $this->db->table('kelas k')
            ->select('k.kelas_id, k.nama_kelas, k.tahun_ajaran, k.sekolah_id, s.nama_sekolah')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id')
            ->orderBy('s.nama_sekolah', 'ASC')
            ->orderBy('k.nama_kelas', 'ASC')
            ->get()
            ->getResultArray();

        $data['jenisUjian'] = $this->jenisUjianModel
            ->orderBy('nama_jenis', 'ASC')
            ->findAll();

        return view('admin/guru/tambah', $data);
    }

    public function tambahGuru()
    {
        $rules = [
            'username'       => 'required|min_length[4]|is_unique[users.username]',
            'email'          => 'required|valid_email|is_unique[users.email]',
            'password'       => 'required|min_length[6]',
            'nama_lengkap'   => 'required|min_length[3]',
            'nip'            => 'permit_empty|is_unique[guru.nip]',
            'jenis_ujian_id' => 'required|numeric',
            'sekolah_id'     => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $this->db->transStart();

            $jenisUjian = $this->jenisUjianModel->find($this->request->getPost('jenis_ujian_id'));
            if (!$jenisUjian) {
                return redirect()->back()->withInput()->with('errors', ['Mata pelajaran tidak valid.']);
            }

            $userId = $this->userModel->insert([
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'     => 'guru',
                'status'   => 'active',
            ]);

            if ($userId) {
                $sekolahId = $this->request->getPost('sekolah_id');

                $guruId = $this->guruModel->insert([
                    'user_id'        => $userId,
                    'sekolah_id'     => $sekolahId,
                    'nip'            => $this->request->getPost('nip') ?: null,
                    'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
                    'mata_pelajaran' => $jenisUjian['nama_jenis'],
                ]);

                $kelasIds = $this->request->getPost('kelas_ids');
                if (!empty($kelasIds) && is_array($kelasIds)) {
                    foreach ($kelasIds as $kelasId) {
                        $kelas = $this->db->table('kelas')
                            ->where('kelas_id', $kelasId)
                            ->where('sekolah_id', $sekolahId)
                            ->get()->getRowArray();

                        if ($kelas) {
                            $this->db->table('kelas_guru')->insert([
                                'kelas_id'   => $kelasId,
                                'guru_id'    => $guruId,
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            session()->setFlashdata('success', 'Guru berhasil ditambahkan!');
            return redirect()->to(base_url('admin/guru'));
        } catch (\Exception $e) {
            log_message('error', 'Error adding guru: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menambah guru.');
            return redirect()->back()->withInput();
        }
    }

    public function formEditGuru($userId)
    {
        $guru = $this->db->table('users u')
            ->select('u.user_id, u.username, u.email, u.status, u.created_at,
                 g.guru_id, g.nip, g.nama_lengkap, g.mata_pelajaran, g.sekolah_id, s.nama_sekolah')
            ->join('guru g', 'g.user_id = u.user_id', 'left')
            ->join('sekolah s', 's.sekolah_id = g.sekolah_id', 'left')
            ->where('u.user_id', $userId)
            ->where('u.role', 'guru')
            ->get()->getRowArray();

        if (!$guru) {
            session()->setFlashdata('error', 'Data guru tidak ditemukan');
            return redirect()->to(base_url('admin/guru'));
        }

        $defaults = [
            'user_id' => '', 'username' => '', 'email' => '', 'status' => 'active',
            'guru_id' => '', 'sekolah_id' => '', 'nip' => '',
            'nama_lengkap' => '', 'mata_pelajaran' => '', 'nama_sekolah' => '',
        ];
        $guru = array_merge($defaults, $guru);

        $sekolahModel    = new SekolahModel();
        $data['sekolah'] = $sekolahModel->findAll();

        $data['kelasGuru'] = $this->db->table('kelas_guru kg')
            ->select('kg.*, k.nama_kelas, k.tahun_ajaran, k.kelas_id')
            ->join('kelas k', 'k.kelas_id = kg.kelas_id')
            ->where('kg.guru_id', $guru['guru_id'])
            ->orderBy('k.nama_kelas', 'ASC')
            ->get()->getResultArray();

        $data['allKelas'] = $this->db->table('kelas k')
            ->select('k.kelas_id, k.nama_kelas, k.tahun_ajaran, k.sekolah_id')
            ->orderBy('k.nama_kelas', 'ASC')
            ->get()->getResultArray();

        $data['jenisUjian'] = $this->jenisUjianModel
            ->orderBy('nama_jenis', 'ASC')
            ->findAll();

        $data['guru'] = $guru;

        return view('admin/guru/edit', $data);
    }

    public function editGuru($userId)
    {
        $rules = [
            'username'       => 'required|min_length[4]',
            'email'          => 'required|valid_email',
            'nama_lengkap'   => 'required|min_length[3]',
            'jenis_ujian_id' => 'required|numeric',
            'sekolah_id'     => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $username      = $this->request->getPost('username');
            $email         = $this->request->getPost('email');
            $password      = $this->request->getPost('password');
            $namaLengkap   = $this->request->getPost('nama_lengkap');
            $nip           = $this->request->getPost('nip');
            $sekolahId     = $this->request->getPost('sekolah_id');
            $jenisUjian = $this->jenisUjianModel->find($this->request->getPost('jenis_ujian_id'));

            if (!$jenisUjian) {
                return redirect()->back()->withInput()->with('errors', ['Mata pelajaran tidak valid.']);
            }

            $sqlUser    = 'UPDATE users SET username = ?, email = ?';
            $paramsUser = [$username, $email];

            if (!empty($password)) {
                $sqlUser    .= ', password = ?';
                $paramsUser[] = password_hash($password, PASSWORD_DEFAULT);
            }

            $sqlUser    .= ' WHERE user_id = ?';
            $paramsUser[] = $userId;

            $this->db->query($sqlUser, $paramsUser);
            $this->db->query(
                'UPDATE guru SET nama_lengkap = ?, nip = ?, mata_pelajaran = ?, sekolah_id = ? WHERE user_id = ?',
                [$namaLengkap, $nip, $jenisUjian['nama_jenis'], $sekolahId, $userId]
            );

            session()->setFlashdata('success', 'Data guru berhasil diperbarui!');
            return redirect()->to(base_url('admin/guru'));
        } catch (\Exception $e) {
            log_message('error', 'Error updating guru: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function assignKelas()
    {
        $guruId  = $this->request->getPost('guru_id');
        $kelasId = $this->request->getPost('kelas_id');

        if (!$guruId || !$kelasId) {
            session()->setFlashdata('error', 'Data tidak lengkap');
            return redirect()->back();
        }

        try {
            $guru = $this->db->table('guru')->where('guru_id', $guruId)->get()->getRowArray();
            if (!$guru) {
                session()->setFlashdata('error', 'Guru tidak ditemukan');
                return redirect()->back();
            }

            $kelas = $this->db->table('kelas')
                ->where('kelas_id', $kelasId)
                ->where('sekolah_id', $guru['sekolah_id'])
                ->get()->getRowArray();

            if (!$kelas) {
                session()->setFlashdata('error', 'Kelas tidak valid atau tidak berada di sekolah yang sama');
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

            session()->setFlashdata('success', 'Kelas berhasil ditambahkan ke guru!');
        } catch (\Exception $e) {
            log_message('error', 'Error assigning kelas: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menambahkan kelas.');
        }

        return redirect()->back();
    }

    public function removeKelas($guruId, $kelasId)
    {
        try {
            $affected = $this->db->table('kelas_guru')
                ->where('kelas_id', $kelasId)->where('guru_id', $guruId)->delete();

            if ($affected) {
                session()->setFlashdata('success', 'Guru berhasil dikeluarkan dari kelas!');
            } else {
                session()->setFlashdata('warning', 'Tidak ada data yang dihapus');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error removing kelas: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat mengeluarkan guru dari kelas.');
        }

        return redirect()->back();
    }

    public function hapusGuru($userId)
    {
        try {
            $this->userModel->softDelete($userId);
            session()->setFlashdata('success', 'Guru berhasil dinonaktifkan!');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan saat menonaktifkan guru.');
        }

        return redirect()->to(base_url('admin/guru'));
    }

    public function restoreGuru($userId)
    {
        try {
            $this->userModel->restore($userId);
            session()->setFlashdata('success', 'Guru berhasil diaktifkan kembali!');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan saat mengaktifkan guru.');
        }

        return redirect()->to(base_url('admin/guru'));
    }
}
