<?= $this->extend('templates/guru/guru_template') ?>

<?= $this->section('content') ?>
<div class="container guru-dashboard-page py-4">

    <!-- Welcome Hero -->
    <div class="welcome-hero mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="eyebrow-text">Dashboard Guru</span>
                <h1 class="dashboard-title mb-2">Selamat Datang, <?= session()->get('username') ?>!</h1>
                <p class="dashboard-subtitle mb-3 text-muted">Kelola mata pelajaran, bank soal, ujian, jadwal, dan pengumuman dalam satu tempat.</p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('guru/ujian') ?>" class="btn btn-primary dashboard-btn">
                        <i class="bi bi-file-earmark-text me-2"></i>Kelola Ujian
                    </a>
                    <a href="<?= base_url('guru/jadwal-ujian') ?>" class="btn btn-outline-primary dashboard-btn">
                        <i class="bi bi-calendar-check me-2"></i>Jadwal Ujian
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <img src="<?= base_url('assets/images/heros.png') ?>" alt="Welcome" class="img-fluid hero-img-mini">
            </div>
        </div>
    </div>

    <h5 class="dashboard-section-title mb-3">Menu Utama</h5>

    <div class="row g-3">

        <div class="col-md-4">
            <a href="<?= base_url('guru/jenis-ujian') ?>" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="bi bi-journal-richtext fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2">Mata Pelajaran</h5>
                        <p class="card-text text-muted">Kelola kategori dan daftar mata pelajaran yang tersedia dalam sistem ujian.</p>
                        <div class="mt-3 card-link-text">
                            Kelola Mata Pelajaran <i class="bi bi-arrow-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('guru/bank-soal') ?>" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="bi bi-database fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2">Bank Soal</h5>
                        <p class="card-text text-muted">Kelola koleksi soal yang dapat digunakan untuk menyusun berbagai ujian adaptif.</p>
                        <div class="mt-3 card-link-text">
                            Kelola Bank Soal <i class="bi bi-arrow-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('guru/ujian') ?>" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="bi bi-file-earmark-text fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2">Ujian</h5>
                        <p class="card-text text-muted">Buat dan kelola paket ujian beserta konfigurasi soal adaptif untuk siswa.</p>
                        <div class="mt-3 card-link-text">
                            Kelola Ujian <i class="bi bi-arrow-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('guru/jadwal-ujian') ?>" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="bi bi-calendar-check fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2">Jadwal Ujian</h5>
                        <p class="card-text text-muted">Atur sesi dan jadwal pelaksanaan ujian serta pantau status kehadiran peserta.</p>
                        <div class="mt-3 card-link-text">
                            Kelola Jadwal <i class="bi bi-arrow-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('guru/hasil-ujian') ?>" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="bi bi-bar-chart-line fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2">Hasil Ujian</h5>
                        <p class="card-text text-muted">Lihat dan analisis hasil ujian siswa, serta unduh laporan dalam format PDF.</p>
                        <div class="mt-3 card-link-text">
                            Lihat Hasil <i class="bi bi-arrow-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= base_url('guru/pengumuman') ?>" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper">
                            <i class="bi bi-megaphone fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2">Pengumuman</h5>
                        <p class="card-text text-muted">Buat dan kelola pengumuman penting untuk disampaikan kepada seluruh siswa.</p>
                        <div class="mt-3 card-link-text">
                            Kelola Pengumuman <i class="bi bi-arrow-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

<style>
    .guru-dashboard-page {
        max-width: 1280px;
    }

    .welcome-hero {
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        padding: 2rem 2.1rem;
        border-radius: 0.8rem;
        border: 1px solid rgba(0, 81, 186, 0.12);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        position: relative;
        overflow: hidden;
    }

    .welcome-hero::after {
        content: '';
        position: absolute;
        top: -10%;
        right: -5%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(0, 81, 186, 0.03) 0%, transparent 70%);
        pointer-events: none;
    }

    .eyebrow-text {
        color: #0051ba;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        font-size: 0.75rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    .dashboard-title {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }

    .dashboard-subtitle {
        font-size: 1rem;
        max-width: 560px;
    }

    .dashboard-section-title {
        font-weight: 700;
        color: #0f172a;
    }

    .hero-img-mini {
        max-height: 170px;
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.08));
    }

    .dashboard-btn {
        padding: 0.7rem 1.2rem;
        border-radius: 0.8rem;
        font-weight: 600;
    }

    .btn-primary {
        background-color: #0051ba;
        border-color: #0051ba;
        box-shadow: 0 4px 12px rgba(0, 81, 186, 0.2);
    }

    .btn-primary:hover {
        background-color: #003d8f;
        border-color: #003d8f;
        transform: translateY(-2px);
    }

    .btn-outline-primary {
        color: #0051ba;
        border-color: #0051ba;
    }

    .btn-outline-primary:hover {
        background-color: #0051ba;
        color: white;
        transform: translateY(-2px);
    }

    .menu-card {
        border-radius: 0.75rem;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        background: #fff;
    }

    .menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 81, 186, 0.1);
        border-color: rgba(0, 81, 186, 0.18);
    }

    .menu-card .card-body {
        padding: 1.5rem;
    }

    .icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        background-color: #f0f5ff;
        color: #0051ba;
        transition: background-color 0.2s, color 0.2s;
    }

    .menu-card:hover .icon-wrapper {
        background-color: #0051ba;
        color: #fff;
    }

    .menu-card .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.4rem;
    }

    .menu-card .card-text {
        font-size: 0.88rem;
        line-height: 1.65;
        color: #6b7280;
    }

    .card-link-text {
        font-size: 0.82rem;
        font-weight: 600;
        color: #0051ba;
    }

    @media (max-width: 991.98px) {
        .welcome-hero {
            padding: 1.5rem;
        }

        .dashboard-title {
            font-size: 1.7rem;
        }
    }
</style>

<?= $this->endSection() ?>
