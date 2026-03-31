<?php

namespace App\Controllers\Siswa;

use CodeIgniter\Controller;
use App\Models\PengumumanModel;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumanModel = new PengumumanModel();
        $data['pengumuman'] = $pengumumanModel->getPengumumanWithUser();
        return view('siswa/pengumuman', $data);
    }
}
