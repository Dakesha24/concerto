<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <!-- Breadcrumb -->
    <nav class="pg-breadcrumb">
        <a href="<?= base_url('admin/sekolah') ?>"><i class="bi bi-buildings me-1"></i>Kelola Sekolah</a>
        <span class="pg-bc-sep"><i class="bi bi-chevron-right"></i></span>
        <span>Tambah Sekolah</span>
    </nav>

    <!-- Page Header -->
    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Kelola Institusi</p>
            <h1 class="pg-title">Tambah Sekolah</h1>
            <p class="pg-sub">Isi data sekolah baru yang akan didaftarkan ke dalam sistem.</p>
        </div>
        <a href="<?= base_url('admin/sekolah') ?>" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Flash Errors -->
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

    <!-- Form Card -->
    <div class="form-card">
        <form action="<?= base_url('admin/sekolah/tambah') ?>" method="POST">
            <?= csrf_field() ?>

            <p class="form-section-label">Informasi Sekolah</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="f-label" for="nama_sekolah">Nama Sekolah <span class="f-req">*</span></label>
                    <input type="text" class="f-input" id="nama_sekolah" name="nama_sekolah"
                           value="<?= old('nama_sekolah') ?>"
                           placeholder="Contoh: SMA Negeri 1 Jakarta" required>
                </div>
                <div class="col-md-6">
                    <label class="f-label" for="email">Email</label>
                    <input type="email" class="f-input" id="email" name="email"
                           value="<?= old('email') ?>"
                           placeholder="email@sekolah.com">
                </div>
                <div class="col-md-6">
                    <label class="f-label" for="telepon">Telepon</label>
                    <input type="text" class="f-input" id="telepon" name="telepon"
                           value="<?= old('telepon') ?>"
                           placeholder="Contoh: 021-12345678">
                </div>
                <div class="col-md-6">
                    <label class="f-label" for="alamat">Alamat</label>
                    <textarea class="f-input" id="alamat" name="alamat"
                              rows="3" placeholder="Masukkan alamat lengkap sekolah"><?= old('alamat') ?></textarea>
                </div>
            </div>

            <div class="form-footer">
                <a href="<?= base_url('admin/sekolah') ?>" class="btn-cancel">Batal</a>
                <button type="reset" class="btn-reset">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </button>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-check-lg me-1"></i>Simpan Sekolah
                </button>
            </div>
        </form>
    </div>

</div>

<style>
.pg-wrap { padding: 2rem 2rem 3rem; max-width: 860px; }

/* Breadcrumb */
.pg-breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: .8rem; color: #6b7280; margin-bottom: 1rem;
}
.pg-breadcrumb a { color: #0051ba; text-decoration: none; font-weight: 500; }
.pg-breadcrumb a:hover { text-decoration: underline; }
.pg-bc-sep { font-size: .65rem; color: #cbd5e1; }

/* Page Header */
.pg-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 1rem;
    flex-wrap: wrap; margin-bottom: 1.5rem;
}
.pg-eyebrow {
    font-size: .7rem; font-weight: 700; letter-spacing: 2px;
    text-transform: uppercase; color: #0051ba; margin-bottom: 4px;
}
.pg-title { font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
.pg-sub   { font-size: .84rem; color: #6b7280; margin: 0; }

.btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: .84rem; font-weight: 600; color: #475569;
    background: #fff; border: 1px solid #e2e8f0;
    padding: 8px 16px; border-radius: 8px;
    text-decoration: none; white-space: nowrap;
    transition: all .15s;
}
.btn-back:hover { background: #f8fafc; color: #0051ba; border-color: #c7d7f5; }

/* Alerts */
.alert-pg {
    display: flex; align-items: center; font-size: .875rem;
    padding: .75rem 1rem; border-radius: 8px;
    margin-bottom: 1rem; position: relative;
}
.alert-pg--danger  { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
.alert-pg-close {
    position: absolute; right: .75rem; background: none; border: none;
    font-size: 1.1rem; cursor: pointer; color: inherit; opacity: .5; line-height: 1; padding: 0;
}
.alert-pg-close:hover { opacity: 1; }

/* Form Card */
.form-card {
    background: #fff;
    border: 1px solid rgba(15,23,42,.08);
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(15,23,42,.04);
    padding: 1.75rem 2rem;
}

.form-section-label {
    font-size: .72rem; font-weight: 700; letter-spacing: 1.5px;
    text-transform: uppercase; color: #9ca3af;
    margin-bottom: 1.1rem; padding-bottom: .6rem;
    border-bottom: 1px solid #f1f5f9;
}

/* Fields */
.f-label {
    display: block; font-size: .83rem; font-weight: 600;
    color: #374151; margin-bottom: 6px;
}
.f-req { color: #e53e3e; }

.f-input {
    display: block; width: 100%;
    padding: .6rem .875rem;
    font-size: .875rem; color: #0f172a;
    background: #fff;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    font-family: inherit;
    resize: vertical;
}
.f-input:focus {
    border-color: #0051ba;
    box-shadow: 0 0 0 3px rgba(0,81,186,.1);
}
.f-input::placeholder { color: #9ca3af; }

/* Form Footer */
.form-footer {
    display: flex; justify-content: flex-end; gap: 8px;
    flex-wrap: wrap; margin-top: 1.75rem;
    padding-top: 1.25rem; border-top: 1px solid #f1f5f9;
}

.btn-cancel {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: .85rem; font-weight: 600; color: #475569;
    background: #fff; border: 1px solid #e2e8f0;
    padding: 8px 18px; border-radius: 8px;
    text-decoration: none; cursor: pointer;
    transition: all .15s;
}
.btn-cancel:hover { background: #f8fafc; color: #374151; }

.btn-reset {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: .85rem; font-weight: 600; color: #0051ba;
    background: rgba(0,81,186,.06); border: 1px solid rgba(0,81,186,.2);
    padding: 8px 18px; border-radius: 8px; cursor: pointer;
    transition: all .15s;
}
.btn-reset:hover { background: rgba(0,81,186,.12); }

.btn-submit {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: .85rem; font-weight: 600; color: #fff;
    background: #0051ba; border: 1px solid #0051ba;
    padding: 8px 22px; border-radius: 8px; cursor: pointer;
    transition: all .15s;
}
.btn-submit:hover { background: #003d8f; border-color: #003d8f; transform: translateY(-1px); }

@media (max-width: 768px) {
    .pg-wrap   { padding: 1.25rem 1rem 2rem; }
    .pg-title  { font-size: 1.25rem; }
    .pg-header { flex-direction: column; }
    .form-card { padding: 1.25rem; }
}
</style>

<?= $this->endSection() ?>
