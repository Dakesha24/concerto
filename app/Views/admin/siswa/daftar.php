<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Kelola Pengguna</p>
            <h1 class="pg-title">Kelola Siswa</h1>
            <p class="pg-sub">Daftar seluruh siswa yang terdaftar dalam sistem CONCERTO.</p>
        </div>
        <a href="<?= base_url('admin/siswa/tambah') ?>" class="btn-pg-action">
            <i class="bi bi-plus-lg"></i> Tambah Siswa
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-pg alert-pg--success">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
            <button class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-pg alert-pg--danger">
            <i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error') ?>
            <button class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Filter Bar -->
    <div class="filter-card">
        <div class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="filter-label">Status</label>
                <select class="f-input" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="filter-label">Jenis Kelamin</label>
                <select class="f-input" id="filterJenisKelamin">
                    <option value="">Semua</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="filter-label">Sekolah</label>
                <select class="f-input" id="filterSekolah">
                    <option value="">Semua Sekolah</option>
                    <?php foreach (array_unique(array_column($siswa, 'nama_sekolah')) as $s): if ($s): ?>
                        <option value="<?= $s ?>"><?= $s ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="filter-label">Kelas</label>
                <select class="f-input" id="filterKelas">
                    <option value="">Semua Kelas</option>
                    <?php foreach (array_unique(array_column($siswa, 'nama_kelas')) as $k): if ($k): ?>
                        <option value="<?= $k ?>"><?= $k ?></option>
                    <?php endif; endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="filter-label">Cari</label>
                <input type="text" class="f-input" id="searchSiswa" placeholder="Nama, NIS, email…">
            </div>
            <div class="col-md-1">
                <button class="btn-reset w-100" onclick="resetFilter()"><i class="bi bi-arrow-counterclockwise"></i></button>
            </div>
        </div>
    </div>

    <div class="tbl-card">
        <div class="table-responsive">
            <table class="tbl" id="tableSiswa">
                <thead>
                    <tr>
                        <th style="width:48px">No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>No. Peserta</th>
                        <th>L/P</th>
                        <th>Sekolah</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th style="width:80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($siswa)): ?>
                        <tr><td colspan="11">
                            <div class="tbl-empty">
                                <i class="bi bi-people"></i>
                                <p>Belum ada data siswa</p>
                                <a href="<?= base_url('admin/siswa/tambah') ?>" class="btn-pg-action btn-pg-action--sm">
                                    <i class="bi bi-plus-lg"></i> Tambah Siswa
                                </a>
                            </div>
                        </td></tr>
                    <?php else: ?>
                        <?php foreach ($siswa as $i => $s): ?>
                            <tr data-status="<?= $s['status'] ?>"
                                data-jenis-kelamin="<?= $s['jenis_kelamin'] ?? '' ?>"
                                data-sekolah="<?= $s['nama_sekolah'] ?>"
                                data-kelas="<?= $s['nama_kelas'] ?>">
                                <td class="tbl-num"><?= $i + 1 ?></td>
                                <td class="tbl-name"><?= esc($s['nama_lengkap'] ?? '—') ?></td>
                                <td class="tbl-muted"><?= esc($s['username']) ?></td>
                                <td class="tbl-muted"><?= esc($s['email']) ?></td>
                                <td class="tbl-muted"><?= esc($s['nomor_peserta'] ?? '—') ?></td>
                                <td>
                                    <?php if (!empty($s['jenis_kelamin'])): ?>
                                        <span class="pg-badge pg-badge--gray"><?= $s['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P' ?></span>
                                    <?php else: ?>
                                        <span class="tbl-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="tbl-muted" style="font-size:.82rem"><?= esc($s['nama_sekolah'] ?? '—') ?></td>
                                <td><span class="pg-badge"><?= esc($s['nama_kelas'] ?? '—') ?></span></td>
                                <td>
                                    <?php if ($s['status'] == 'active'): ?>
                                        <span class="pg-badge pg-badge--green">Aktif</span>
                                    <?php else: ?>
                                        <span class="pg-badge pg-badge--red">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="tbl-muted"><?= date('d/m/Y', strtotime($s['created_at'])) ?></td>
                                <td>
                                    <div class="act-group">
                                        <a href="<?= base_url('admin/siswa/edit/' . $s['user_id']) ?>" class="act-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <?php if ($s['status'] == 'active'): ?>
                                            <a href="<?= base_url('admin/siswa/hapus/' . $s['user_id']) ?>" class="act-btn act-btn--danger" title="Nonaktifkan"
                                               onclick="return confirm('Yakin ingin menonaktifkan siswa ini?')"><i class="bi bi-person-x"></i></a>
                                        <?php else: ?>
                                            <a href="<?= base_url('admin/siswa/restore/' . $s['user_id']) ?>" class="act-btn act-btn--green" title="Aktifkan"
                                               onclick="return confirm('Yakin ingin mengaktifkan siswa ini?')"><i class="bi bi-person-check"></i></a>
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
.pg-wrap{padding:2rem 2rem 3rem;max-width:1280px}
.pg-header{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem}
.pg-eyebrow{font-size:.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#0051ba;margin-bottom:4px}
.pg-title{font-size:1.5rem;font-weight:800;color:#0f172a;margin-bottom:4px}
.pg-sub{font-size:.84rem;color:#6b7280;margin:0}
.btn-pg-action{display:inline-flex;align-items:center;gap:6px;background:#0051ba;color:#fff;font-size:.85rem;font-weight:600;padding:9px 18px;border-radius:8px;text-decoration:none;border:none;cursor:pointer;white-space:nowrap;transition:background .2s,transform .15s}
.btn-pg-action:hover{background:#003d8f;color:#fff;transform:translateY(-1px)}
.btn-pg-action--sm{font-size:.8rem;padding:7px 14px}
.alert-pg{display:flex;align-items:center;font-size:.875rem;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem;position:relative}
.alert-pg--success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534}
.alert-pg--danger{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}
.alert-pg-close{position:absolute;right:.75rem;background:none;border:none;font-size:1.1rem;cursor:pointer;color:inherit;opacity:.5;line-height:1;padding:0}
.alert-pg-close:hover{opacity:1}
.filter-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:10px;padding:1rem 1.25rem;margin-bottom:1rem;box-shadow:0 2px 8px rgba(15,23,42,.03)}
.filter-label{display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;margin-bottom:5px}
.f-input{display:block;width:100%;padding:.55rem .875rem;font-size:.875rem;color:#0f172a;background:#fff;border:1px solid #d1d5db;border-radius:8px;outline:none;transition:border-color .2s,box-shadow .2s;font-family:inherit}
.f-input:focus{border-color:#0051ba;box-shadow:0 0 0 3px rgba(0,81,186,.1)}
.btn-reset{display:inline-flex;align-items:center;justify-content:center;font-size:.85rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:9px;border-radius:8px;cursor:pointer;transition:all .15s;height:37px}
.btn-reset:hover{background:#f0f5ff;color:#0051ba;border-color:#c7d7f5}
.tbl-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);overflow:hidden}
.tbl{width:100%;border-collapse:collapse;font-size:.875rem}
.tbl thead tr{background:#f8fafc;border-bottom:1px solid #e9eef5}
.tbl thead th{padding:.75rem 1rem;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#6b7280;white-space:nowrap}
.tbl tbody tr{border-bottom:1px solid #f1f5f9;transition:background .15s}
.tbl tbody tr:last-child{border-bottom:none}
.tbl tbody tr:hover{background:#f8fbff}
.tbl tbody td{padding:.85rem 1rem;vertical-align:middle;color:#374151}
.tbl-num{color:#9ca3af;font-size:.8rem}.tbl-name{font-weight:600;color:#0f172a}.tbl-muted{color:#6b7280;font-size:.85rem}
.pg-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:rgba(0,81,186,.07);color:#0051ba}
.pg-badge--gray{background:rgba(107,114,128,.08);color:#4b5563}
.pg-badge--green{background:rgba(22,163,74,.08);color:#166534}
.pg-badge--red{background:rgba(220,38,38,.08);color:#b91c1c}
.act-group{display:flex;gap:4px}
.act-btn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:6px;font-size:.85rem;border:1px solid #e2e8f0;background:#fff;color:#475569;text-decoration:none;cursor:pointer;transition:all .15s}
.act-btn:hover{background:#f0f5ff;border-color:#c7d7f5;color:#0051ba}
.act-btn--danger{color:#b91c1c;border-color:#fecaca}
.act-btn--danger:hover{background:#fef2f2;border-color:#fca5a5;color:#b91c1c}
.act-btn--green{color:#166534;border-color:#bbf7d0}
.act-btn--green:hover{background:#f0fdf4;border-color:#86efac;color:#166534}
.tbl-empty{text-align:center;padding:3rem 1rem}
.tbl-empty i{font-size:2.5rem;display:block;margin-bottom:.75rem;color:#cbd5e1}
.tbl-empty p{color:#9ca3af;margin-bottom:1rem;font-size:.9rem}
@media(max-width:768px){.pg-wrap{padding:1.25rem 1rem 2rem}.pg-title{font-size:1.25rem}.pg-header{flex-direction:column}}
</style>

<script>
document.getElementById('filterStatus').addEventListener('change', filterTable);
document.getElementById('filterJenisKelamin').addEventListener('change', filterTable);
document.getElementById('filterSekolah').addEventListener('change', filterTable);
document.getElementById('filterKelas').addEventListener('change', filterTable);
document.getElementById('searchSiswa').addEventListener('keyup', filterTable);

function filterTable() {
    const s = document.getElementById('filterStatus').value;
    const jk = document.getElementById('filterJenisKelamin').value;
    const sk = document.getElementById('filterSekolah').value;
    const kl = document.getElementById('filterKelas').value;
    const q = document.getElementById('searchSiswa').value.toLowerCase();
    document.querySelectorAll('#tableSiswa tbody tr').forEach(row => {
        if (row.cells.length === 1) return;
        const match = (!s || row.dataset.status === s) &&
                      (!jk || row.dataset.jenisKelamin === jk) &&
                      (!sk || row.dataset.sekolah === sk) &&
                      (!kl || row.dataset.kelas === kl) &&
                      (!q || row.textContent.toLowerCase().includes(q));
        row.style.display = match ? '' : 'none';
    });
}

function resetFilter() {
    ['filterStatus','filterJenisKelamin','filterSekolah','filterKelas'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('searchSiswa').value = '';
    filterTable();
}
</script>

<?= $this->endSection() ?>
