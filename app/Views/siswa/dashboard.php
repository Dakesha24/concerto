<?= $this->extend('templates/siswa/siswa_template') ?>

<?= $this->section('content') ?>
<div class="container-fluid dashboard-siswa">
    <!-- Hero Welcome Section -->
    <div class="welcome-hero mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="eyebrow-text">Dashboard Siswa</span>
                <h1 class="dashboard-title mb-2">Selamat Datang, <?= session()->get('username') ?>!</h1>
                <p class="dashboard-subtitle mb-3 text-muted">Akses fitur pembelajaran dan evaluasi dalam satu tempat.</p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('siswa/ujian') ?>" class="btn btn-primary dashboard-btn">
                        <i class="bi bi-play-circle me-2"></i>Mulai Ujian
                    </a>
                    <a href="<?= base_url('siswa/pengumuman') ?>" class="btn btn-outline-primary dashboard-btn">
                        <i class="bi bi-info-circle me-2"></i>Informasi
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
        <!-- Pengumuman Card -->
        <div class="col-md-4">
            <a href="<?= base_url('siswa/pengumuman') ?>" class="text-decoration-none">
                <div class="card menu-card dashboard-menu-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper" style="background-color: #f0f7ff; color: #0051ba;">
                            <i class="bi bi-megaphone fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2">Pengumuman</h5>
                        <p class="card-text text-muted">Lihat pengumuman terbaru dan informasi penting dari sekolah atau guru.</p>
                        <div class="mt-3 text-primary fw-semibold small">
                            Buka Pengumuman <i class="bi bi-arrow-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Ujian Card -->
        <div class="col-md-4">
            <a href="<?= base_url('siswa/ujian') ?>" class="text-decoration-none">
                <div class="card menu-card dashboard-menu-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper" style="background-color: #f0fdf4; color: #16a34a;">
                            <i class="bi bi-journal-text fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2">Ujian CAT</h5>
                        <p class="card-text text-muted">Akses daftar ujian yang sedang berlangsung dan mulai kerjakan soal adaptif.</p>
                        <div class="mt-3 text-success fw-semibold small">
                            Mulai Sekarang <i class="bi bi-arrow-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Hasil Ujian Card -->
        <div class="col-md-4">
            <a href="<?= base_url('siswa/hasil') ?>" class="text-decoration-none">
                <div class="card menu-card dashboard-menu-card h-100">
                    <div class="card-body">
                        <div class="icon-wrapper" style="background-color: #fffaf0; color: #d97706;">
                            <i class="bi bi-clipboard-data fs-2"></i>
                        </div>
                        <h5 class="card-title mb-2">Hasil & Analisis</h5>
                        <p class="card-text text-muted">Pantau progress kemampuan Anda melalui laporan hasil ujian yang mendalam.</p>
                        <div class="mt-3 text-warning fw-semibold small">
                            Lihat Hasil <i class="bi bi-arrow-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .dashboard-siswa {
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
        background: radial-gradient(circle, rgba(0,81,186,0.03) 0%, transparent 70%);
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
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.08));
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

    .dashboard-menu-card {
        border-radius: 0.75rem;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
    }

    .dashboard-menu-card .card-body {
        padding: 1.5rem;
    }

    .dashboard-menu-card .icon-wrapper {
        width: 58px;
        height: 58px;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
    }

    .dashboard-menu-card .card-title {
        font-size: 1rem;
        margin-bottom: 0.55rem;
    }

    .dashboard-menu-card .card-text {
        font-size: 0.92rem;
        line-height: 1.65;
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
