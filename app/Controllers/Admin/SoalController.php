<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\UjianModel;
use App\Models\SoalUjianModel;
use App\Models\HasilUjianModel;
use Config\Database;

class SoalController extends Controller
{
    protected $db;
    protected $ujianModel;
    protected $soalUjianModel;
    protected $hasilUjianModel;

    public function __construct()
    {
        $this->db              = Database::connect();
        $this->ujianModel      = new UjianModel();
        $this->soalUjianModel  = new SoalUjianModel();
        $this->hasilUjianModel = new HasilUjianModel();
    }

    public function kelolaSoal($ujian_id)
    {
        $data['ujian'] = $this->ujianModel->find($ujian_id);
        if (!$data['ujian']) {
            return redirect()->to('admin/ujian/')->with('error', 'Ujian tidak ditemukan.');
        }

        $data['soal'] = $this->soalUjianModel->where('ujian_id', $ujian_id)->findAll();
        return view('admin/ujian/kelola_soal', $data);
    }

    public function tambahSoal()
    {
        $rules = [
            'ujian_id'          => 'required|numeric',
            'pertanyaan'        => 'required',
            'kode_soal'         => 'required|alpha_numeric_punct|min_length[3]|max_length[50]|is_unique[soal_ujian.kode_soal]',
            'pilihan_a'         => 'required',
            'pilihan_b'         => 'required',
            'pilihan_c'         => 'required',
            'pilihan_d'         => 'required',
            'jawaban_benar'     => 'required|in_list[A,B,C,D,E]',
            'tingkat_kesulitan' => 'required|decimal',
            'foto'              => 'max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]|ext_in[foto,png,jpg,jpeg]',
            'pembahasan'        => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            $this->cleanupTempImages();
            $errors = $this->validator->getErrors();
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . implode(', ', $errors));
        }

        $data = [
            'ujian_id'          => $this->request->getPost('ujian_id'),
            'pertanyaan'        => $this->request->getPost('pertanyaan'),
            'kode_soal'         => $this->request->getPost('kode_soal'),
            'pilihan_a'         => $this->request->getPost('pilihan_a'),
            'pilihan_b'         => $this->request->getPost('pilihan_b'),
            'pilihan_c'         => $this->request->getPost('pilihan_c'),
            'pilihan_d'         => $this->request->getPost('pilihan_d'),
            'pilihan_e'         => $this->request->getPost('pilihan_e'),
            'jawaban_benar'     => $this->request->getPost('jawaban_benar'),
            'tingkat_kesulitan' => $this->request->getPost('tingkat_kesulitan'),
            'pembahasan'        => $this->request->getPost('pembahasan'),
            'created_by'        => session()->get('user_id'),
        ];

        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $newName    = $fotoFile->getRandomName();
            $uploadPath = FCPATH . 'uploads/soal';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $fotoFile->move($uploadPath, $newName);
            $data['foto'] = $newName;
        }

        try {
            $soalId = $this->soalUjianModel->insert($data);

            if ($soalId) {
                $allHtml    = $data['pertanyaan'] . ' ' . $data['pilihan_a'] . ' ' . $data['pilihan_b'] . ' '
                    . $data['pilihan_c'] . ' ' . $data['pilihan_d'] . ' ' . ($data['pilihan_e'] ?? '') . ' '
                    . ($data['pembahasan'] ?? '');
                $usedImages = $this->extractImageFilenames($allHtml);
                $tempImages = session()->get('temp_uploaded_images') ?? [];
                $this->cleanupUnusedImages($usedImages, $tempImages);
                session()->remove('temp_uploaded_images');

                return redirect()->to('admin/soal/' . $data['ujian_id'])->with('success', 'Soal berhasil ditambahkan');
            } else {
                throw new \Exception('Gagal menyimpan soal');
            }
        } catch (\Exception $e) {
            $this->cleanupTempImages();
            log_message('error', 'Error saat menambahkan soal: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan soal: ' . $e->getMessage());
        }
    }

    public function editSoal($id)
    {
        $soal = $this->soalUjianModel->find($id);
        if (!$soal) {
            return redirect()->back()->with('error', 'Soal tidak ditemukan.');
        }

        $oldHtml      = $soal['pertanyaan'] . ' ' . $soal['pilihan_a'] . ' ' . $soal['pilihan_b'] . ' '
            . $soal['pilihan_c'] . ' ' . $soal['pilihan_d'] . ' ' . ($soal['pilihan_e'] ?? '') . ' '
            . ($soal['pembahasan'] ?? '');
        $oldUsedImages = $this->extractImageFilenames($oldHtml);

        $rules = [
            'kode_soal'         => "required|alpha_numeric_punct|min_length[3]|max_length[50]|is_unique[soal_ujian.kode_soal,soal_id,{$id}]",
            'pertanyaan'        => 'required',
            'pilihan_a'         => 'required',
            'pilihan_b'         => 'required',
            'pilihan_c'         => 'required',
            'pilihan_d'         => 'required',
            'jawaban_benar'     => 'required|in_list[A,B,C,D,E]',
            'tingkat_kesulitan' => 'required|decimal',
            'foto'              => 'max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]|ext_in[foto,png,jpg,jpeg]',
            'pembahasan'        => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            $this->cleanupTempImages();
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . implode(', ', $this->validator->getErrors()));
        }

        $data = [
            'kode_soal'         => $this->request->getPost('kode_soal'),
            'pertanyaan'        => $this->request->getPost('pertanyaan'),
            'pilihan_a'         => $this->request->getPost('pilihan_a'),
            'pilihan_b'         => $this->request->getPost('pilihan_b'),
            'pilihan_c'         => $this->request->getPost('pilihan_c'),
            'pilihan_d'         => $this->request->getPost('pilihan_d'),
            'pilihan_e'         => $this->request->getPost('pilihan_e'),
            'jawaban_benar'     => $this->request->getPost('jawaban_benar'),
            'tingkat_kesulitan' => $this->request->getPost('tingkat_kesulitan'),
            'pembahasan'        => $this->request->getPost('pembahasan'),
        ];

        $uploadPath = FCPATH . 'uploads/soal';
        $fotoFile   = $this->request->getFile('foto');

        if ($fotoFile->isValid() && !$fotoFile->hasMoved()) {
            if (!empty($soal['foto'])) {
                $fotoPath = $uploadPath . '/' . $soal['foto'];
                if (file_exists($fotoPath)) {
                    unlink($fotoPath);
                }
            }
            $newName = $fotoFile->getRandomName();
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $fotoFile->move($uploadPath, $newName);
            $data['foto'] = $newName;
        }

        if ($this->request->getPost('hapus_foto') == '1' && !empty($soal['foto'])) {
            $fotoPath = $uploadPath . '/' . $soal['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
            $data['foto'] = null;
        }

        try {
            $this->soalUjianModel->update($id, $data);

            $newHtml      = $data['pertanyaan'] . ' ' . $data['pilihan_a'] . ' ' . $data['pilihan_b'] . ' '
                . $data['pilihan_c'] . ' ' . $data['pilihan_d'] . ' ' . ($data['pilihan_e'] ?? '') . ' '
                . ($data['pembahasan'] ?? '');
            $newUsedImages = $this->extractImageFilenames($newHtml);
            $tempImages    = session()->get('temp_uploaded_images') ?? [];

            foreach (array_diff($oldUsedImages, $newUsedImages) as $filename) {
                $imagePath = FCPATH . 'uploads/editor-images/' . $filename;
                if (file_exists($imagePath) && !$this->checkImageUsageInOtherQuestions($filename, $id)) {
                    unlink($imagePath);
                }
            }

            $this->cleanupUnusedImages($newUsedImages, $tempImages);
            session()->remove('temp_uploaded_images');

            $ujian_id = $this->request->getPost('ujian_id');
            return redirect()->to('admin/soal/' . $ujian_id)->with('success', 'Soal berhasil diupdate');
        } catch (\Exception $e) {
            $this->cleanupTempImages();
            log_message('error', 'Error saat mengupdate soal: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui soal: ' . $e->getMessage());
        }
    }

    public function hapusSoal($id, $ujian_id)
    {
        $isAnswered = $this->hasilUjianModel->where('soal_id', $id)->countAllResults() > 0;
        if ($isAnswered) {
            return redirect()->to('admin/soal/' . $ujian_id)
                ->with('error', 'Gagal! Soal ini tidak dapat dihapus karena sudah menjadi bagian dari riwayat pengerjaan siswa.');
        }

        try {
            $soal = $this->soalUjianModel->find($id);
            if ($soal) {
                if (!empty($soal['foto'])) {
                    $isUsedElsewhere = $this->soalUjianModel->where('foto', $soal['foto'])->where('soal_id !=', $id)->countAllResults() > 0;
                    if (!$isUsedElsewhere) {
                        $fotoPath = FCPATH . 'uploads/soal/' . $soal['foto'];
                        if (file_exists($fotoPath)) {
                            unlink($fotoPath);
                        }
                    }
                }

                $allHtml = $soal['pertanyaan'] . ' ' . $soal['pilihan_a'] . ' ' . $soal['pilihan_b'] . ' '
                    . $soal['pilihan_c'] . ' ' . $soal['pilihan_d'] . ' ' . ($soal['pilihan_e'] ?? '') . ' '
                    . ($soal['pembahasan'] ?? '');

                foreach ($this->extractImageFilenames($allHtml) as $filename) {
                    if (!$this->checkImageUsageInOtherQuestions($filename, $id)) {
                        $imagePath = FCPATH . 'uploads/editor-images/' . $filename;
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }

                $this->soalUjianModel->delete($id);
                return redirect()->to('admin/soal/' . $ujian_id)->with('success', 'Soal berhasil dihapus.');
            } else {
                return redirect()->to('admin/soal/' . $ujian_id)->with('error', 'Soal tidak ditemukan.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Gagal menghapus soal: ' . $e->getMessage());
            return redirect()->to('admin/soal/' . $ujian_id)->with('error', 'Terjadi kesalahan saat menghapus soal.');
        }
    }

    public function importSoalDariBank()
    {
        $ujianId = $this->request->getPost('ujian_id');
        $soalIds = $this->request->getPost('soal_ids');

        if (!$ujianId || empty($soalIds) || !is_array($soalIds)) {
            return redirect()->back()->with('error', 'Data tidak lengkap. Pilih minimal satu soal untuk diimpor.');
        }

        $userId        = session()->get('user_id');
        $berhasilImport = 0;
        $gagalImport   = 0;
        $errorMessages = [];

        foreach ($soalIds as $soalId) {
            $soalBank = $this->soalUjianModel->find($soalId);

            if ($soalBank && $soalBank['is_bank_soal']) {
                $dataSoalBaru               = $soalBank;
                unset($dataSoalBaru['soal_id']);
                $dataSoalBaru['ujian_id']      = $ujianId;
                $dataSoalBaru['bank_ujian_id'] = null;
                $dataSoalBaru['is_bank_soal']  = false;
                $dataSoalBaru['created_by']    = $userId;
                $dataSoalBaru['created_at']    = date('Y-m-d H:i:s');
                $dataSoalBaru['updated_at']    = date('Y-m-d H:i:s');

                try {
                    $this->soalUjianModel->insert($dataSoalBaru);
                    $berhasilImport++;
                } catch (\Exception $e) {
                    log_message('error', 'Admin gagal import soal: ' . $e->getMessage());
                    $gagalImport++;
                    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                        $errorMessages[] = "Soal dengan kode '{$dataSoalBaru['kode_soal']}' sudah ada di ujian ini.";
                    }
                }
            } else {
                $gagalImport++;
            }
        }

        $message = "Proses import selesai: {$berhasilImport} soal berhasil diimpor.";
        if ($gagalImport > 0) {
            $message .= " {$gagalImport} soal gagal.";
            if (!empty($errorMessages)) {
                $message .= ' Alasan: ' . implode(', ', $errorMessages);
            }
            session()->setFlashdata('warning', $message);
        } else {
            session()->setFlashdata('success', $message);
        }

        return redirect()->to('admin/soal/' . $ujianId);
    }

    // ===== Private Helpers =====

    private function extractImageFilenames($htmlContent)
    {
        $imageFiles = [];
        if (preg_match_all('/uploads\/editor-images\/([^"\'>\s]+)/', $htmlContent, $matches)) {
            $imageFiles = array_unique($matches[1]);
        }
        return $imageFiles;
    }

    private function cleanupUnusedImages($usedImages, $allUploadedImages)
    {
        foreach ($allUploadedImages as $imageInfo) {
            if (!in_array($imageInfo['filename'], $usedImages) && file_exists($imageInfo['path'])) {
                unlink($imageInfo['path']);
            }
        }
    }

    private function cleanupTempImages()
    {
        $tempImages = session()->get('temp_uploaded_images') ?? [];
        foreach ($tempImages as $imageInfo) {
            if (file_exists($imageInfo['path'])) {
                unlink($imageInfo['path']);
            }
        }
        session()->remove('temp_uploaded_images');
    }

    private function checkImageUsageInOtherQuestions($filename, $excludeSoalId)
    {
        $builder = $this->db->table('soal_ujian');
        $builder->where('soal_id !=', $excludeSoalId);
        $builder->groupStart();
        $builder->like('pertanyaan', $filename);
        $builder->orLike('pilihan_a', $filename);
        $builder->orLike('pilihan_b', $filename);
        $builder->orLike('pilihan_c', $filename);
        $builder->orLike('pilihan_d', $filename);
        $builder->orLike('pilihan_e', $filename);
        $builder->orLike('pembahasan', $filename);
        $builder->groupEnd();
        return $builder->countAllResults() > 0;
    }
}
