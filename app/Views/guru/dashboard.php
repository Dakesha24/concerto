<?= $this->extend('templates/guru/guru_template') ?>

<?= $this->section('content') ?>
<div class="container guru-dashboard-page py-4">
    <div class="guru-head-card mb-4">
        <p class="guru-kicker mb-2">Dashboard Guru</p>
        <h2 class="mb-1">Menu Pengelolaan</h2>
        <p class="text-muted mb-0">Akses cepat untuk mengelola mata pelajaran, bank soal, ujian, dan pengumuman.</p>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card menu-card h-100">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-primary-subtle mx-auto">
                        <i class="bi bi-journal-text text-primary fs-3"></i>
                    </div>
                    <h5 class="card-title">Mata Pelajaran</h5>
                    <p class="card-text">Kelola kategori dan Mata Pelajaran</p>
                    <a href="<?= base_url('guru/jenis-ujian') ?>" class="btn btn-primary dashboard-btn">
                        <i class="bi bi-plus-circle me-2"></i>Kelola Mata Pelajaran
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card menu-card h-100">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-purple-subtle mx-auto">
                        <i class="bi bi-bank text-purple fs-3"></i>
                    </div>
                    <h5 class="card-title">Bank Soal</h5>
                    <p class="card-text">Kelola koleksi soal yang dapat digunakan untuk berbagai ujian</p>
                    <a href="<?= base_url('guru/bank-soal') ?>" class="btn btn-outline-purple dashboard-btn">
                        <i class="bi bi-collection me-2"></i>Kelola Bank Soal
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card menu-card h-100">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-success-subtle mx-auto">
                        <i class="bi bi-file-earmark-text text-success fs-3"></i>
                    </div>
                    <h5 class="card-title">Ujian</h5>
                    <p class="card-text">Buat dan kelola ujian beserta soal-soalnya</p>
                    <a href="<?= base_url('guru/ujian') ?>" class="btn btn-success dashboard-btn">
                        <i class="bi bi-plus-circle me-2"></i>Kelola Ujian
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card menu-card h-100">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-info-subtle mx-auto">
                        <i class="bi bi-calendar-event text-info fs-3"></i>
                    </div>
                    <h5 class="card-title">Jadwal Ujian</h5>
                    <p class="card-text">Atur jadwal pelaksanaan ujian</p>
                    <a href="<?= base_url('guru/jadwal-ujian') ?>" class="btn btn-info dashboard-btn">
                        <i class="bi bi-plus-circle me-2"></i>Kelola Jadwal
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card menu-card h-100">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-danger-subtle mx-auto">
                        <i class="bi bi-clipboard-data text-danger fs-3"></i>
                    </div>
                    <h5 class="card-title">Hasil Ujian</h5>
                    <p class="card-text">Lihat dan analisis hasil ujian siswa</p>
                    <a href="<?= base_url('guru/hasil-ujian') ?>" class="btn btn-danger dashboard-btn">
                        <i class="bi bi-bar-chart me-2"></i>Lihat Hasil
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card menu-card h-100">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-warning-subtle mx-auto">
                        <i class="bi bi-megaphone text-warning fs-3"></i>
                    </div>
                    <h5 class="card-title">Pengumuman</h5>
                    <p class="card-text">Buat dan kelola pengumuman</p>
                    <a href="<?= base_url('guru/pengumuman') ?>" class="btn btn-warning dashboard-btn">
                        <i class="bi bi-plus-circle me-2"></i>Kelola Pengumuman
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .guru-head-card {
        background: linear-gradient(180deg, #f8fbff 0%, #eef5ff 100%);
        border: 1px solid rgba(13, 110, 253, 0.12);
        border-radius: 0.8rem;
        padding: 1.5rem 1.75rem;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
    }

    .guru-kicker {
        color: #0d6efd;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .bg-purple-subtle {
        background-color: rgba(138, 43, 226, 0.1) !important;
    }

    .text-purple {
        color: #8a2be2 !important;
    }

    .btn-outline-purple {
        color: #8a2be2;
        border-color: #8a2be2;
    }

    .btn-outline-purple:hover {
        color: #fff;
        background-color: #8a2be2;
        border-color: #8a2be2;
    }

    .dashboard-btn {
        border-radius: 0.7rem;
        padding: 0.7rem 1rem;
        font-weight: 600;
    }

    .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .menu-card {
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 0.75rem;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .menu-card .card-body {
        padding: 1.5rem;
    }

    .menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 22px rgba(15, 23, 42, 0.07);
    }

    .menu-card .card-title {
        margin-bottom: 0.55rem;
        font-weight: 700;
    }

    .menu-card .card-text {
        color: #6b7280;
        min-height: 48px;
        margin-bottom: 1rem;
    }
</style>

<?= $this->endSection() ?>
