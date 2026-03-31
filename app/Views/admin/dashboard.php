<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>

<!-- PAGE HEADER -->
<div class="dash-header">
    <div class="dash-header-inner">
        <p class="dash-eyebrow">Admin Panel &mdash; CONCERTO</p>
        <h1 class="dash-title">Dashboard <span>Admin</span></h1>
        <p class="dash-sub">Ringkasan sistem dan akses cepat ke seluruh modul manajemen.</p>
    </div>
</div>

<!-- STAT CARDS -->
<div class="dash-section">
    <div class="row g-3 mb-4">

        <div class="col-lg-3 col-md-6">
            <div class="s-card">
                <div class="s-icon s-icon--blue">
                    <i class="bi bi-person-workspace"></i>
                </div>
                <div class="s-body">
                    <span class="s-label">Total Guru</span>
                    <span class="s-value"><?= $stats['total_guru'] ?? 0 ?></span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="s-card">
                <div class="s-icon s-icon--teal">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="s-body">
                    <span class="s-label">Total Siswa</span>
                    <span class="s-value"><?= $stats['total_siswa'] ?? 0 ?></span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="s-card">
                <div class="s-icon s-icon--navy">
                    <i class="bi bi-buildings-fill"></i>
                </div>
                <div class="s-body">
                    <span class="s-label">Total Sekolah</span>
                    <span class="s-value"><?= $stats['total_sekolah'] ?? 0 ?></span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="s-card">
                <div class="s-icon s-icon--yellow">
                    <i class="bi bi-door-open-fill"></i>
                </div>
                <div class="s-body">
                    <span class="s-label">Total Kelas</span>
                    <span class="s-value"><?= $stats['total_kelas'] ?? 0 ?></span>
                </div>
            </div>
        </div>

    </div>

    <!-- MENU GRID -->
    <div class="menu-section-head">
        <p class="ms-label">Navigasi Cepat</p>
        <h2 class="ms-title">Menu Utama</h2>
    </div>

    <?php
    $menuItems = [
        ['title' => 'Kelola Guru',       'desc' => 'Tambah, ubah, dan hapus data guru dalam sistem.',        'icon' => 'bi-person-workspace',    'variant' => 'blue',   'url' => 'admin/guru'],
        ['title' => 'Kelola Siswa',      'desc' => 'Manajemen data peserta tes di seluruh kelas.',           'icon' => 'bi-people-fill',         'variant' => 'teal',   'url' => 'admin/siswa'],
        ['title' => 'Sekolah & Kelas',   'desc' => 'Kelola institusi, kelas, dan relasi siswa.',             'icon' => 'bi-buildings-fill',      'variant' => 'navy',   'url' => 'admin/sekolah'],
        ['title' => 'Bank Ujian',        'desc' => 'Kelola bank soal, kategori, dan koleksi ujian.',         'icon' => 'bi-database-fill',       'variant' => 'purple', 'url' => 'admin/bank-soal'],
        ['title' => 'Mata Pelajaran',    'desc' => 'Atur jenis dan kategori mata pelajaran ujian.',          'icon' => 'bi-journal-richtext',    'variant' => 'indigo', 'url' => 'admin/jenis-ujian'],
        ['title' => 'Kelola Ujian',      'desc' => 'Monitor dan kelola ujian yang dibuat oleh guru.',        'icon' => 'bi-file-earmark-text-fill','variant' => 'red',  'url' => 'admin/ujian'],
        ['title' => 'Jadwal Ujian',      'desc' => 'Monitor jadwal, sesi, dan peserta ujian.',               'icon' => 'bi-calendar-check-fill', 'variant' => 'slate',  'url' => 'admin/jadwal-ujian'],
        ['title' => 'Hasil Ujian',       'desc' => 'Analisis dan unduh laporan hasil ujian siswa.',          'icon' => 'bi-bar-chart-fill',      'variant' => 'green',  'url' => 'admin/hasil-ujian'],
        ['title' => 'Pengumuman',        'desc' => 'Publikasi pengumuman untuk seluruh pengguna sistem.',    'icon' => 'bi-megaphone-fill',      'variant' => 'yellow', 'url' => 'admin/pengumuman'],
    ];
    ?>

    <div class="row g-3">
        <?php foreach ($menuItems as $item) : ?>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="<?= base_url($item['url']) ?>" class="m-card-link">
                    <div class="m-card">
                        <div class="m-icon m-icon--<?= $item['variant'] ?>">
                            <i class="bi <?= $item['icon'] ?>"></i>
                        </div>
                        <h5 class="m-title"><?= $item['title'] ?></h5>
                        <p class="m-desc"><?= $item['desc'] ?></p>
                        <span class="m-cta">Buka Menu <i class="bi bi-arrow-right ms-1"></i></span>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
/* ═══════════════════════════════════════
   VARIABLES
═══════════════════════════════════════ */
:root {
    --blue:   #0051ba;
    --navy:   #001a4f;
    --yellow: #ffda1a;
    --bg:     #f4f6fb;
}

/* ═══════════════════════════════════════
   PAGE HEADER — matches home.php hero
═══════════════════════════════════════ */
.dash-header {
    background: linear-gradient(135deg, #001a4f 0%, #0051ba 100%);
    position: relative;
    overflow: hidden;
    padding: 44px 2rem 40px;
    margin-bottom: 0;
}

/* grid lines */
.dash-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
    background-size: 50px 50px;
    pointer-events: none;
}

/* glow */
.dash-header::after {
    content: '';
    position: absolute;
    right: -80px;
    top: 50%;
    transform: translateY(-50%);
    width: 340px;
    height: 340px;
    background: radial-gradient(circle, rgba(255,218,26,.08) 0%, transparent 70%);
    pointer-events: none;
}

.dash-header-inner {
    position: relative;
    z-index: 1;
    max-width: 680px;
}

.dash-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: rgba(255,255,255,.45);
    margin-bottom: 10px;
}

.dash-eyebrow::before {
    content: '';
    display: inline-block;
    width: 18px;
    height: 1px;
    background: rgba(255,255,255,.35);
}

.dash-title {
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -.3px;
    line-height: 1.2;
    margin-bottom: 8px;
}

.dash-title span {
    color: #ffda1a;
    letter-spacing: 2px;
    position: relative;
}

.dash-title span::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -3px;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #ffda1a, transparent);
}

.dash-sub {
    font-size: .88rem;
    color: rgba(255,255,255,.55);
    margin: 0;
}

/* ═══════════════════════════════════════
   CONTENT WRAPPER
═══════════════════════════════════════ */
.dash-section {
    padding: 2rem 2rem 3rem;
    background: var(--bg);
    min-height: calc(100vh - 220px);
}

/* ═══════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════ */
.s-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,.07);
    box-shadow: 0 4px 16px rgba(15,23,42,.05);
    padding: 1.25rem 1.4rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform .2s, box-shadow .2s;
}

.s-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(0,81,186,.1);
}

.s-icon {
    flex-shrink: 0;
    width: 52px;
    height: 52px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}

.s-icon--blue   { background: rgba(0,81,186,.1);  color: #0051ba; }
.s-icon--teal   { background: rgba(0,150,136,.1); color: #00897b; }
.s-icon--navy   { background: rgba(0,26,79,.1);   color: #001a4f; }
.s-icon--yellow { background: rgba(255,218,26,.18); color: #b8940a; }

.s-body {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.s-label {
    font-size: .78rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.s-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: #111827;
    line-height: 1;
}

/* ═══════════════════════════════════════
   MENU SECTION HEAD
═══════════════════════════════════════ */
.menu-section-head {
    margin-bottom: 1.25rem;
}

.ms-label {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #0051ba;
    margin-bottom: 4px;
}

.ms-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #111827;
    letter-spacing: -.2px;
    margin: 0;
}

/* ═══════════════════════════════════════
   MENU CARDS
═══════════════════════════════════════ */
.m-card-link {
    text-decoration: none;
    display: block;
    height: 100%;
}

.m-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,.07);
    box-shadow: 0 4px 16px rgba(15,23,42,.05);
    padding: 1.4rem 1.35rem;
    height: 100%;
    transition: transform .2s, box-shadow .2s, border-color .2s;
}

.m-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 32px rgba(0,81,186,.12);
    border-color: rgba(0,81,186,.2);
}

.m-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-bottom: 1rem;
    transition: transform .2s;
}

.m-card:hover .m-icon { transform: scale(1.08); }

/* Icon variants — aligned with CONCERTO palette */
.m-icon--blue   { background: rgba(0,81,186,.1);   color: #0051ba; }
.m-icon--teal   { background: rgba(0,150,136,.1);  color: #00897b; }
.m-icon--navy   { background: rgba(0,26,79,.1);    color: #001a4f; }
.m-icon--purple { background: rgba(111,66,193,.1); color: #6f42c1; }
.m-icon--indigo { background: rgba(63,81,181,.1);  color: #3f51b5; }
.m-icon--red    { background: rgba(220,53,69,.1);  color: #dc3545; }
.m-icon--slate  { background: rgba(71,85,105,.1);  color: #475569; }
.m-icon--green  { background: rgba(25,135,84,.1);  color: #198754; }
.m-icon--yellow { background: rgba(255,218,26,.15); color: #9a7200; }

.m-title {
    font-size: .95rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 6px;
}

.m-desc {
    font-size: .82rem;
    color: #6b7280;
    line-height: 1.65;
    margin-bottom: 1rem;
}

.m-cta {
    font-size: .8rem;
    font-weight: 600;
    color: #0051ba;
    display: inline-flex;
    align-items: center;
    gap: 2px;
    transition: gap .2s;
}

.m-card:hover .m-cta { gap: 6px; }

/* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
@media (max-width: 768px) {
    .dash-header  { padding: 32px 1.25rem 28px; }
    .dash-title   { font-size: 1.6rem; }
    .dash-section { padding: 1.25rem 1.25rem 2.5rem; }
    .s-value      { font-size: 1.5rem; }
}
</style>

<?= $this->endSection() ?>
