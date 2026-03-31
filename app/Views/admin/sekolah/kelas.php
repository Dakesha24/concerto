<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="pg-breadcrumb">
        <a href="<?= base_url('admin/sekolah') ?>"><i class="bi bi-buildings me-1"></i>Kelola Sekolah</a>
        <span class="pg-bc-sep"><i class="bi bi-chevron-right"></i></span>
        <span><?= esc($sekolah['nama_sekolah']) ?></span>
    </nav>

    <!-- Page Header -->
    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Kelola Kelas</p>
            <h1 class="pg-title"><?= esc($sekolah['nama_sekolah']) ?></h1>
            <?php if ($sekolah['alamat']): ?>
                <p class="pg-sub"><i class="bi bi-geo-alt me-1"></i><?= esc($sekolah['alamat']) ?></p>
            <?php endif; ?>
        </div>
        <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas/tambah') ?>" class="btn-pg-action">
            <i class="bi bi-plus-lg"></i> Tambah Kelas
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-pg alert-pg--success">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-pg alert-pg--danger">
            <i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Stat Cards -->
    <?php
        $totalSiswa    = array_sum(array_column($kelas, 'total_siswa'));
        $tahunAktif    = count(array_unique(array_column($kelas, 'tahun_ajaran')));
    ?>
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="s-card">
                <div class="s-icon"><i class="bi bi-door-open-fill"></i></div>
                <div class="s-body">
                    <span class="s-label">Total Kelas</span>
                    <span class="s-value"><?= count($kelas) ?></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="s-card">
                <div class="s-icon"><i class="bi bi-people-fill"></i></div>
                <div class="s-body">
                    <span class="s-label">Total Siswa</span>
                    <span class="s-value"><?= $totalSiswa ?></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="s-card">
                <div class="s-icon"><i class="bi bi-person-workspace"></i></div>
                <div class="s-body">
                    <span class="s-label">Total Guru</span>
                    <span class="s-value"><?= $sekolah['total_guru'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="s-card">
                <div class="s-icon"><i class="bi bi-calendar3"></i></div>
                <div class="s-body">
                    <span class="s-label">Tahun Ajaran Aktif</span>
                    <span class="s-value"><?= $tahunAktif ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="tbl-card">
        <div class="table-responsive">
            <table class="tbl">
                <thead>
                    <tr>
                        <th style="width:48px">No</th>
                        <th>Nama Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th style="width:110px">Siswa</th>
                        <th style="width:110px">Guru</th>
                        <th style="width:110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kelas)): ?>
                        <tr>
                            <td colspan="6">
                                <div class="tbl-empty">
                                    <i class="bi bi-building"></i>
                                    <p>Belum ada kelas di sekolah ini</p>
                                    <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas/tambah') ?>"
                                       class="btn-pg-action btn-pg-action--sm">
                                        <i class="bi bi-plus-lg"></i> Tambah Kelas Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($kelas as $index => $k): ?>
                            <tr>
                                <td class="tbl-num"><?= $index + 1 ?></td>
                                <td class="tbl-name"><?= esc($k['nama_kelas']) ?></td>
                                <td><span class="pg-badge pg-badge--gray"><?= esc($k['tahun_ajaran']) ?></span></td>
                                <td><span class="pg-badge"><?= $k['total_siswa'] ?> Siswa</span></td>
                                <td><span class="pg-badge"><?= $k['total_guru'] ?? 0 ?> Guru</span></td>
                                <td>
                                    <div class="act-group">
                                        <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas/' . $k['kelas_id'] . '/detail') ?>"
                                           class="act-btn" title="Kelola Anggota Kelas">
                                            <i class="bi bi-people"></i>
                                        </a>
                                        <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas/edit/' . $k['kelas_id']) ?>"
                                           class="act-btn" title="Edit Kelas">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($k['total_siswa'] == 0 && ($k['total_guru'] ?? 0) == 0): ?>
                                            <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas/hapus/' . $k['kelas_id']) ?>"
                                               class="act-btn act-btn--danger" title="Hapus Kelas"
                                               onclick="return confirm('Yakin ingin menghapus kelas <?= esc($k['nama_kelas']) ?>?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <button class="act-btn act-btn--disabled" disabled
                                                    title="Tidak dapat dihapus karena masih memiliki anggota">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
/* ── Layout ── */
.pg-wrap {
    padding: 2rem 2rem 3rem;
    max-width: 1280px;
}

/* ── Breadcrumb ── */
.pg-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .8rem;
    color: #6b7280;
    margin-bottom: 1rem;
}

.pg-breadcrumb a {
    color: #0051ba;
    text-decoration: none;
    font-weight: 500;
}

.pg-breadcrumb a:hover { text-decoration: underline; }

.pg-bc-sep {
    font-size: .65rem;
    color: #cbd5e1;
}

/* ── Page Header ── */
.pg-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}

.pg-eyebrow {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #0051ba;
    margin-bottom: 4px;
}

.pg-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -.2px;
    margin-bottom: 4px;
}

.pg-sub {
    font-size: .84rem;
    color: #6b7280;
    margin: 0;
}

.btn-pg-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #0051ba;
    color: #fff;
    font-size: .85rem;
    font-weight: 600;
    padding: 9px 18px;
    border-radius: 8px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    white-space: nowrap;
    transition: background .2s, transform .15s;
}

.btn-pg-action:hover {
    background: #003d8f;
    color: #fff;
    transform: translateY(-1px);
}

.btn-pg-action--sm {
    font-size: .8rem;
    padding: 7px 14px;
}

/* ── Alerts ── */
.alert-pg {
    display: flex;
    align-items: center;
    font-size: .875rem;
    padding: .75rem 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    position: relative;
}

.alert-pg--success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
}

.alert-pg--danger {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

.alert-pg-close {
    position: absolute;
    right: .75rem;
    background: none;
    border: none;
    font-size: 1.1rem;
    cursor: pointer;
    color: inherit;
    opacity: .5;
    line-height: 1;
    padding: 0;
}

.alert-pg-close:hover { opacity: 1; }

/* ── Stat Cards ── */
.s-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,.07);
    box-shadow: 0 4px 16px rgba(15,23,42,.04);
    padding: 1.1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: .9rem;
    transition: transform .2s, box-shadow .2s;
}

.s-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,81,186,.09);
}

.s-icon {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    border-radius: 9px;
    background: rgba(0,81,186,.08);
    color: #0051ba;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.s-body {
    display: flex;
    flex-direction: column;
    gap: 1px;
}

.s-label {
    font-size: .72rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .4px;
}

.s-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}

/* ── Table Card ── */
.tbl-card {
    background: #fff;
    border: 1px solid rgba(15,23,42,.08);
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(15,23,42,.04);
    overflow: hidden;
}

.tbl {
    width: 100%;
    border-collapse: collapse;
    font-size: .875rem;
}

.tbl thead tr {
    background: #f8fafc;
    border-bottom: 1px solid #e9eef5;
}

.tbl thead th {
    padding: .75rem 1rem;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #6b7280;
    white-space: nowrap;
}

.tbl tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
}

.tbl tbody tr:last-child { border-bottom: none; }
.tbl tbody tr:hover      { background: #f8fbff; }

.tbl tbody td {
    padding: .85rem 1rem;
    vertical-align: middle;
    color: #374151;
}

.tbl-num   { color: #9ca3af; font-size: .8rem; }
.tbl-name  { font-weight: 600; color: #0f172a; }

/* ── Badge ── */
.pg-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: .75rem;
    font-weight: 600;
    background: rgba(0,81,186,.07);
    color: #0051ba;
}

.pg-badge--gray {
    background: rgba(107,114,128,.08);
    color: #4b5563;
}

/* ── Action Buttons ── */
.act-group {
    display: flex;
    gap: 4px;
}

.act-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 6px;
    font-size: .85rem;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #475569;
    text-decoration: none;
    cursor: pointer;
    transition: all .15s;
}

.act-btn:hover {
    background: #f0f5ff;
    border-color: #c7d7f5;
    color: #0051ba;
}

.act-btn--danger { color: #b91c1c; border-color: #fecaca; }
.act-btn--danger:hover {
    background: #fef2f2;
    border-color: #fca5a5;
    color: #b91c1c;
}

.act-btn--disabled { opacity: .4; cursor: not-allowed; }

/* ── Empty State ── */
.tbl-empty {
    text-align: center;
    padding: 3rem 1rem;
}

.tbl-empty i {
    font-size: 2.5rem;
    display: block;
    margin-bottom: .75rem;
    color: #cbd5e1;
}

.tbl-empty p {
    color: #9ca3af;
    margin-bottom: 1rem;
    font-size: .9rem;
}

@media (max-width: 768px) {
    .pg-wrap   { padding: 1.25rem 1rem 2rem; }
    .pg-title  { font-size: 1.25rem; }
    .pg-header { flex-direction: column; align-items: flex-start; }
}
</style>

<?= $this->endSection() ?>
