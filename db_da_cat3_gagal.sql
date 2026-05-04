-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 06:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_da_cat3`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_ujian`
--

CREATE TABLE `bank_ujian` (
  `bank_ujian_id` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `jenis_ujian_id` int(11) NOT NULL,
  `nama_ujian` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `guru_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sekolah_id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `mata_pelajaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_ujian`
--

CREATE TABLE `hasil_ujian` (
  `jawaban_id` int(11) NOT NULL,
  `peserta_ujian_id` int(11) NOT NULL,
  `soal_id` int(11) NOT NULL,
  `jawaban_siswa` enum('A','B','C','D','E') NOT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `waktu_menjawab` timestamp NOT NULL DEFAULT current_timestamp(),
  `theta_saat_ini` decimal(5,3) DEFAULT NULL,
  `se_saat_ini` decimal(5,3) DEFAULT NULL,
  `delta_se_saat_ini` decimal(5,3) NOT NULL,
  `pi_saat_ini` decimal(5,3) DEFAULT NULL,
  `qi_saat_ini` decimal(5,3) DEFAULT NULL,
  `ii_saat_ini` decimal(5,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ujian`
--

CREATE TABLE `jadwal_ujian` (
  `jadwal_id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `durasi_menit` int(11) NOT NULL,
  `kode_akses` varchar(20) NOT NULL,
  `status` enum('belum_mulai','sedang_berlangsung','selesai') NOT NULL DEFAULT 'belum_mulai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_ujian`
--

CREATE TABLE `jenis_ujian` (
  `jenis_ujian_id` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `nama_jenis` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `kelas_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `kelas_id` int(11) NOT NULL,
  `sekolah_id` int(11) NOT NULL,
  `nama_kelas` varchar(20) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas_guru`
--

CREATE TABLE `kelas_guru` (
  `kelas_guru_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `pengumuman_id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `isi_pengumuman` text NOT NULL,
  `tanggal_publish` datetime DEFAULT current_timestamp(),
  `tanggal_berakhir` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peserta_ujian`
--

CREATE TABLE `peserta_ujian` (
  `peserta_ujian_id` int(11) NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `status` enum('belum_mulai','sedang_mengerjakan','selesai') DEFAULT 'belum_mulai',
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

CREATE TABLE `sekolah` (
  `sekolah_id` int(11) NOT NULL,
  `nama_sekolah` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `siswa_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `nomor_peserta` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `soal_ujian`
--

CREATE TABLE `soal_ujian` (
  `soal_id` int(11) NOT NULL,
  `kode_soal` varchar(50) DEFAULT NULL,
  `ujian_id` int(11) DEFAULT NULL,
  `bank_ujian_id` int(11) DEFAULT NULL,
  `pertanyaan` text NOT NULL,
  `pilihan_a` text NOT NULL,
  `pilihan_b` text NOT NULL,
  `pilihan_c` text NOT NULL,
  `pilihan_d` text NOT NULL,
  `pilihan_e` text NOT NULL,
  `pembahasan` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jawaban_benar` enum('A','B','C','D','E') NOT NULL,
  `tingkat_kesulitan` decimal(5,3) NOT NULL DEFAULT 0.000 COMMENT 'parameter b',
  `is_bank_soal` tinyint(1) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `id_ujian` int(11) NOT NULL,
  `jenis_ujian_id` int(11) NOT NULL,
  `nama_ujian` varchar(100) NOT NULL,
  `kode_ujian` varchar(50) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `se_awal` decimal(6,4) NOT NULL DEFAULT 1.0000,
  `se_minimum` decimal(6,4) NOT NULL DEFAULT 0.2500,
  `delta_se_minimum` decimal(6,4) NOT NULL DEFAULT 0.0100,
  `maksimal_soal_tampil` int(11) DEFAULT 20,
  `durasi` time NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `kelas_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa','guru') NOT NULL DEFAULT 'siswa',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$BzOctZLZGFMUeyGscyM8IOD6cbtRJpnMpaVZYDgl90ueKB8QFIEJu', 'admin', 'active', '2024-12-10 21:49:44', '2024-12-10 21:49:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_ujian`
--
ALTER TABLE `bank_ujian`
  ADD PRIMARY KEY (`bank_ujian_id`),
  ADD UNIQUE KEY `unique_bank_ujian` (`kategori`,`jenis_ujian_id`,`nama_ujian`,`created_by`),
  ADD KEY `jenis_ujian_id` (`jenis_ujian_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`guru_id`),
  ADD KEY `guru_id` (`user_id`),
  ADD KEY `sekolah_id` (`sekolah_id`);

--
-- Indexes for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD PRIMARY KEY (`jawaban_id`),
  ADD KEY `peserta_ujian_id` (`peserta_ujian_id`),
  ADD KEY `soal_id` (`soal_id`);

--
-- Indexes for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD PRIMARY KEY (`jadwal_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `jenis_ujian_id` (`ujian_id`);

--
-- Indexes for table `jenis_ujian`
--
ALTER TABLE `jenis_ujian`
  ADD PRIMARY KEY (`jenis_ujian_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kelas_id`),
  ADD KEY `sekolah_id` (`sekolah_id`);

--
-- Indexes for table `kelas_guru`
--
ALTER TABLE `kelas_guru`
  ADD PRIMARY KEY (`kelas_guru_id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`pengumuman_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `peserta_ujian`
--
ALTER TABLE `peserta_ujian`
  ADD PRIMARY KEY (`peserta_ujian_id`),
  ADD KEY `jadwal_id` (`jadwal_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`sekolah_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`siswa_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `soal_ujian`
--
ALTER TABLE `soal_ujian`
  ADD PRIMARY KEY (`soal_id`),
  ADD KEY `ujian_id` (`ujian_id`),
  ADD KEY `bank_ujian_id` (`bank_ujian_id`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id_ujian`),
  ADD KEY `jenis_ujian_id` (`jenis_ujian_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_ujian`
--
ALTER TABLE `bank_ujian`
  MODIFY `bank_ujian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `guru_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  MODIFY `jawaban_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=520;

--
-- AUTO_INCREMENT for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  MODIFY `jadwal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jenis_ujian`
--
ALTER TABLE `jenis_ujian`
  MODIFY `jenis_ujian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kelas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kelas_guru`
--
ALTER TABLE `kelas_guru`
  MODIFY `kelas_guru_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `pengumuman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peserta_ujian`
--
ALTER TABLE `peserta_ujian`
  MODIFY `peserta_ujian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `sekolah_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `siswa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `soal_ujian`
--
ALTER TABLE `soal_ujian`
  MODIFY `soal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_ujian`
--
ALTER TABLE `bank_ujian`
  ADD CONSTRAINT `bank_ujian_ibfk_1` FOREIGN KEY (`jenis_ujian_id`) REFERENCES `jenis_ujian` (`jenis_ujian_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bank_ujian_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `guru_ibfk_2` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`sekolah_id`);

--
-- Constraints for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD CONSTRAINT `hasil_ujian_ibfk_1` FOREIGN KEY (`peserta_ujian_id`) REFERENCES `peserta_ujian` (`peserta_ujian_id`),
  ADD CONSTRAINT `hasil_ujian_ibfk_2` FOREIGN KEY (`soal_id`) REFERENCES `soal_ujian` (`soal_id`);

--
-- Constraints for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD CONSTRAINT `jadwal_ujian_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`),
  ADD CONSTRAINT `jadwal_ujian_ibfk_3` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`guru_id`),
  ADD CONSTRAINT `jadwal_ujian_ibfk_4` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id_ujian`);

--
-- Constraints for table `jenis_ujian`
--
ALTER TABLE `jenis_ujian`
  ADD CONSTRAINT `jenis_ujian_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`),
  ADD CONSTRAINT `jenis_ujian_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`sekolah_id`);

--
-- Constraints for table `kelas_guru`
--
ALTER TABLE `kelas_guru`
  ADD CONSTRAINT `kelas_guru_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`guru_id`),
  ADD CONSTRAINT `kelas_guru_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`);

--
-- Constraints for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `peserta_ujian`
--
ALTER TABLE `peserta_ujian`
  ADD CONSTRAINT `peserta_ujian_ibfk_1` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_ujian` (`jadwal_id`),
  ADD CONSTRAINT `peserta_ujian_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`siswa_id`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `siswa_kelas_fk` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `soal_ujian`
--
ALTER TABLE `soal_ujian`
  ADD CONSTRAINT `soal_ujian_ibfk_1` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id_ujian`),
  ADD CONSTRAINT `soal_ujian_ibfk_2` FOREIGN KEY (`bank_ujian_id`) REFERENCES `bank_ujian` (`bank_ujian_id`) ON DELETE CASCADE;

--
-- Constraints for table `ujian`
--
ALTER TABLE `ujian`
  ADD CONSTRAINT `ujian_ibfk_1` FOREIGN KEY (`jenis_ujian_id`) REFERENCES `jenis_ujian` (`jenis_ujian_id`),
  ADD CONSTRAINT `ujian_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`),
  ADD CONSTRAINT `ujian_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
