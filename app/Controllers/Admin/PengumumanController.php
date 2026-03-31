<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\PengumumanModel;

class PengumumanController extends Controller
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    public function pengumuman()
    {
        $data['pengumuman'] = $this->pengumumanModel->getPengumumanWithUser();
        return view('admin/pengumuman', $data);
    }

    public function tambahPengumuman()
    {
        $data = [
            'judul'            => $this->request->getPost('judul'),
            'isi_pengumuman'   => $this->request->getPost('isi_pengumuman'),
            'tanggal_publish'  => $this->request->getPost('tanggal_publish'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir'),
            'created_by'       => session()->get('user_id'),
        ];
        $this->pengumumanModel->insert($data);
        return redirect()->to('admin/pengumuman')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function editPengumuman($id)
    {
        $data = [
            'judul'            => $this->request->getPost('judul'),
            'isi_pengumuman'   => $this->request->getPost('isi_pengumuman'),
            'tanggal_publish'  => $this->request->getPost('tanggal_publish'),
            'tanggal_berakhir' => $this->request->getPost('tanggal_berakhir'),
        ];
        $this->pengumumanModel->update($id, $data);
        return redirect()->to('admin/pengumuman')->with('success', 'Pengumuman berhasil diupdate');
    }

    public function hapusPengumuman($id)
    {
        $this->pengumumanModel->delete($id);
        return redirect()->to('admin/pengumuman')->with('success', 'Pengumuman berhasil dihapus');
    }

    public function toggleStatusPengumuman($pengumumanId)
    {
        try {
            $pengumuman = $this->pengumumanModel->find($pengumumanId);

            if (!$pengumuman) {
                session()->setFlashdata('error', 'Pengumuman tidak ditemukan');
                return redirect()->to(base_url('admin/pengumuman'));
            }

            $newStatus = $pengumuman['tanggal_berakhir'] ? null : date('Y-m-d H:i:s');
            $this->pengumumanModel->update($pengumumanId, ['tanggal_berakhir' => $newStatus]);

            $statusText = $newStatus ? 'dinonaktifkan' : 'diaktifkan';
            session()->setFlashdata('success', "Pengumuman berhasil {$statusText}!");
        } catch (\Exception $e) {
            log_message('error', 'Error toggling pengumuman status: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat mengubah status pengumuman.');
        }

        return redirect()->to(base_url('admin/pengumuman'));
    }
}
