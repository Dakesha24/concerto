<?php

namespace App\Controllers\Siswa;

use CodeIgniter\Controller;

class Siswa extends Controller
{
    /**
     * Dashboard Siswa
     */
    public function dashboard()
    {
        return view('siswa/dashboard');
    }
}
