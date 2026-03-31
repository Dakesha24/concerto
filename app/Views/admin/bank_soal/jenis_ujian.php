<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <div class="pg-breadcrumb">
                <a href="<?= base_url('admin/bank-soal') ?>" class="pg-bc-link"><i class="bi bi-database me-1"></i>Bank Soal</a>
                <span class="pg-bc-sep"><i class="bi bi-chevron-right"></i></span>
                <a href="<?= base_url('admin/bank-soal/kategori/' . urlencode($kategori)) ?>" class="pg-bc-link">
                    <?= $kategori === 'umum' ? 'Bank Soal Umum' : 'Kelas ' . esc($kategori) ?>
                </a>
                <span class="pg-bc-sep"><i class="bi bi-chevron-right"></i></span>
                <span class="pg-bc-active"><?= esc($jenisUjian['nama_jenis']) ?></span>
            </div>
            <p class="pg-eyebrow" style="margin-top:.5rem">Bank Ujian</p>
            <h1 class="pg-title"><?= esc($jenisUjian['nama_jenis']) ?></h1>
            <p class="pg-sub">Bank ujian untuk <?= $kategori === 'umum' ? 'kategori umum' : 'kelas ' . esc($kategori) ?>.</p>
        </div>
        <a href="<?= base_url('admin/bank-soal/kategori/' . urlencode($kategori)) ?>" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
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

    <div class="row g-3">
        <?php if (!empty($ujianList)): ?>
            <?php foreach ($ujianList as $ujian): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="kat-card">
                        <div class="kat-card-top">
                            <div class="kat-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="ms-auto dropdown">
                                <button class="act-btn" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:10px;font-size:.85rem">
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('admin/bank-soal/kategori/' . urlencode($kategori) . '/jenis-ujian/' . $jenisUjian['jenis_ujian_id'] . '/ujian/' . $ujian['bank_ujian_id']) ?>">
                                            <i class="bi bi-list-task me-2"></i>Kelola Soal
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="<?= base_url('admin/bank-soal/hapus/' . $ujian['bank_ujian_id']) ?>"
                                            onclick="return confirm('Yakin ingin menghapus bank ujian ini?')">
                                            <i class="bi bi-trash me-2"></i>Hapus Bank Ujian
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="kat-card-body">
                            <h5 class="kat-title"><?= esc($ujian['nama_ujian']) ?></h5>
                            <p style="font-size:.82rem;color:#6b7280;margin-bottom:.75rem;line-height:1.5"><?= esc($ujian['deskripsi']) ?></p>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <div class="stat-mini">
                                        <span class="stat-mini-val"><?= $ujian['jumlah_soal'] ?></span>
                                        <span class="stat-mini-label">Soal</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-mini">
                                        <span class="stat-mini-val" style="font-size:.78rem;line-height:1.3"><?= esc($ujian['creator_name']) ?></span>
                                        <span class="stat-mini-label">Pembuat</span>
                                    </div>
                                </div>
                            </div>

                            <p style="font-size:.76rem;color:#9ca3af;margin:0">
                                <i class="bi bi-clock me-1"></i>Dibuat: <?= date('d/m/Y H:i', strtotime($ujian['created_at'])) ?>
                            </p>
                        </div>

                        <div class="kat-card-footer">
                            <a href="<?= base_url('admin/bank-soal/kategori/' . urlencode($kategori) . '/jenis-ujian/' . $jenisUjian['jenis_ujian_id'] . '/ujian/' . $ujian['bank_ujian_id']) ?>"
                                class="kat-link">
                                Kelola Soal <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="tbl-card">
                    <div class="tbl-empty">
                        <i class="bi bi-file-earmark-x"></i>
                        <p>Belum ada bank ujian untuk jenis "<?= esc($jenisUjian['nama_jenis']) ?>"<br>dalam kategori "<?= esc($kategori) ?>"</p>
                        <a href="<?= base_url('admin/bank-soal') ?>" class="btn-pg-action btn-pg-action--sm">
                            <i class="bi bi-plus-lg"></i> Tambah Bank Soal Baru
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<style>
.pg-wrap{padding:2rem 2rem 3rem;max-width:1100px}
.pg-header{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem}
.pg-breadcrumb{display:flex;align-items:center;gap:6px;font-size:.8rem;margin-bottom:.25rem;flex-wrap:wrap}
.pg-bc-link{color:#9ca3af;text-decoration:none;transition:color .15s}.pg-bc-link:hover{color:#0051ba}
.pg-bc-sep{color:#d1d5db;font-size:.65rem}
.pg-bc-active{color:#374151;font-weight:600}
.pg-eyebrow{font-size:.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#0051ba;margin-bottom:4px}
.pg-title{font-size:1.5rem;font-weight:800;color:#0f172a;margin-bottom:4px}
.pg-sub{font-size:.84rem;color:#6b7280;margin:0}
.btn-back{display:inline-flex;align-items:center;gap:6px;font-size:.84rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:8px 16px;border-radius:8px;text-decoration:none;white-space:nowrap;transition:all .15s}
.btn-back:hover{background:#f8fafc;color:#0051ba;border-color:#c7d7f5}
.btn-pg-action{display:inline-flex;align-items:center;gap:6px;background:#0051ba;color:#fff;font-size:.85rem;font-weight:600;padding:9px 18px;border-radius:8px;text-decoration:none;border:none;cursor:pointer;white-space:nowrap;transition:background .2s,transform .15s}
.btn-pg-action:hover{background:#003d8f;color:#fff;transform:translateY(-1px)}
.btn-pg-action--sm{font-size:.8rem;padding:7px 14px}
.alert-pg{display:flex;align-items:center;font-size:.875rem;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem;position:relative}
.alert-pg--success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534}
.alert-pg--danger{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}
.alert-pg-close{position:absolute;right:.75rem;background:none;border:none;font-size:1.1rem;cursor:pointer;color:inherit;opacity:.5;line-height:1;padding:0}
.alert-pg-close:hover{opacity:1}
.kat-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:.75rem;transition:box-shadow .2s,transform .2s}
.kat-card:hover{box-shadow:0 8px 28px rgba(15,23,42,.09);transform:translateY(-2px)}
.kat-card-top{display:flex;align-items:center;gap:.75rem}
.kat-icon{width:44px;height:44px;border-radius:10px;background:rgba(0,81,186,.08);color:#0051ba;display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0}
.kat-title{font-size:.95rem;font-weight:700;color:#0f172a;margin-bottom:4px}
.kat-card-footer{border-top:1px solid #f1f5f9;padding-top:.75rem}
.kat-link{font-size:.84rem;font-weight:600;color:#0051ba;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:gap .15s}
.kat-link:hover{color:#003d8f;gap:8px}
.act-btn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:6px;font-size:.85rem;border:1px solid #e2e8f0;background:#fff;color:#475569;cursor:pointer;transition:all .15s}
.act-btn:hover{background:#f0f5ff;border-color:#c7d7f5;color:#0051ba}
.stat-mini{display:flex;flex-direction:column;align-items:center;padding:.5rem;background:#f8fafc;border-radius:8px;border:1px solid #f1f5f9}
.stat-mini-val{font-size:.88rem;font-weight:700;color:#0f172a;line-height:1}
.stat-mini-label{font-size:.7rem;color:#9ca3af;margin-top:2px}
.tbl-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);overflow:hidden}
.tbl-empty{text-align:center;padding:3rem 1rem}
.tbl-empty i{font-size:2.5rem;display:block;margin-bottom:.75rem;color:#cbd5e1}
.tbl-empty p{color:#9ca3af;margin-bottom:1rem;font-size:.9rem}
@media(max-width:768px){.pg-wrap{padding:1.25rem 1rem 2rem}.pg-title{font-size:1.25rem}.pg-header{flex-direction:column}}
</style>

<?= $this->endSection() ?>
