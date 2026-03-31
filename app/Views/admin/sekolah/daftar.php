<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <!-- Page Header -->
    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Kelola Institusi</p>
            <h1 class="pg-title">Kelola Sekolah</h1>
            <p class="pg-sub">Daftar seluruh sekolah yang terdaftar dalam sistem CONCERTO.</p>
        </div>
        <a href="<?= base_url('admin/sekolah/tambah') ?>" class="btn-pg-action">
            <i class="bi bi-plus-lg"></i> Tambah Sekolah
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

    <!-- Table Card -->
    <div class="tbl-card">
        <div class="table-responsive">
            <table class="tbl">
                <thead>
                    <tr>
                        <th style="width:48px">No</th>
                        <th>Nama Sekolah</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th style="width:100px">Guru</th>
                        <th style="width:100px">Kelas</th>
                        <th style="width:110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($sekolah)): ?>
                        <tr>
                            <td colspan="8">
                                <div class="tbl-empty">
                                    <i class="bi bi-buildings"></i>
                                    <p>Belum ada data sekolah</p>
                                    <a href="<?= base_url('admin/sekolah/tambah') ?>" class="btn-pg-action btn-pg-action--sm">
                                        <i class="bi bi-plus-lg"></i> Tambah Sekolah
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($sekolah as $index => $s): ?>
                            <tr>
                                <td class="tbl-num"><?= $index + 1 ?></td>
                                <td class="tbl-name"><?= esc($s['nama_sekolah']) ?></td>
                                <td class="tbl-muted"><?= esc($s['alamat'] ?: '—') ?></td>
                                <td class="tbl-muted"><?= esc($s['telepon'] ?: '—') ?></td>
                                <td class="tbl-muted"><?= esc($s['email'] ?: '—') ?></td>
                                <td>
                                    <span class="pg-badge"><?= $s['total_guru'] ?> Guru</span>
                                </td>
                                <td>
                                    <span class="pg-badge"><?= $s['total_kelas'] ?? 0 ?> Kelas</span>
                                </td>
                                <td>
                                    <div class="act-group">
                                        <a href="<?= base_url('admin/sekolah/' . $s['sekolah_id'] . '/kelas') ?>"
                                           class="act-btn" title="Kelola Kelas">
                                            <i class="bi bi-building"></i>
                                        </a>
                                        <a href="<?= base_url('admin/sekolah/edit/' . $s['sekolah_id']) ?>"
                                           class="act-btn" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($s['total_guru'] == 0 && ($s['total_kelas'] ?? 0) == 0): ?>
                                            <a href="<?= base_url('admin/sekolah/hapus/' . $s['sekolah_id']) ?>"
                                               class="act-btn act-btn--danger" title="Hapus"
                                               onclick="return confirm('Yakin ingin menghapus sekolah ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <button class="act-btn act-btn--disabled" disabled
                                                    title="Tidak dapat dihapus karena masih memiliki guru atau kelas">
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

    <!-- Legend -->
    <div class="legend-card">
        <span class="legend-item">
            <span class="act-btn act-btn--static"><i class="bi bi-building"></i></span>
            Kelola Kelas & Anggota
        </span>
        <span class="legend-item">
            <span class="act-btn act-btn--static"><i class="bi bi-pencil"></i></span>
            Edit Data Sekolah
        </span>
        <span class="legend-item">
            <span class="act-btn act-btn--danger act-btn--static"><i class="bi bi-trash"></i></span>
            Hapus Sekolah
        </span>
    </div>

</div>

<style>
/* ── Layout ── */
.pg-wrap {
    padding: 2rem 2rem 3rem;
    max-width: 1280px;
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

/* ── Table Card ── */
.tbl-card {
    background: #fff;
    border: 1px solid rgba(15,23,42,.08);
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(15,23,42,.04);
    overflow: hidden;
    margin-bottom: 1rem;
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

.tbl tbody tr:hover { background: #f8fbff; }

.tbl tbody td {
    padding: .85rem 1rem;
    vertical-align: middle;
    color: #374151;
}

.tbl-num   { color: #9ca3af; font-size: .8rem; }
.tbl-name  { font-weight: 600; color: #0f172a; }
.tbl-muted { color: #6b7280; font-size: .85rem; }

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

.act-btn--danger {
    color: #b91c1c;
    border-color: #fecaca;
}

.act-btn--danger:hover {
    background: #fef2f2;
    border-color: #fca5a5;
    color: #b91c1c;
}

.act-btn--disabled {
    opacity: .4;
    cursor: not-allowed;
}

.act-btn--static {
    pointer-events: none;
}

/* ── Empty State ── */
.tbl-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: #9ca3af;
}

.tbl-empty i {
    font-size: 2.5rem;
    display: block;
    margin-bottom: .75rem;
    color: #cbd5e1;
}

.tbl-empty p {
    margin-bottom: 1rem;
    font-size: .9rem;
}

/* ── Legend ── */
.legend-card {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    background: #f8fafc;
    border: 1px solid #e9eef5;
    border-radius: 8px;
    padding: .75rem 1rem;
    font-size: .8rem;
    color: #6b7280;
}

.legend-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

@media (max-width: 768px) {
    .pg-wrap    { padding: 1.25rem 1rem 2rem; }
    .pg-title   { font-size: 1.25rem; }
    .pg-header  { flex-direction: column; align-items: flex-start; }
}
</style>

<?= $this->endSection() ?>
