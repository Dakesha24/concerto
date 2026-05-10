<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="container admin-dashboard-page py-4">

    <!-- Welcome Hero -->
    <div class="welcome-hero mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="eyebrow-text">Dashboard Admin</span>
                <h1 class="dashboard-title mb-2">Selamat Datang, <?= session()->get('username') ?>!</h1>
                <p class="dashboard-subtitle mb-3 text-muted">Kelola seluruh data guru, siswa, sekolah, ujian, dan pengumuman dalam satu tempat.</p>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <img src="<?= base_url('assets/images/icon-adaptct.png') ?>" alt="ADAPT-CT" class="img-fluid hero-img-mini">
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon stat-icon--blue">
                    <i class="bi bi-person-workspace"></i>
                </div>
                <div class="stat-body">
                    <span class="stat-label">Total Guru</span>
                    <span class="stat-value"><?= $stats['total_guru'] ?? 0 ?></span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon stat-icon--green">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-body">
                    <span class="stat-label">Total Siswa</span>
                    <span class="stat-value"><?= $stats['total_siswa'] ?? 0 ?></span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon stat-icon--navy">
                    <i class="bi bi-buildings-fill"></i>
                </div>
                <div class="stat-body">
                    <span class="stat-label">Total Sekolah</span>
                    <span class="stat-value"><?= $stats['total_sekolah'] ?? 0 ?></span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon stat-icon--amber">
                    <i class="bi bi-door-open-fill"></i>
                </div>
                <div class="stat-body">
                    <span class="stat-label">Total Kelas</span>
                    <span class="stat-value"><?= $stats['total_kelas'] ?? 0 ?></span>
                </div>
            </div>
        </div>

    </div>

    <h5 class="dashboard-section-title mb-3">Menu Utama</h5>

    <?php
    $menuItems = [
        ['title' => 'Kelola Guru',       'desc' => 'Tambah, ubah, dan hapus data guru dalam sistem.',        'icon' => 'bi-person-workspace',    'url' => 'admin/guru'],
        ['title' => 'Kelola Siswa',      'desc' => 'Manajemen data peserta tes di seluruh kelas.',           'icon' => 'bi-people-fill',         'url' => 'admin/siswa'],
        ['title' => 'Sekolah & Kelas',   'desc' => 'Kelola institusi, kelas, dan relasi siswa.',             'icon' => 'bi-buildings-fill',      'url' => 'admin/sekolah'],
        ['title' => 'Bank Ujian',        'desc' => 'Kelola bank soal, kategori, dan koleksi ujian.',         'icon' => 'bi-database-fill',       'url' => 'admin/bank-soal'],
        ['title' => 'Mata Pelajaran',    'desc' => 'Atur jenis dan kategori mata pelajaran ujian.',          'icon' => 'bi-journal-richtext',    'url' => 'admin/jenis-ujian'],
        ['title' => 'Kelola Ujian',      'desc' => 'Monitor dan kelola ujian yang dibuat oleh guru.',        'icon' => 'bi-file-earmark-text-fill','url' => 'admin/ujian'],
        ['title' => 'Jadwal Ujian',      'desc' => 'Monitor jadwal, sesi, dan peserta ujian.',               'icon' => 'bi-calendar-check-fill', 'url' => 'admin/jadwal-ujian'],
        ['title' => 'Hasil Ujian',       'desc' => 'Analisis dan unduh laporan hasil ujian siswa.',          'icon' => 'bi-bar-chart-fill',      'url' => 'admin/hasil-ujian'],
        ['title' => 'Pengumuman',        'desc' => 'Publikasi pengumuman untuk seluruh pengguna sistem.',    'icon' => 'bi-megaphone-fill',      'url' => 'admin/pengumuman'],
    ];
    ?>

    <div class="row g-3">
        <?php foreach ($menuItems as $item) : ?>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="<?= base_url($item['url']) ?>" class="text-decoration-none">
                    <div class="card menu-card h-100">
                        <div class="card-body">
                            <div class="icon-wrapper">
                                <i class="bi <?= $item['icon'] ?> fs-2"></i>
                            </div>
                            <h5 class="card-title mb-2"><?= $item['title'] ?></h5>
                            <p class="card-text text-muted"><?= $item['desc'] ?></p>
                            <div class="mt-3 card-link-text">
                                Buka Menu <i class="bi bi-arrow-right ms-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .admin-dashboard-page {
        max-width: 1280px;
    }

    /* ═══════════════ WELCOME HERO ═══════════════ */
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

    .hero-img-mini {
        max-height: 130px;
        filter: drop-shadow(0 8px 16px rgba(0, 81, 186, 0.12));
    }

    .dashboard-section-title {
        font-weight: 700;
        color: #0f172a;
    }

    /* ═══════════════ STAT CARDS ═══════════════ */
    .stat-card {
        background: #fff;
        border-radius: 0.75rem;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        padding: 1.25rem 1.4rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0, 81, 186, 0.1);
        border-color: rgba(0, 81, 186, 0.15);
    }

    .stat-icon {
        flex-shrink: 0;
        width: 52px;
        height: 52px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .stat-icon--blue  { background: #f0f5ff; color: #0051ba; }
    .stat-icon--green { background: #f0fdf4; color: #16a34a; }
    .stat-icon--navy  { background: #f0f2ff; color: #001a4f; }
    .stat-icon--amber { background: #fffdf0; color: #d97706; }

    .stat-body {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .stat-label {
        font-size: .78rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: #111827;
        line-height: 1;
    }

    /* ═══════════════ MENU CARDS ═══════════════ */
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

        .stat-value {
            font-size: 1.5rem;
        }
    }
</style>

<?= $this->endSection() ?>
