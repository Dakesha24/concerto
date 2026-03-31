<?php

namespace App\Controllers\Guru;

use CodeIgniter\Controller;
use App\Models\PengumumanModel;

class PengumumanController extends Controller
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    public function index()
    {
        $data['pengumuman'] = $this->pengumumanModel->getPengumumanWithUser();
        return view('guru/pengumuman', $data);
    }

    public function tambah()
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi_pengumuman' => $this->request->getPost('isi_pengumuman'),
            'tanggal_publish' => $this->request->getPost('tanggal_publish'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir'),
            'created_by' => session()->get('user_id')
        ];
        $this->pengumumanModel->insert($data);
        return redirect()->to('guru/pengumuman')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi_pengumuman' => $this->request->getPost('isi_pengumuman'),
            'tanggal_publish' => $this->request->getPost('tanggal_publish'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir')
        ];
        $this->pengumumanModel->update($id, $data);
        return redirect()->to('guru/pengumuman')->with('success', 'Pengumuman berhasil diupdate');
    }

    public function hapus($id)
    {
        $this->pengumumanModel->delete($id);
        return redirect()->to('guru/pengumuman')->with('success', 'Pengumuman berhasil dihapus');
    }
}
