<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\SiswaModel;
use App\Models\SekolahModel;
use Config\Database;

class SiswaController extends Controller
{
    protected $db;
    protected $userModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->db        = Database::connect();
        $this->userModel = new UserModel();
        $this->siswaModel = new SiswaModel();
    }

    public function daftarSiswa()
    {
        $allSiswa = $this->db->table('users u')
            ->select('u.user_id, u.username, u.email, u.status, u.created_at,
                 s.siswa_id, s.nomor_peserta, s.nama_lengkap, s.jenis_kelamin, s.kelas_id')
            ->join('siswa s', 's.user_id = u.user_id', 'inner')
            ->where('u.role', 'siswa')
            ->orderBy('s.nama_lengkap', 'ASC')
            ->get()->getResultArray();

        foreach ($allSiswa as &$siswa) {
            if (!empty($siswa['kelas_id'])) {
                $kelas = $this->db->table('kelas')->where('kelas_id', $siswa['kelas_id'])->get()->getRowArray();
                if ($kelas) {
                    $siswa['nama_kelas']    = $kelas['nama_kelas'];
                    $siswa['tahun_ajaran']  = $kelas['tahun_ajaran'];
                    $sekolah = $this->db->table('sekolah')->where('sekolah_id', $kelas['sekolah_id'])->get()->getRowArray();
                    if ($sekolah) {
                        $siswa['nama_sekolah'] = $sekolah['nama_sekolah'];
                    }
                }
            }
            $siswa['nama_kelas']   = $siswa['nama_kelas'] ?? 'Belum Ditentukan';
            $siswa['tahun_ajaran'] = $siswa['tahun_ajaran'] ?? '-';
            $siswa['nama_sekolah'] = $siswa['nama_sekolah'] ?? 'Belum Ditentukan';
        }

        $data['siswa'] = $allSiswa;
        return view('admin/siswa/daftar', $data);
    }

    public function formTambahSiswa()
    {
        $sekolahModel    = new SekolahModel();
        $data['sekolah'] = $sekolahModel->findAll();

        $data['kelas'] = $this->db->table('kelas k')
            ->select('k.kelas_id, k.nama_kelas, k.tahun_ajaran, k.sekolah_id, s.nama_sekolah')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id')
            ->orderBy('s.nama_sekolah', 'ASC')
            ->orderBy('k.nama_kelas', 'ASC')
            ->get()->getResultArray();

        return view('admin/siswa/tambah', $data);
    }

    public function tambahSiswa()
    {
        $rules = [
            'username'      => 'required|min_length[4]|is_unique[users.username]',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[6]',
            'nama_lengkap'  => 'required|min_length[3]',
            'jenis_kelamin' => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'nomor_peserta' => 'required',
            'sekolah_id'    => 'required|numeric',
            'kelas_id'      => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $sekolahId = $this->request->getPost('sekolah_id');
            $kelasId   = $this->request->getPost('kelas_id');

            $kelas = $this->db->table('kelas')
                ->where('kelas_id', $kelasId)->where('sekolah_id', $sekolahId)
                ->get()->getRowArray();

            if (!$kelas) {
                session()->setFlashdata('error', 'Kelas yang dipilih tidak valid untuk sekolah tersebut.');
                return redirect()->back()->withInput();
            }

            $userId = $this->userModel->insert([
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role'     => 'siswa',
                'status'   => 'active',
            ]);

            if ($userId) {
                $this->siswaModel->insert([
                    'user_id'       => $userId,
                    'kelas_id'      => $kelasId,
                    'nomor_peserta' => $this->request->getPost('nomor_peserta'),
                    'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
                    'jenis_kelamin' => $this->request->getPost('jenis_kelamin') ?: null,
                ]);

                session()->setFlashdata('success', 'Siswa berhasil ditambahkan!');
                return redirect()->to(base_url('admin/siswa'));
            }
        } catch (\Exception $e) {
            log_message('error', 'Error adding siswa: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menambah siswa.');
            return redirect()->back()->withInput();
        }
    }

    public function formEditSiswa($userId)
    {
        $user = $this->db->table('users')->where('user_id', $userId)->where('role', 'siswa')->get()->getRowArray();
        if (!$user) {
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to(base_url('admin/siswa'));
        }

        $siswaData = $this->db->table('siswa')->where('user_id', $userId)->get()->getRowArray();
        if (!$siswaData) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan di tabel siswa');
            return redirect()->to(base_url('admin/siswa'));
        }

        $siswa = array_merge($user, $siswaData);

        if (!empty($siswa['kelas_id'])) {
            $kelas = $this->db->table('kelas')->where('kelas_id', $siswa['kelas_id'])->get()->getRowArray();
            if ($kelas) {
                $siswa['nama_kelas']   = $kelas['nama_kelas'];
                $siswa['tahun_ajaran'] = $kelas['tahun_ajaran'];
                $sekolah = $this->db->table('sekolah')->where('sekolah_id', $kelas['sekolah_id'])->get()->getRowArray();
                if ($sekolah) {
                    $siswa['sekolah_id']   = $sekolah['sekolah_id'];
                    $siswa['nama_sekolah'] = $sekolah['nama_sekolah'];
                }
            }
        }

        $siswa['nama_kelas']    = $siswa['nama_kelas'] ?? 'Belum Ditentukan';
        $siswa['tahun_ajaran']  = $siswa['tahun_ajaran'] ?? '-';
        $siswa['nama_sekolah']  = $siswa['nama_sekolah'] ?? 'Belum Ditentukan';
        $siswa['sekolah_id']    = $siswa['sekolah_id'] ?? '';
        $siswa['jenis_kelamin'] = $siswa['jenis_kelamin'] ?? '';

        $sekolahModel    = new SekolahModel();
        $data['sekolah'] = $sekolahModel->findAll();

        $data['kelas'] = $this->db->table('kelas k')
            ->select('k.kelas_id, k.nama_kelas, k.tahun_ajaran, k.sekolah_id, s.nama_sekolah')
            ->join('sekolah s', 's.sekolah_id = k.sekolah_id')
            ->orderBy('s.nama_sekolah', 'ASC')
            ->orderBy('k.nama_kelas', 'ASC')
            ->get()->getResultArray();

        $data['siswa'] = $siswa;
        return view('admin/siswa/edit', $data);
    }

    public function editSiswa($userId)
    {
        $siswa = $this->siswaModel->where('user_id', $userId)->first();
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan');
            return redirect()->to(base_url('admin/siswa'));
        }

        $rules = [
            'username'      => "required|min_length[4]|is_unique[users.username,user_id,{$userId}]",
            'email'         => "required|valid_email|is_unique[users.email,user_id,{$userId}]",
            'nama_lengkap'  => 'required|min_length[3]',
            'jenis_kelamin' => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'nomor_peserta' => 'required',
            'sekolah_id'    => 'required|numeric',
            'kelas_id'      => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $sekolahId    = $this->request->getPost('sekolah_id');
            $kelasId      = $this->request->getPost('kelas_id');

            $kelas = $this->db->table('kelas')
                ->where('kelas_id', $kelasId)->where('sekolah_id', $sekolahId)
                ->get()->getRowArray();

            if (!$kelas) {
                session()->setFlashdata('error', 'Kelas yang dipilih tidak valid untuk sekolah tersebut.');
                return redirect()->back()->withInput();
            }

            $username     = $this->request->getPost('username');
            $email        = $this->request->getPost('email');
            $password     = $this->request->getPost('password');
            $namaLengkap  = $this->request->getPost('nama_lengkap');
            $jenisKelamin = $this->request->getPost('jenis_kelamin');
            $nomorPeserta = $this->request->getPost('nomor_peserta');

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
                'UPDATE siswa SET nama_lengkap = ?, jenis_kelamin = ?, nomor_peserta = ?, kelas_id = ? WHERE user_id = ?',
                [$namaLengkap, $jenisKelamin, $nomorPeserta, $kelasId, $userId]
            );

            session()->setFlashdata('success', 'Data siswa berhasil diperbarui!');
            return redirect()->to(base_url('admin/siswa'));
        } catch (\Exception $e) {
            log_message('error', 'Error updating siswa: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function hapusSiswa($userId)
    {
        try {
            $this->userModel->softDelete($userId);
            session()->setFlashdata('success', 'Siswa berhasil dinonaktifkan!');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan saat menonaktifkan siswa.');
        }

        return redirect()->to(base_url('admin/siswa'));
    }

    public function restoreSiswa($userId)
    {
        try {
            $this->userModel->restore($userId);
            session()->setFlashdata('success', 'Siswa berhasil diaktifkan kembali!');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan saat mengaktifkan siswa.');
        }

        return redirect()->to(base_url('admin/siswa'));
    }

    public function batchCreateSiswa()
    {
        $kelasId      = $this->request->getGet('kelas');
        $jumlah       = (int) $this->request->getGet('jumlah');
        $prefix       = $this->request->getGet('prefix');
        $jenisKelamin = $this->request->getGet('jenis_kelamin');

        if (!$kelasId || !$jumlah || !$prefix || $jumlah > 50) {
            session()->setFlashdata('error', 'Parameter tidak valid');
            return redirect()->to(base_url('admin/siswa/tambah'));
        }

        try {
            $berhasil = 0;
            $gagal    = 0;
            $errors   = [];

            for ($i = 1; $i <= $jumlah; $i++) {
                $num       = str_pad($i, 3, '0', STR_PAD_LEFT);
                $username  = strtolower($prefix) . $num;
                $email     = $username . '@sekolah.com';
                $nama      = $prefix . ' ' . $num;
                $noPeserta = $prefix . $num;
                $password  = 'password123';
                $gender    = $jenisKelamin ?: (($i % 2 === 1) ? 'Laki-laki' : 'Perempuan');

                if ($this->userModel->where('username', $username)->first()) {
                    $gagal++;
                    $errors[] = "Username {$username} sudah digunakan";
                    continue;
                }

                $userId = $this->userModel->insert([
                    'username' => $username,
                    'email'    => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role'     => 'siswa',
                    'status'   => 'active',
                ]);

                if ($userId) {
                    $inserted = $this->siswaModel->insert([
                        'user_id'       => $userId,
                        'kelas_id'      => $kelasId,
                        'nomor_peserta' => $noPeserta,
                        'nama_lengkap'  => $nama,
                        'jenis_kelamin' => $gender,
                    ]);

                    if ($inserted) {
                        $berhasil++;
                    } else {
                        $gagal++;
                        $this->userModel->delete($userId);
                    }
                } else {
                    $gagal++;
                }
            }

            $message = "Batch create selesai. Berhasil: {$berhasil}, Gagal: {$gagal}";

            if ($gagal > 0) {
                $message .= "\nError: " . implode(', ', array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $message .= ' (dan ' . (count($errors) - 5) . ' error lainnya)';
                }
                session()->setFlashdata('warning', $message);
            } else {
                session()->setFlashdata('success', $message);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error batch create siswa: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat batch create siswa');
        }

        return redirect()->to(base_url('admin/siswa'));
    }
}
