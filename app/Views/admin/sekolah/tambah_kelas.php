<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <nav class="pg-breadcrumb">
        <a href="<?= base_url('admin/sekolah') ?>"><i class="bi bi-buildings me-1"></i>Kelola Sekolah</a>
        <span class="pg-bc-sep"><i class="bi bi-chevron-right"></i></span>
        <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas') ?>"><?= esc($sekolah['nama_sekolah']) ?></a>
        <span class="pg-bc-sep"><i class="bi bi-chevron-right"></i></span>
        <span>Tambah Kelas</span>
    </nav>

    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Kelola Kelas</p>
            <h1 class="pg-title">Tambah Kelas Baru</h1>
            <p class="pg-sub">Kelas akan ditambahkan ke <strong><?= esc($sekolah['nama_sekolah']) ?></strong>.</p>
        </div>
        <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas') ?>" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

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
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= $err ?></li>
                <?php endforeach; ?>
            </ul>
            <button class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Info Bar Sekolah -->
    <div class="info-bar mb-3">
        <i class="bi bi-building me-2 text-primary" style="color:#0051ba!important"></i>
        <span><strong><?= esc($sekolah['nama_sekolah']) ?></strong></span>
        <?php if ($sekolah['alamat']): ?>
            <span class="info-bar-sep">·</span>
            <span class="text-muted"><?= esc($sekolah['alamat']) ?></span>
        <?php endif; ?>
        <?php if ($sekolah['telepon']): ?>
            <span class="info-bar-sep">·</span>
            <span class="text-muted"><?= esc($sekolah['telepon']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form-card">
        <form action="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas/tambah') ?>" method="POST">
            <?= csrf_field() ?>

            <p class="form-section-label">Data Kelas</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="f-label" for="nama_kelas">Nama Kelas <span class="f-req">*</span></label>
                    <input type="text" class="f-input" id="nama_kelas" name="nama_kelas"
                           value="<?= old('nama_kelas') ?>"
                           placeholder="Contoh: XII IPA 1, XI IPS 2" required>
                    <p class="f-hint">Format umum: [Tingkat] [Jurusan] [Nomor]</p>
                </div>
                <div class="col-md-6">
                    <label class="f-label" for="tahun_ajaran">Tahun Ajaran <span class="f-req">*</span></label>
                    <input type="text" class="f-input" id="tahun_ajaran" name="tahun_ajaran"
                           value="<?= old('tahun_ajaran', date('Y') . '/' . (date('Y') + 1)) ?>"
                           placeholder="Contoh: 2024/2025"
                           pattern="^\d{4}\/\d{4}$" required>
                    <p class="f-hint">Format: YYYY/YYYY</p>
                </div>
                <div class="col-12">
                    <label class="f-label">Pilih Cepat Tahun Ajaran</label>
                    <div class="quick-tags">
                        <?php
                        $cy = date('Y');
                        for ($i = -1; $i <= 3; $i++):
                            $y = $cy + $i;
                            $ta = $y . '/' . ($y + 1);
                        ?>
                            <button type="button" class="quick-tag" onclick="document.getElementById('tahun_ajaran').value='<?= $ta ?>'">
                                <?= $ta ?>
                            </button>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="<?= base_url('admin/sekolah/' . $sekolah['sekolah_id'] . '/kelas') ?>" class="btn-cancel">Batal</a>
                <button type="reset" class="btn-reset"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                <button type="submit" class="btn-submit"><i class="bi bi-check-lg me-1"></i>Simpan Kelas</button>
            </div>
        </form>
    </div>

</div>
<style>
.pg-wrap{padding:2rem 2rem 3rem;max-width:860px}
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
.alert-pg--danger{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}
.alert-pg-close{position:absolute;right:.75rem;background:none;border:none;font-size:1.1rem;cursor:pointer;color:inherit;opacity:.5;line-height:1;padding:0}
.alert-pg-close:hover{opacity:1}
.form-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);padding:1.75rem 2rem}
.form-section-label{font-size:.72rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#9ca3af;margin-bottom:1.1rem;padding-bottom:.6rem;border-bottom:1px solid #f1f5f9}
.f-label{display:block;font-size:.83rem;font-weight:600;color:#374151;margin-bottom:6px}
.f-req{color:#e53e3e}
.f-input{display:block;width:100%;padding:.6rem .875rem;font-size:.875rem;color:#0f172a;background:#fff;border:1px solid #d1d5db;border-radius:8px;outline:none;transition:border-color .2s,box-shadow .2s;font-family:inherit;resize:vertical}
.f-input:focus{border-color:#0051ba;box-shadow:0 0 0 3px rgba(0,81,186,.1)}
.f-input::placeholder{color:#9ca3af}
.f-hint{font-size:.76rem;color:#9ca3af;margin-top:4px;margin-bottom:0}
.form-footer{display:flex;justify-content:flex-end;gap:8px;flex-wrap:wrap;margin-top:1.75rem;padding-top:1.25rem;border-top:1px solid #f1f5f9}
.btn-cancel{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:8px 18px;border-radius:8px;text-decoration:none;cursor:pointer;transition:all .15s}
.btn-cancel:hover{background:#f8fafc;color:#374151}
.btn-reset{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#0051ba;background:rgba(0,81,186,.06);border:1px solid rgba(0,81,186,.2);padding:8px 18px;border-radius:8px;cursor:pointer;transition:all .15s}
.btn-reset:hover{background:rgba(0,81,186,.12)}
.btn-submit{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#fff;background:#0051ba;border:1px solid #0051ba;padding:8px 22px;border-radius:8px;cursor:pointer;transition:all .15s}
.btn-submit:hover{background:#003d8f;border-color:#003d8f;transform:translateY(-1px)}
@media(max-width:768px){.pg-wrap{padding:1.25rem 1rem 2rem}.pg-title{font-size:1.25rem}.pg-header{flex-direction:column}.form-card{padding:1.25rem}}
</style>
<style>
.info-bar { display:flex; align-items:center; gap:8px; flex-wrap:wrap; background:#f8fafc; border:1px solid #e9eef5; border-radius:8px; padding:.65rem 1rem; font-size:.84rem; }
.info-bar-sep { color:#cbd5e1; }
.quick-tags { display:flex; gap:6px; flex-wrap:wrap; }
.quick-tag { padding:4px 12px; border-radius:20px; font-size:.78rem; font-weight:600; border:1px solid #c7d7f5; background:#f0f5ff; color:#0051ba; cursor:pointer; transition:all .15s; }
.quick-tag:hover { background:#0051ba; color:#fff; border-color:#0051ba; }
</style>
<script>
document.getElementById('tahun_ajaran').addEventListener('input', function(e) {
    let v = e.target.value.replace(/\D/g, '');
    if (v.length >= 4) v = v.slice(0,4) + '/' + v.slice(4,8);
    e.target.value = v;
});
</script>
<?= $this->endSection() ?>
