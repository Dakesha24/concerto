<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Kelola Konten</p>
            <h1 class="pg-title">Mata Pelajaran</h1>
            <p class="pg-sub">Kelola semua mata pelajaran dari seluruh sekolah dan guru.</p>
        </div>
        <?php if (!empty($semua_kelas)): ?>
            <button type="button" class="btn-pg-action" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="bi bi-plus-lg"></i> Tambah Mata Pelajaran
            </button>
        <?php else: ?>
            <a href="<?= base_url('admin/sekolah') ?>" class="btn-pg-action" style="background:#475569;border-color:#475569">
                <i class="bi bi-building me-1"></i> Tambah Kelas Dulu
            </a>
        <?php endif; ?>
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
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert-pg alert-pg--danger" style="align-items:flex-start">
            <i class="bi bi-exclamation-circle-fill me-2" style="margin-top:2px;flex-shrink:0"></i>
            <ul class="mb-0 ps-1">
                <?php foreach (session()->getFlashdata('errors') as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?>
            </ul>
            <button class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (empty($semua_kelas)): ?>
        <div class="alert-pg" style="background:#fffbeb;border:1px solid #fde68a;color:#92400e;margin-bottom:1rem">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Belum ada kelas yang tersedia. Tambahkan kelas terlebih dahulu sebelum membuat mata pelajaran.
            <a href="<?= base_url('admin/sekolah') ?>" class="ms-3" style="font-weight:600;color:#92400e;text-decoration:underline">Ke Menu Kelas &rarr;</a>
        </div>
    <?php endif; ?>

    <div class="row g-3">
        <?php if (!empty($jenis_ujian)): ?>
            <?php foreach ($jenis_ujian as $jenis): ?>
                <div class="col-lg-6 col-md-12">
                    <div class="kat-card">
                        <div class="kat-card-main">
                            <div class="kat-icon">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <div class="kat-info">
                                <h5 class="kat-title"><?= esc($jenis['nama_jenis']) ?></h5>
                                <p class="kat-sub">
                                    <i class="bi bi-mortarboard me-1"></i><?= esc($jenis['nama_kelas']) ?>
                                    <?php if (!empty($jenis['tahun_ajaran'])): ?>
                                        &nbsp;&middot;&nbsp;<?= esc($jenis['tahun_ajaran']) ?>
                                    <?php endif; ?>
                                </p>
                                <p class="kat-desc"><?= esc($jenis['deskripsi']) ?></p>
                                <p class="kat-meta">
                                    <i class="bi bi-person me-1"></i>Oleh: <?= esc($jenis['guru_nama'] ?? $jenis['creator_name']) ?>
                                    <?php if (!empty($jenis['nama_sekolah'])): ?>
                                        &nbsp;&middot;&nbsp;<i class="bi bi-building me-1"></i><?= esc($jenis['nama_sekolah']) ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="dropdown ms-auto">
                                <button class="act-btn" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:10px;font-size:.85rem">
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal<?= $jenis['jenis_ujian_id'] ?>">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="<?= base_url('admin/jenis-ujian/hapus/' . $jenis['jenis_ujian_id']) ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus Mata Pelajaran ini?')">
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="tbl-card">
                    <div class="tbl-empty">
                        <i class="bi bi-journal-x"></i>
                        <p>Belum ada mata pelajaran</p>
                        <?php if (!empty($semua_kelas)): ?>
                            <button type="button" class="btn-pg-action btn-pg-action--sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                <i class="bi bi-plus-lg"></i> Tambah Mata Pelajaran
                            </button>
                        <?php else: ?>
                            <a href="<?= base_url('admin/sekolah') ?>" class="btn-pg-action btn-pg-action--sm">
                                <i class="bi bi-building me-1"></i> Tambah Kelas Dulu
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border:none;border-radius:14px;box-shadow:0 12px 40px rgba(15,23,42,.12)">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" style="font-size:1rem;color:#0f172a">Tambah Mata Pelajaran</h5>
                    <p style="font-size:.8rem;color:#9ca3af;margin:2px 0 0">Isi detail mata pelajaran baru</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/jenis-ujian/tambah') ?>" method="post">
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="f-label">Nama Mata Pelajaran <span class="f-req">*</span></label>
                        <input type="text" class="f-input" name="nama_jenis" placeholder="Contoh: Fisika, Kimia, Matematika" required>
                    </div>
                    <div class="mb-3">
                        <label class="f-label">Kelas <span class="f-req">*</span></label>
                        <select class="f-input" name="kelas_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php if (!empty($semua_kelas)): ?>
                                <?php $currentSekolah = ''; foreach ($semua_kelas as $kelas): ?>
                                    <?php if ($currentSekolah !== $kelas['nama_sekolah']): ?>
                                        <?php if ($currentSekolah !== ''): ?></optgroup><?php endif; ?>
                                        <optgroup label="<?= esc($kelas['nama_sekolah']) ?>">
                                        <?php $currentSekolah = $kelas['nama_sekolah']; ?>
                                    <?php endif; ?>
                                    <option value="<?= $kelas['kelas_id'] ?>">
                                        <?= esc($kelas['nama_kelas']) ?><?php if (!empty($kelas['tahun_ajaran'])): ?> - <?= esc($kelas['tahun_ajaran']) ?><?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                                <?php if ($currentSekolah !== ''): ?></optgroup><?php endif; ?>
                            <?php endif; ?>
                        </select>
                        <p class="f-hint">Pilih kelas untuk mata pelajaran ini</p>
                    </div>
                    <div class="mb-0">
                        <label class="f-label">Deskripsi <span class="f-req">*</span></label>
                        <textarea class="f-input" name="deskripsi" rows="3" placeholder="Deskripsi singkat tentang mata pelajaran..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit"><i class="bi bi-check-lg me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($jenis_ujian as $jenis): ?>
    <div class="modal fade" id="editModal<?= $jenis['jenis_ujian_id'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border:none;border-radius:14px;box-shadow:0 12px 40px rgba(15,23,42,.12)">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold" style="font-size:1rem;color:#0f172a">Edit Mata Pelajaran</h5>
                        <p style="font-size:.8rem;color:#9ca3af;margin:2px 0 0"><?= esc($jenis['nama_jenis']) ?></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('admin/jenis-ujian/edit/' . $jenis['jenis_ujian_id']) ?>" method="post">
                    <div class="modal-body pt-3">
                        <div class="mb-3">
                            <label class="f-label">Nama Mata Pelajaran <span class="f-req">*</span></label>
                            <input type="text" class="f-input" name="nama_jenis" value="<?= esc($jenis['nama_jenis']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="f-label">Kelas <span class="f-req">*</span></label>
                            <select class="f-input" name="kelas_id" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php if (!empty($semua_kelas)): ?>
                                    <?php $currentSekolah = ''; foreach ($semua_kelas as $kelas): ?>
                                        <?php if ($currentSekolah !== $kelas['nama_sekolah']): ?>
                                            <?php if ($currentSekolah !== ''): ?></optgroup><?php endif; ?>
                                            <optgroup label="<?= esc($kelas['nama_sekolah']) ?>">
                                            <?php $currentSekolah = $kelas['nama_sekolah']; ?>
                                        <?php endif; ?>
                                        <option value="<?= $kelas['kelas_id'] ?>" <?= (isset($jenis['kelas_id']) && $jenis['kelas_id'] == $kelas['kelas_id']) ? 'selected' : '' ?>>
                                            <?= esc($kelas['nama_kelas']) ?><?php if (!empty($kelas['tahun_ajaran'])): ?> - <?= esc($kelas['tahun_ajaran']) ?><?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <?php if ($currentSekolah !== ''): ?></optgroup><?php endif; ?>
                                <?php endif; ?>
                            </select>
                            <p class="f-hint">Pilih kelas untuk mata pelajaran ini</p>
                        </div>
                        <div class="mb-0">
                            <label class="f-label">Deskripsi <span class="f-req">*</span></label>
                            <textarea class="f-input" name="deskripsi" rows="3" required><?= esc($jenis['deskripsi']) ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-submit"><i class="bi bi-check-lg me-1"></i>Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<style>
.pg-wrap{padding:2rem 2rem 3rem;max-width:1100px}
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
.kat-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);padding:1.25rem 1.5rem;transition:box-shadow .2s,transform .2s}
.kat-card:hover{box-shadow:0 8px 28px rgba(15,23,42,.09);transform:translateY(-2px)}
.kat-card-main{display:flex;align-items:flex-start;gap:.875rem}
.kat-icon{width:44px;height:44px;border-radius:10px;background:rgba(0,81,186,.08);color:#0051ba;display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;margin-top:2px}
.kat-info{flex:1;min-width:0}
.kat-title{font-size:.95rem;font-weight:700;color:#0f172a;margin-bottom:2px}
.kat-sub{font-size:.78rem;color:#0051ba;margin-bottom:4px}
.kat-desc{font-size:.82rem;color:#6b7280;margin-bottom:4px}
.kat-meta{font-size:.76rem;color:#9ca3af;margin:0}
.act-btn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:6px;font-size:.85rem;border:1px solid #e2e8f0;background:#fff;color:#475569;cursor:pointer;transition:all .15s}
.act-btn:hover{background:#f0f5ff;border-color:#c7d7f5;color:#0051ba}
.tbl-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);overflow:hidden}
.tbl-empty{text-align:center;padding:3rem 1rem}
.tbl-empty i{font-size:2.5rem;display:block;margin-bottom:.75rem;color:#cbd5e1}
.tbl-empty p{color:#9ca3af;margin-bottom:1rem;font-size:.9rem}
.f-label{display:block;font-size:.83rem;font-weight:600;color:#374151;margin-bottom:6px}
.f-req{color:#e53e3e}
.f-input{display:block;width:100%;padding:.6rem .875rem;font-size:.875rem;color:#0f172a;background:#fff;border:1px solid #d1d5db;border-radius:8px;outline:none;transition:border-color .2s,box-shadow .2s;font-family:inherit}
.f-input:focus{border-color:#0051ba;box-shadow:0 0 0 3px rgba(0,81,186,.1)}
.f-hint{font-size:.76rem;color:#9ca3af;margin-top:4px;margin-bottom:0}
.btn-cancel{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:8px 18px;border-radius:8px;text-decoration:none;cursor:pointer;transition:all .15s}
.btn-cancel:hover{background:#f8fafc}
.btn-submit{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#fff;background:#0051ba;border:1px solid #0051ba;padding:8px 22px;border-radius:8px;cursor:pointer;transition:all .15s}
.btn-submit:hover{background:#003d8f;transform:translateY(-1px)}
@media(max-width:768px){.pg-wrap{padding:1.25rem 1rem 2rem}.pg-title{font-size:1.25rem}.pg-header{flex-direction:column}}
</style>

<?= $this->endSection() ?>
