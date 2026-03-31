<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <nav class="pg-breadcrumb">
        <a href="<?= base_url('admin/sekolah') ?>"><i class="bi bi-buildings me-1"></i>Kelola Sekolah</a>
        <span class="pg-bc-sep"><i class="bi bi-chevron-right"></i></span>
        <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas') ?>"><?= esc($sekolah['nama_sekolah']) ?></a>
        <span class="pg-bc-sep"><i class="bi bi-chevron-right"></i></span>
        <span><?= esc($kelas['nama_kelas']) ?></span>
    </nav>

    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Detail Kelas</p>
            <h1 class="pg-title"><?= esc($kelas['nama_kelas']) ?></h1>
            <p class="pg-sub"><?= esc($kelas['nama_sekolah']) ?> &nbsp;·&nbsp; Tahun Ajaran <?= esc($kelas['tahun_ajaran']) ?></p>
        </div>
        <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas/edit/' . $kelas['kelas_id']) ?>" class="btn-back">
            <i class="bi bi-pencil"></i> Edit Kelas
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

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6">
            <div class="s-card">
                <div class="s-icon"><i class="bi bi-person-workspace"></i></div>
                <div class="s-body">
                    <span class="s-label">Guru Pengajar</span>
                    <span class="s-value"><?= count($daftarGuru) ?></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="s-card">
                <div class="s-icon"><i class="bi bi-people-fill"></i></div>
                <div class="s-body">
                    <span class="s-label">Siswa Aktif</span>
                    <span class="s-value"><?= count($daftarSiswa) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="pg-tabs nav" id="kelasTab" role="tablist">
        <li class="nav-item">
            <button class="pg-tab-btn active" id="guru-tab" data-bs-toggle="tab" data-bs-target="#guru" type="button" role="tab">
                <i class="bi bi-person-workspace me-2"></i>Guru Pengajar <span class="tab-count"><?= count($daftarGuru) ?></span>
            </button>
        </li>
        <li class="nav-item">
            <button class="pg-tab-btn" id="siswa-tab" data-bs-toggle="tab" data-bs-target="#siswa" type="button" role="tab">
                <i class="bi bi-people me-2"></i>Daftar Siswa <span class="tab-count"><?= count($daftarSiswa) ?></span>
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Tab Guru -->
        <div class="tab-pane fade show active" id="guru" role="tabpanel">
            <div class="tbl-card">
                <div class="tbl-card-header">
                    <span class="tbl-card-title">Guru Pengajar</span>
                    <button class="btn-pg-action btn-pg-action--sm" data-bs-toggle="modal" data-bs-target="#tambah-guru">
                        <i class="bi bi-plus-lg"></i> Assign Guru
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th style="width:48px">No</th>
                                <th>Nama Guru</th>
                                <th>NIP</th>
                                <th>Mata Pelajaran</th>
                                <th>Username</th>
                                <th style="width:80px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftarGuru)): ?>
                                <tr><td colspan="6">
                                    <div class="tbl-empty">
                                        <i class="bi bi-person-workspace"></i>
                                        <p>Belum ada guru yang mengajar di kelas ini</p>
                                        <button class="btn-pg-action btn-pg-action--sm" data-bs-toggle="modal" data-bs-target="#tambah-guru">
                                            <i class="bi bi-plus-lg"></i> Assign Guru
                                        </button>
                                    </div>
                                </td></tr>
                            <?php else: ?>
                                <?php foreach ($daftarGuru as $i => $g): ?>
                                    <tr>
                                        <td class="tbl-num"><?= $i + 1 ?></td>
                                        <td class="tbl-name">
                                            <?= esc($g['nama_lengkap']) ?>
                                            <?php if ($g['status'] === 'inactive'): ?>
                                                <span class="pg-badge pg-badge--gray ms-1">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="tbl-muted"><?= esc($g['nip'] ?: '—') ?></td>
                                        <td><span class="pg-badge"><?= esc($g['mata_pelajaran']) ?></span></td>
                                        <td class="tbl-muted"><?= esc($g['username']) ?></td>
                                        <td>
                                            <div class="act-group">
                                                <a href="<?= base_url('admin/guru/edit/' . $g['user_id']) ?>" class="act-btn" title="Edit Guru"><i class="bi bi-pencil"></i></a>
                                                <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas/' . $kelas['kelas_id'] . '/guru/remove/' . $g['guru_id']) ?>"
                                                   class="act-btn act-btn--danger" title="Keluarkan dari Kelas"
                                                   onclick="return confirm('Yakin ingin mengeluarkan <?= esc($g['nama_lengkap']) ?> dari kelas ini?')">
                                                    <i class="bi bi-person-dash"></i>
                                                </a>
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

        <!-- Tab Siswa -->
        <div class="tab-pane fade" id="siswa" role="tabpanel">
            <div class="tbl-card">
                <div class="tbl-card-header">
                    <span class="tbl-card-title">Siswa <?= esc($kelas['nama_kelas']) ?></span>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('admin/siswa/tambah?kelas=' . $kelas['kelas_id']) ?>" class="btn-pg-action btn-pg-action--sm">
                            <i class="bi bi-plus-lg"></i> Tambah Siswa
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th style="width:48px">No</th>
                                <th>Nama Siswa</th>
                                <th>No. Peserta</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th style="width:80px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftarSiswa)): ?>
                                <tr><td colspan="6">
                                    <div class="tbl-empty">
                                        <i class="bi bi-people"></i>
                                        <p>Belum ada siswa di kelas ini</p>
                                        <a href="<?= base_url('admin/siswa/tambah?kelas=' . $kelas['kelas_id']) ?>" class="btn-pg-action btn-pg-action--sm">
                                            <i class="bi bi-plus-lg"></i> Tambah Siswa
                                        </a>
                                    </div>
                                </td></tr>
                            <?php else: ?>
                                <?php foreach ($daftarSiswa as $i => $s): ?>
                                    <tr>
                                        <td class="tbl-num"><?= $i + 1 ?></td>
                                        <td class="tbl-name"><?= esc($s['nama_lengkap']) ?></td>
                                        <td><span class="pg-badge pg-badge--gray"><?= esc($s['nomor_peserta']) ?></span></td>
                                        <td class="tbl-muted"><?= esc($s['username']) ?></td>
                                        <td>
                                            <?php if ($s['status'] === 'active'): ?>
                                                <span class="pg-badge pg-badge--green">Aktif</span>
                                            <?php else: ?>
                                                <span class="pg-badge pg-badge--red">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="act-group">
                                                <a href="<?= base_url('admin/siswa/edit/' . $s['user_id']) ?>" class="act-btn" title="Edit Siswa"><i class="bi bi-pencil"></i></a>
                                                <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas/' . $kelas['kelas_id'] . '/transfer-siswa/' . $s['siswa_id']) ?>"
                                                   class="act-btn" title="Transfer ke Kelas Lain"><i class="bi bi-arrow-right-circle"></i></a>
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
    </div>

</div>

<!-- Modal Assign Guru -->
<div class="modal fade" id="tambah-guru" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:12px;border:1px solid rgba(15,23,42,.08)">
            <form action="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas/' . $kelas['kelas_id'] . '/guru/assign') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header" style="border-bottom:1px solid #f1f5f9;padding:1.25rem 1.5rem">
                    <h5 class="modal-title" style="font-size:1rem;font-weight:700;color:#0f172a">Assign Guru ke Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:1.25rem 1.5rem">
                    <label class="f-label" for="guru_id">Pilih Guru <span class="f-req">*</span></label>
                    <select class="f-input" id="guru_id" name="guru_id" required>
                        <option value="">— Pilih Guru —</option>
                        <?php if (empty($availableGuru)): ?>
                            <option disabled>Tidak ada guru tersedia di sekolah ini</option>
                        <?php else: ?>
                            <?php foreach ($availableGuru as $g): ?>
                                <option value="<?= $g['guru_id'] ?>">
                                    <?= esc($g['nama_lengkap']) ?> — <?= esc($g['mata_pelajaran']) ?>
                                    <?php if ($g['kelas_diajar']): ?> (juga mengisi: <?= esc($g['kelas_diajar']) ?>)<?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <p class="f-hint mt-2">Hanya guru dari <strong><?= esc($kelas['nama_sekolah']) ?></strong> yang dapat dipilih.</p>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f1f5f9;padding:1rem 1.5rem;gap:8px">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit">Assign Guru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.pg-wrap{padding:2rem 2rem 3rem;max-width:1100px}
.pg-breadcrumb{display:flex;align-items:center;gap:6px;font-size:.8rem;color:#6b7280;margin-bottom:1rem}
.pg-breadcrumb a{color:#0051ba;text-decoration:none;font-weight:500}
.pg-breadcrumb a:hover{text-decoration:underline}
.pg-bc-sep{font-size:.65rem;color:#cbd5e1}
.pg-header{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem}
.pg-eyebrow{font-size:.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#0051ba;margin-bottom:4px}
.pg-title{font-size:1.5rem;font-weight:800;color:#0f172a;margin-bottom:4px}
.pg-sub{font-size:.84rem;color:#6b7280;margin:0}
.btn-back{display:inline-flex;align-items:center;gap:6px;font-size:.84rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:8px 16px;border-radius:8px;text-decoration:none;white-space:nowrap;transition:all .15s}
.btn-back:hover{background:#f8fafc;color:#0051ba;border-color:#c7d7f5}
.alert-pg{display:flex;align-items:center;font-size:.875rem;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem;position:relative}
.alert-pg--success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534}
.alert-pg--danger{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}
.alert-pg-close{position:absolute;right:.75rem;background:none;border:none;font-size:1.1rem;cursor:pointer;color:inherit;opacity:.5;line-height:1;padding:0}
.alert-pg-close:hover{opacity:1}
.s-card{background:#fff;border-radius:12px;border:1px solid rgba(0,0,0,.07);box-shadow:0 4px 16px rgba(15,23,42,.04);padding:1.1rem 1.25rem;display:flex;align-items:center;gap:.9rem}
.s-icon{flex-shrink:0;width:44px;height:44px;border-radius:9px;background:rgba(0,81,186,.08);color:#0051ba;display:flex;align-items:center;justify-content:center;font-size:1.1rem}
.s-body{display:flex;flex-direction:column;gap:1px}
.s-label{font-size:.72rem;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.4px}
.s-value{font-size:1.5rem;font-weight:800;color:#0f172a;line-height:1}
.pg-tabs{display:flex;gap:4px;border-bottom:2px solid #f1f5f9;margin-bottom:0;list-style:none;padding:0}
.pg-tab-btn{background:none;border:none;padding:.65rem 1.1rem;font-size:.875rem;font-weight:600;color:#6b7280;border-radius:8px 8px 0 0;cursor:pointer;transition:all .15s;display:flex;align-items:center}
.pg-tab-btn:hover{color:#0051ba;background:rgba(0,81,186,.04)}
.pg-tab-btn.active{color:#0051ba;border-bottom:2px solid #0051ba;margin-bottom:-2px;background:#fff}
.tab-count{display:inline-flex;align-items:center;justify-content:center;background:rgba(0,81,186,.08);color:#0051ba;font-size:.7rem;font-weight:700;min-width:18px;height:18px;border-radius:10px;padding:0 5px;margin-left:6px}
.pg-tab-btn.active .tab-count{background:#0051ba;color:#fff}
.tbl-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:0 12px 12px 12px;box-shadow:0 4px 16px rgba(15,23,42,.04);overflow:hidden;margin-bottom:1rem}
.tbl-card-header{display:flex;align-items:center;justify-content:space-between;padding:.875rem 1rem;border-bottom:1px solid #f1f5f9}
.tbl-card-title{font-size:.88rem;font-weight:700;color:#0f172a}
.btn-pg-action{display:inline-flex;align-items:center;gap:6px;background:#0051ba;color:#fff;font-size:.85rem;font-weight:600;padding:9px 18px;border-radius:8px;text-decoration:none;border:none;cursor:pointer;white-space:nowrap;transition:background .2s,transform .15s}
.btn-pg-action:hover{background:#003d8f;color:#fff;transform:translateY(-1px)}
.btn-pg-action--sm{font-size:.8rem;padding:7px 14px}
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
.tbl-empty{text-align:center;padding:3rem 1rem}
.tbl-empty i{font-size:2.5rem;display:block;margin-bottom:.75rem;color:#cbd5e1}
.tbl-empty p{color:#9ca3af;margin-bottom:1rem;font-size:.9rem}
.f-label{display:block;font-size:.83rem;font-weight:600;color:#374151;margin-bottom:6px}
.f-req{color:#e53e3e}
.f-input{display:block;width:100%;padding:.6rem .875rem;font-size:.875rem;color:#0f172a;background:#fff;border:1px solid #d1d5db;border-radius:8px;outline:none;transition:border-color .2s,box-shadow .2s;font-family:inherit}
.f-input:focus{border-color:#0051ba;box-shadow:0 0 0 3px rgba(0,81,186,.1)}
.f-hint{font-size:.76rem;color:#9ca3af;margin-bottom:0}
.btn-cancel{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:8px 18px;border-radius:8px;text-decoration:none;cursor:pointer;transition:all .15s}
.btn-cancel:hover{background:#f8fafc}
.btn-submit{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#fff;background:#0051ba;border:1px solid #0051ba;padding:8px 22px;border-radius:8px;cursor:pointer;transition:all .15s}
.btn-submit:hover{background:#003d8f;transform:translateY(-1px)}
@media(max-width:768px){.pg-wrap{padding:1.25rem 1rem 2rem}.pg-title{font-size:1.25rem}.pg-header{flex-direction:column}}
</style>

<?= $this->endSection() ?>
