<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Home::index');
$routes->get('guide', 'Home::guide');
$routes->get('profile', 'Home::profile');
$routes->get('contact', 'Home::contact');
$routes->get('about', 'Home::about');
$routes->get('faq', 'Home::faq');
$routes->get('bantuan', 'Home::bantuan');

// Auth routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('logout', 'Auth::logout');

// Admin routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
  $routes->get('dashboard', 'AdminController::dashboard');

  // Kelola Guru
  $routes->get('guru', 'GuruController::daftarGuru');
  $routes->get('guru/tambah', 'GuruController::formTambahGuru');
  $routes->post('guru/tambah', 'GuruController::tambahGuru');
  $routes->get('guru/edit/(:num)', 'GuruController::formEditGuru/$1');
  $routes->post('guru/edit/(:num)', 'GuruController::editGuru/$1');
  $routes->get('guru/hapus/(:num)', 'GuruController::hapusGuru/$1');
  $routes->get('guru/restore/(:num)', 'GuruController::restoreGuru/$1');
  $routes->post('guru/assign-kelas', 'GuruController::assignKelas');
  $routes->get('guru/remove-kelas/(:num)/(:num)', 'GuruController::removeKelas/$1/$2');

  // Kelola Siswa
  $routes->get('siswa', 'SiswaController::daftarSiswa');
  $routes->get('siswa/tambah', 'SiswaController::formTambahSiswa');
  $routes->post('siswa/tambah', 'SiswaController::tambahSiswa');
  $routes->get('siswa/edit/(:num)', 'SiswaController::formEditSiswa/$1');
  $routes->post('siswa/edit/(:num)', 'SiswaController::editSiswa/$1');
  $routes->get('siswa/hapus/(:num)', 'SiswaController::hapusSiswa/$1');
  $routes->get('siswa/restore/(:num)', 'SiswaController::restoreSiswa/$1');
  $routes->get('siswa/batch', 'SiswaController::batchCreateSiswa');

  // Kelola Sekolah
  $routes->get('sekolah', 'SekolahController::daftarSekolah');
  $routes->get('sekolah/tambah', 'SekolahController::formTambahSekolah');
  $routes->post('sekolah/tambah', 'SekolahController::tambahSekolah');
  $routes->get('sekolah/edit/(:num)', 'SekolahController::formEditSekolah/$1');
  $routes->post('sekolah/edit/(:num)', 'SekolahController::editSekolah/$1');
  $routes->get('sekolah/hapus/(:num)', 'SekolahController::hapusSekolah/$1');

  // Daftar Kelas dalam Sekolah
  $routes->get('sekolah/(:num)/kelas', 'SekolahController::daftarKelasBySekolah/$1');
  $routes->get('sekolah/(:num)/kelas/tambah', 'SekolahController::formTambahKelasSekolah/$1');
  $routes->post('sekolah/(:num)/kelas/tambah', 'SekolahController::tambahKelasSekolah/$1');

  $routes->get('sekolah/(:num)/kelas/edit/(:num)', 'SekolahController::formEditKelasSekolah/$1/$2');
  $routes->post('sekolah/(:num)/kelas/edit/(:num)', 'SekolahController::editKelasSekolah/$1/$2');
  $routes->get('sekolah/(:num)/kelas/hapus/(:num)', 'SekolahController::hapusKelasSekolah/$1/$2');

  $routes->get('sekolah/(:num)/kelas/(:num)/detail', 'SekolahController::detailKelasSekolah/$1/$2');
  $routes->post('sekolah/(:num)/kelas/(:num)/guru/assign', 'SekolahController::assignGuruKelasSekolah/$1/$2');
  $routes->get('sekolah/(:num)/kelas/(:num)/guru/remove/(:num)', 'SekolahController::removeGuruKelasSekolah/$1/$2/$3');
  $routes->get('sekolah/(:num)/kelas/(:num)/transfer-siswa/(:num)', 'SekolahController::transferSiswaSekolah/$1/$2/$3');
  $routes->post('sekolah/transfer-siswa/proses', 'SekolahController::prosesTransferSiswaSekolah');

  // Bank Soal
  $routes->get('bank-soal', 'BankSoalController::bankSoal');
  $routes->post('bank-soal/tambah', 'BankSoalController::tambahBankSoal');
  $routes->get('bank-soal/kategori/(:segment)', 'BankSoalController::bankSoalKategori/$1');
  $routes->get('bank-soal/kategori/(:segment)/jenis-ujian/(:num)', 'BankSoalController::bankSoalJenisUjian/$1/$2');
  $routes->get('bank-soal/kategori/(:segment)/jenis-ujian/(:num)/ujian/(:num)', 'BankSoalController::bankSoalUjian/$1/$2/$3');
  $routes->post('bank-soal/edit-kategori', 'BankSoalController::editKategori');
  $routes->get('bank-soal/hapus-kategori/(:segment)', 'BankSoalController::hapusKategori/$1');

  $routes->post('bank-soal/tambah-soal', 'BankSoalController::tambahSoalBankUjian');
  $routes->post('bank-soal/edit-soal/(:num)', 'BankSoalController::editSoalBankUjian/$1');
  $routes->get('bank-soal/hapus-soal/(:num)', 'BankSoalController::hapusSoalBankUjian/$1');
  $routes->get('bank-soal/hapus/(:num)', 'BankSoalController::hapusBankUjian/$1');

  // Kelola Mata Pelajaran
  $routes->get('jenis-ujian', 'JenisUjianController::jenisUjian');
  $routes->post('jenis-ujian/tambah', 'JenisUjianController::tambahJenisUjian');
  $routes->post('jenis-ujian/edit/(:num)', 'BankSoalController::editJenisUjian/$1');
  $routes->get('jenis-ujian/hapus/(:num)', 'JenisUjianController::hapusJenisUjian/$1');

  // API routes untuk AJAX
  $routes->get('api/kelas-by-sekolah/(:num)', 'ApiController::getKelasBySekolah/$1');
  $routes->get('api/jenis-ujian-by-kelas/(:num)', 'ApiController::getJenisUjianByKelas/$1');
  $routes->get('api/ujian-by-kelas/(:num)', 'ApiController::getUjianByKelas/$1');

  // API routes Bank Soal untuk AJAX
  $routes->get('bank-soal/api/kategori', 'BankSoalController::getKategoriTersedia');
  $routes->get('bank-soal/api/jenis-ujian', 'BankSoalController::getJenisUjianByKategori');
  $routes->get('bank-soal/api/bank-ujian', 'BankSoalController::getBankUjianByKategoriJenis');
  $routes->get('bank-soal/api/soal', 'BankSoalController::getSoalBankUjian');

  // Kelola Ujian
  $routes->get('ujian', 'UjianController::ujian');
  $routes->post('ujian/tambah', 'UjianController::tambahUjian');
  $routes->post('ujian/edit/(:num)', 'UjianController::editUjian/$1');
  $routes->get('ujian/hapus/(:num)', 'UjianController::hapusUjian/$1');

  // Kelola Soal Ujian
  $routes->get('soal/(:num)', 'SoalController::kelolaSoal/$1');
  $routes->post('soal/tambah', 'SoalController::tambahSoal');
  $routes->post('soal/edit/(:num)', 'SoalController::editSoal/$1');
  $routes->get('soal/hapus/(:num)/(:num)', 'SoalController::hapusSoal/$1/$2');
  $routes->post('soal/import-bank', 'SoalController::importSoalDariBank');

  // Kelola Jadwal Ujian
  $routes->get('jadwal-ujian', 'JadwalController::jadwalUjian');
  $routes->post('jadwal-ujian/tambah', 'JadwalController::tambahJadwal');
  $routes->post('jadwal-ujian/edit/(:num)', 'JadwalController::editJadwal/$1');
  $routes->get('jadwal-ujian/hapus/(:num)', 'JadwalController::hapusJadwal/$1');

  // Kelola Hasil Ujian
  $routes->get('hasil-ujian', 'HasilUjianController::daftarHasilUjian');
  $routes->get('hasil-ujian/siswa/(:num)', 'HasilUjianController::hasilUjianSiswa/$1');
  $routes->get('hasil-ujian/detail/(:num)', 'HasilUjianController::detailHasilSiswa/$1');
  $routes->get('hasil-ujian/hapus/(:num)', 'HasilUjianController::hapusHasilSiswa/$1');
  $routes->get('hasil-ujian/download-excel/(:num)', 'HasilUjianController::downloadExcelHTML/$1');
  $routes->get('hasil-ujian/download-pdf/(:num)', 'HasilUjianController::downloadPDFHTML/$1');

  // Kelola Pengumuman
  $routes->get('pengumuman', 'PengumumanController::pengumuman');
  $routes->post('pengumuman/tambah', 'PengumumanController::tambahPengumuman');
  $routes->post('pengumuman/edit/(:num)', 'PengumumanController::editPengumuman/$1');
  $routes->get('pengumuman/hapus/(:num)', 'PengumumanController::hapusPengumuman/$1');

  // Upload gambar editor
  $routes->post('upload-summernote-image', 'UploadController::uploadSummernoteImage');
  $routes->get('cleanup-orphaned-images', 'UploadController::cleanupOrphanedImages');
});

// Guru routes
$routes->group('guru', ['namespace' => 'App\Controllers\Guru'], function ($routes) {
  $routes->get('dashboard', 'Guru::dashboard');

  // Jenis Ujian / Mata Pelajaran
  $routes->get('jenis-ujian', 'JenisUjianController::index');
  $routes->post('jenis-ujian/tambah', 'JenisUjianController::tambah');
  $routes->post('jenis-ujian/edit/(:num)', 'JenisUjianController::edit/$1');
  $routes->get('jenis-ujian/hapus/(:num)', 'JenisUjianController::hapus/$1');

  // Ujian
  $routes->get('ujian', 'UjianController::index');
  $routes->post('ujian/tambah', 'UjianController::tambah');
  $routes->post('ujian/edit/(:num)', 'UjianController::edit/$1');
  $routes->get('ujian/hapus/(:num)', 'UjianController::hapus/$1');

  // Soal
  $routes->get('soal/(:num)', 'SoalController::index/$1');
  $routes->post('soal/tambah', 'SoalController::tambah');
  $routes->post('soal/edit/(:num)', 'SoalController::edit/$1');
  $routes->get('soal/hapus/(:num)/(:num)', 'SoalController::hapus/$1/$2');

  // Jadwal Ujian
  $routes->get('jadwal-ujian', 'JadwalController::index');
  $routes->post('jadwal-ujian/tambah', 'JadwalController::tambah');
  $routes->post('jadwal-ujian/edit/(:num)', 'JadwalController::edit/$1');
  $routes->get('jadwal-ujian/hapus/(:num)', 'JadwalController::hapus/$1');

  // Hasil Ujian
  $routes->get('hasil-ujian', 'HasilUjianController::index');
  $routes->get('hasil-ujian/siswa/(:num)', 'HasilUjianController::siswa/$1');
  $routes->get('hasil-ujian/detail/(:num)', 'HasilUjianController::detail/$1');
  $routes->get('hasil-ujian/hapus/(:num)', 'HasilUjianController::hapusHasilSiswa/$1');
  $routes->get('hasil-ujian/reset/(:num)', 'HasilUjianController::resetStatusSiswa/$1');

  // Pengumuman
  $routes->get('pengumuman', 'PengumumanController::index');
  $routes->post('pengumuman/tambah', 'PengumumanController::tambah');
  $routes->post('pengumuman/edit/(:num)', 'PengumumanController::edit/$1');
  $routes->get('pengumuman/hapus/(:num)', 'PengumumanController::hapus/$1');

  // Profil
  $routes->get('profil', 'ProfilController::index');
  $routes->post('profil/save', 'ProfilController::save');

  // Bank Soal
  $routes->get('bank-soal', 'BankSoalController::index');
  $routes->post('bank-soal/tambah', 'BankSoalController::tambah');
  $routes->get('bank-soal/kategori/(:segment)', 'BankSoalController::kategori/$1');
  $routes->get('bank-soal/ujian/(:segment)/(:num)/(:num)', 'BankSoalController::ujian/$1/$2/$3');
});

$routes->get('guru/hasil-ujian/download-excel-html/(:num)', 'Guru\Guru::downloadExcelHTML/$1');
$routes->get('guru/hasil-ujian/download-pdf-html/(:num)', 'Guru\Guru::downloadPDFHTML/$1');


// Siswa routes
$routes->group('siswa', ['namespace' => 'App\Controllers\Siswa'], function ($routes) {
  $routes->get('dashboard', 'Siswa::dashboard');
  $routes->get('pengumuman', 'PengumumanController::index');

  // Profil
  $routes->get('profil', 'ProfilController::index');
  $routes->post('profil/save', 'ProfilController::save');
  $routes->get('api/kelas-by-sekolah/(:num)', 'ProfilController::getKelasBySekolah/$1');

  // Ujian
  $routes->get('ujian', 'UjianController::index');
  $routes->post('ujian/mulai', 'UjianController::mulai');
  $routes->get('ujian/soal/(:num)', 'UjianController::soal/$1');
  $routes->post('ujian/simpan-jawaban', 'UjianController::simpanJawaban');
  $routes->get('ujian/selesai/(:num)', 'UjianController::selesai/$1');

  // Hasil
  $routes->get('hasil', 'HasilController::index');
  $routes->get('hasil/detail/(:num)', 'HasilController::detail/$1');
  $routes->get('hasil/unduh/(:num)', 'HasilController::unduh/$1');
});
