<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class UploadController extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function uploadSummernoteImage()
    {
        $userRole = session()->get('role');
        if (!session()->get('user_id') || !in_array($userRole, ['admin', 'guru'])) {
            return $this->response->setJSON(['success' => false, 'error' => 'Unauthorized']);
        }

        try {
            $uploadedFile = $this->request->getFile('upload');

            if (!$uploadedFile || !$uploadedFile->isValid()) {
                return $this->response->setJSON(['success' => false, 'error' => 'No file uploaded']);
            }

            $ext = strtolower($uploadedFile->getClientExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                return $this->response->setJSON(['success' => false, 'error' => 'Invalid file type']);
            }

            if ($uploadedFile->getSize() > 2097152) {
                return $this->response->setJSON(['success' => false, 'error' => 'File too large']);
            }

            $fileName   = 'editor_' . time() . '_' . uniqid() . '.' . $ext;
            $uploadPath = FCPATH . 'uploads/editor-images';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if ($uploadedFile->move($uploadPath, $fileName)) {
                $imageUrl   = base_url('uploads/editor-images/' . $fileName);
                $tempImages = session()->get('temp_uploaded_images') ?? [];
                $tempImages[] = [
                    'filename'    => $fileName,
                    'path'        => $uploadPath . '/' . $fileName,
                    'uploaded_at' => time(),
                ];
                session()->set('temp_uploaded_images', $tempImages);

                return $this->response->setJSON([
                    'success'  => true,
                    'url'      => $imageUrl,
                    'filename' => $fileName,
                    'message'  => 'Upload successful',
                ]);
            } else {
                return $this->response->setJSON(['success' => false, 'error' => 'Failed to save file']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function cleanupOrphanedImages()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Unauthorized');
        }

        $uploadPath   = FCPATH . 'uploads/editor-images/';
        $deletedCount = 0;

        if (is_dir($uploadPath)) {
            $files = scandir($uploadPath);

            foreach ($files as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }

                $filePath = $uploadPath . $file;
                if (is_file($filePath)) {
                    $isUsed = $this->checkImageUsage($file);

                    if (!$isUsed) {
                        $fileAge = time() - filemtime($filePath);
                        if ($fileAge > 86400) {
                            unlink($filePath);
                            $deletedCount++;
                        }
                    }
                }
            }
        }

        return redirect()->back()->with('success', "Cleanup selesai. {$deletedCount} file orphaned dihapus.");
    }

    private function checkImageUsage($filename)
    {
        $builder = $this->db->table('soal_ujian');
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
