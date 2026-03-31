<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class AdminController extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function dashboard()
    {
        $data['stats'] = [
            'total_guru'    => $this->db->table('guru')->countAllResults(),
            'total_siswa'   => $this->db->table('siswa')->countAllResults(),
            'total_sekolah' => $this->db->table('sekolah')->countAllResults(),
            'total_kelas'   => $this->db->table('kelas')->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }
}
