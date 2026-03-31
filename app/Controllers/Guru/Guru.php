<?php

namespace App\Controllers\Guru;

use CodeIgniter\Controller;

class Guru extends Controller
{
    /**
     * Dashboard Guru
     */
    public function dashboard()
    {
        return view('guru/dashboard');
    }
}
