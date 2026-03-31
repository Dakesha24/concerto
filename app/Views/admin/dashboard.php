<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="container-fluid admin-dashboard-page px-4 py-4">

  <div class="dashboard-head-card mb-4">
    <p class="dashboard-kicker mb-2">Admin Panel</p>
    <h1 class="h3 fw-bold mb-1">Dashboard Admin</h1>
    <p class="text-muted mb-0">Ringkasan sistem dan akses cepat ke modul utama.</p>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
      <div class="card stat-card h-100 border-0">
        <div class="card-body d-flex align-items-center">
          <div class="flex-grow-1">
            <h4 class="fw-bold mb-1"><?= $stats['total_guru'] ?? 0 ?></h4>
            <p class="text-muted mb-0">Total Guru</p>
          </div>
          <div class="icon-circle bg-primary-subtle text-primary">
            <i class="bi bi-person-workspace fs-4"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="card stat-card h-100 border-0">
        <div class="card-body d-flex align-items-center">
          <div class="flex-grow-1">
            <h4 class="fw-bold mb-1"><?= $stats['total_siswa'] ?? 0 ?></h4>
            <p class="text-muted mb-0">Total Siswa</p>
          </div>
          <div class="icon-circle bg-success-subtle text-success">
            <i class="bi bi-people fs-4"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="card stat-card h-100 border-0">
        <div class="card-body d-flex align-items-center">
          <div class="flex-grow-1">
            <h4 class="fw-bold mb-1"><?= $stats['total_sekolah'] ?? 0 ?></h4>
            <p class="text-muted mb-0">Total Sekolah</p>
          </div>
          <div class="icon-circle bg-info-subtle text-info">
            <i class="bi bi-building fs-4"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="card stat-card h-100 border-0">
        <div class="card-body d-flex align-items-center">
          <div class="flex-grow-1">
            <h4 class="fw-bold mb-1"><?= $stats['total_kelas'] ?? 0 ?></h4>
            <p class="text-muted mb-0">Total Kelas</p>
          </div>
          <div class="icon-circle bg-warning-subtle text-warning">
            <i class="bi bi-door-open fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <h2 class="h5 fw-bold mb-3">Menu Utama</h2>
  <div class="row g-3">
    <?php
    $menuItems = [
      ['title' => 'Kelola Guru', 'desc' => 'Kelola data guru dalam sistem.', 'icon' => 'bi-person-workspace', 'color' => 'primary', 'url' => 'admin/guru'],
      ['title' => 'Kelola Siswa', 'desc' => 'Kelola data siswa dalam sistem.', 'icon' => 'bi-people', 'color' => 'success', 'url' => 'admin/siswa'],
      ['title' => 'Sekolah & Kelas', 'desc' => 'Kelola sekolah, kelas, dan siswa.', 'icon' => 'bi-building-gear', 'color' => 'info', 'url' => 'admin/sekolah'],
      ['title' => 'Bank Ujian', 'desc' => 'Kelola bank soal dan koleksi ujian.', 'icon' => 'bi-database', 'color' => 'purple', 'url' => 'admin/bank-soal'],
      ['title' => 'Mata Pelajaran', 'desc' => 'Monitor ujian yang dibuat oleh guru.', 'icon' => 'bi-journal-text', 'color' => 'info', 'url' => 'admin/jenis-ujian'],
      ['title' => 'Kelola Ujian', 'desc' => 'Monitor ujian yang dibuat oleh guru.', 'icon' => 'bi-file-earmark-text', 'color' => 'danger', 'url' => 'admin/ujian'],
      ['title' => 'Jadwal Ujian', 'desc' => 'Monitor jadwal dan peserta ujian.', 'icon' => 'bi-calendar-check', 'color' => 'secondary', 'url' => 'admin/jadwal-ujian'],
      ['title' => 'Hasil Ujian', 'desc' => 'Analisis hasil ujian para siswa.', 'icon' => 'bi-bar-chart-line', 'color' => 'success', 'url' => 'admin/hasil-ujian'],
      ['title' => 'Pengumuman', 'desc' => 'Kelola pengumuman untuk semua user.', 'icon' => 'bi-megaphone', 'color' => 'dark', 'url' => 'admin/pengumuman'],
    ];
    ?>

    <?php foreach ($menuItems as $item) : ?>
      <div class="col-xl-3 col-lg-4 col-md-6">
        <a href="<?= base_url($item['url']) ?>" class="text-decoration-none menu-link">
          <div class="card menu-card h-100">
            <div class="card-body">
              <div class="icon-wrapper bg-<?= $item['color'] ?>-subtle text-<?= $item['color'] ?>">
                <i class="bi <?= $item['icon'] ?> fs-4"></i>
              </div>
              <h5 class="card-title fw-bold text-body mb-2"><?= $item['title'] ?></h5>
              <p class="card-text small text-muted mb-3"><?= $item['desc'] ?></p>
              <span class="menu-arrow text-primary fw-semibold small">
                Buka Menu <i class="bi bi-arrow-right ms-1"></i>
              </span>
            </div>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<style>
  body {
    background-color: #f8f9fa;
  }

  .dashboard-head-card {
    background: linear-gradient(180deg, #f8fbff 0%, #eef5ff 100%);
    border: 1px solid rgba(13, 110, 253, 0.12);
    border-radius: 0.8rem;
    padding: 1.5rem 1.75rem;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
  }

  .dashboard-kicker {
    color: #0d6efd;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 0.75rem;
    font-weight: 700;
  }

  .stat-card,
  .menu-card {
    border: 1px solid rgba(15, 23, 42, 0.08);
    border-radius: 0.75rem;
    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    background: #fff;
  }

  .stat-card:hover,
  .menu-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(15, 23, 42, 0.07);
    border-color: rgba(13, 110, 253, 0.2);
  }

  .stat-card .card-body {
    padding: 1.2rem 1.25rem;
  }

  .icon-circle {
    width: 54px;
    height: 54px;
    border-radius: 0.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .menu-card .card-body {
    padding: 1.35rem;
  }

  .menu-card .icon-wrapper {
    width: 56px;
    height: 56px;
    border-radius: 0.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
  }

  .menu-link {
    color: inherit;
  }

  .bg-purple-subtle {
    background-color: rgba(102, 16, 242, 0.1);
  }

  .text-purple {
    color: #6f42c1;
  }
</style>

<?= $this->endSection() ?>
