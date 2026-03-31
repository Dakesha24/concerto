<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Kelola Pengguna</p>
            <h1 class="pg-title">Tambah Siswa</h1>
            <p class="pg-sub">Daftarkan akun siswa baru ke dalam sistem CONCERTO.</p>
        </div>
        <a href="<?= base_url('admin/siswa') ?>" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-pg alert-pg--danger">
            <i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error') ?>
            <button class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
    <?php if (session()->get('errors')): ?>
        <div class="alert-pg alert-pg--danger" style="align-items:flex-start">
            <i class="bi bi-exclamation-circle-fill me-2" style="margin-top:2px;flex-shrink:0"></i>
            <ul class="mb-0 ps-1">
                <?php foreach (session()->get('errors') as $err): ?><li><?= $err ?></li><?php endforeach; ?>
            </ul>
            <button class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Form Tambah Satu Siswa -->
    <form action="<?= base_url('admin/siswa/tambah') ?>" method="post">
        <?= csrf_field() ?>
        <div class="row g-3 mb-3">
            <div class="col-lg-6">
                <div class="form-card h-100">
                    <p class="form-section-label">Data Login</p>
                    <div class="mb-3">
                        <label class="f-label" for="username">Username <span class="f-req">*</span></label>
                        <input type="text" class="f-input" id="username" name="username" value="<?= old('username') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="f-label" for="email">Email <span class="f-req">*</span></label>
                        <input type="email" class="f-input" id="email" name="email" value="<?= old('email') ?>" required>
                    </div>
                    <div class="mb-0">
                        <label class="f-label" for="password">Password <span class="f-req">*</span></label>
                        <input type="password" class="f-input" id="password" name="password" required>
                        <p class="f-hint">Minimal 6 karakter</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-card h-100">
                    <p class="form-section-label">Data Siswa</p>
                    <div class="mb-3">
                        <label class="f-label" for="nama_lengkap">Nama Lengkap <span class="f-req">*</span></label>
                        <input type="text" class="f-input" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="f-label" for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="f-input" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" <?= old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="f-label" for="nomor_peserta">Nomor Peserta <span class="f-req">*</span></label>
                        <input type="text" class="f-input" id="nomor_peserta" name="nomor_peserta" value="<?= old('nomor_peserta') ?>" required>
                        <p class="f-hint">Nomor unik untuk setiap siswa</p>
                    </div>
                    <div class="mb-3">
                        <label class="f-label" for="sekolah_id">Sekolah <span class="f-req">*</span></label>
                        <select class="f-input" id="sekolah_id" name="sekolah_id" required onchange="filterKelas()">
                            <option value="">Pilih Sekolah</option>
                            <?php foreach ($sekolah as $s): ?>
                                <option value="<?= $s['sekolah_id'] ?>" <?= old('sekolah_id') == $s['sekolah_id'] ? 'selected' : '' ?>>
                                    <?= esc($s['nama_sekolah']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="f-label" for="kelas_id">Kelas <span class="f-req">*</span></label>
                        <select class="f-input" id="kelas_id" name="kelas_id" required disabled>
                            <option value="">Pilih Sekolah Terlebih Dahulu</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-footer mb-4">
            <a href="<?= base_url('admin/siswa') ?>" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit"><i class="bi bi-check-lg me-1"></i>Simpan Siswa</button>
        </div>
    </form>

    <!-- Generate Batch -->
    <div class="form-card">
        <p class="form-section-label">Generate Siswa Batch</p>
        <p class="pg-sub mb-3">Buat beberapa siswa sekaligus dengan nomor peserta otomatis.</p>
        <div id="batchForm">
            <div class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="f-label" for="batch_sekolah">Sekolah</label>
                    <select class="f-input" id="batch_sekolah" required onchange="filterKelasBatch()">
                        <option value="">Pilih Sekolah</option>
                        <?php foreach ($sekolah as $s): ?>
                            <option value="<?= $s['sekolah_id'] ?>"><?= esc($s['nama_sekolah']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="f-label" for="batch_kelas">Kelas</label>
                    <select class="f-input" id="batch_kelas" required disabled>
                        <option value="">Pilih Sekolah Dulu</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="f-label" for="batch_jenis_kelamin">Jenis Kelamin</label>
                    <select class="f-input" id="batch_jenis_kelamin">
                        <option value="">Acak</option>
                        <option value="Laki-laki">Semua Laki-laki</option>
                        <option value="Perempuan">Semua Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="f-label" for="batch_jumlah">Jumlah Siswa</label>
                    <input type="number" class="f-input" id="batch_jumlah" min="1" max="50" value="10">
                </div>
                <div class="col-md-2">
                    <label class="f-label" for="batch_prefix">Prefix No. Peserta</label>
                    <input type="text" class="f-input" id="batch_prefix" value="SISWA" maxlength="10">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn-submit w-100" onclick="generateBatch()">
                        <i class="bi bi-magic me-1"></i>Preview
                    </button>
                </div>
            </div>
        </div>

        <div id="batchPreview" class="mt-3" style="display:none">
            <div class="tbl-card">
                <div class="table-responsive">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Username</th><th>Email</th><th>Nama Lengkap</th><th>L/P</th><th>No. Peserta</th>
                            </tr>
                        </thead>
                        <tbody id="batchTable"></tbody>
                    </table>
                </div>
            </div>
            <div class="form-footer mt-2">
                <button type="button" class="btn-submit" onclick="createBatch()">
                    <i class="bi bi-check2-all me-1"></i>Buat Semua Siswa
                </button>
            </div>
        </div>
    </div>

</div>

<style>
.pg-wrap{padding:2rem 2rem 3rem;max-width:1100px}
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
.form-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);padding:1.5rem 1.75rem}
.form-section-label{font-size:.72rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#9ca3af;margin-bottom:1.1rem;padding-bottom:.6rem;border-bottom:1px solid #f1f5f9}
.f-label{display:block;font-size:.83rem;font-weight:600;color:#374151;margin-bottom:6px}
.f-req{color:#e53e3e}
.f-input{display:block;width:100%;padding:.6rem .875rem;font-size:.875rem;color:#0f172a;background:#fff;border:1px solid #d1d5db;border-radius:8px;outline:none;transition:border-color .2s,box-shadow .2s;font-family:inherit}
.f-input:focus{border-color:#0051ba;box-shadow:0 0 0 3px rgba(0,81,186,.1)}
.f-input::placeholder{color:#9ca3af}
.f-hint{font-size:.76rem;color:#9ca3af;margin-top:4px;margin-bottom:0}
.form-footer{display:flex;justify-content:flex-end;gap:8px;flex-wrap:wrap}
.btn-cancel{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:8px 18px;border-radius:8px;text-decoration:none;cursor:pointer;transition:all .15s}
.btn-cancel:hover{background:#f8fafc}
.btn-submit{display:inline-flex;align-items:center;justify-content:center;gap:6px;font-size:.85rem;font-weight:600;color:#fff;background:#0051ba;border:1px solid #0051ba;padding:8px 22px;border-radius:8px;cursor:pointer;transition:all .15s}
.btn-submit:hover{background:#003d8f;transform:translateY(-1px)}
.tbl-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:10px;overflow:hidden;margin-top:.75rem}
.tbl{width:100%;border-collapse:collapse;font-size:.875rem}
.tbl thead tr{background:#f8fafc;border-bottom:1px solid #e9eef5}
.tbl thead th{padding:.65rem 1rem;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#6b7280}
.tbl tbody tr{border-bottom:1px solid #f1f5f9}
.tbl tbody tr:last-child{border-bottom:none}
.tbl tbody td{padding:.7rem 1rem;vertical-align:middle;color:#374151;font-size:.84rem}
.pg-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:rgba(0,81,186,.07);color:#0051ba}
@media(max-width:768px){.pg-wrap{padding:1.25rem 1rem 2rem}.pg-title{font-size:1.25rem}.pg-header{flex-direction:column}.form-card{padding:1.25rem}}
</style>

<script>
const kelasData = <?= json_encode($kelas) ?>;

function filterKelas() {
    const sekolahId = document.getElementById('sekolah_id').value;
    const sel = document.getElementById('kelas_id');
    sel.innerHTML = '<option value="">Pilih Kelas</option>';
    if (sekolahId) {
        sel.disabled = false;
        kelasData.filter(k => k.sekolah_id == sekolahId).forEach(k => sel.add(new Option(`${k.nama_kelas} — ${k.tahun_ajaran}`, k.kelas_id)));
        const old = '<?= old('kelas_id') ?>';
        if (old) sel.value = old;
    } else {
        sel.disabled = true;
        sel.innerHTML = '<option value="">Pilih Sekolah Terlebih Dahulu</option>';
    }
}

function filterKelasBatch() {
    const sekolahId = document.getElementById('batch_sekolah').value;
    const sel = document.getElementById('batch_kelas');
    sel.innerHTML = '<option value="">Pilih Kelas</option>';
    if (sekolahId) {
        sel.disabled = false;
        kelasData.filter(k => k.sekolah_id == sekolahId).forEach(k => sel.add(new Option(`${k.nama_kelas} — ${k.tahun_ajaran}`, k.kelas_id)));
    } else {
        sel.disabled = true;
        sel.innerHTML = '<option value="">Pilih Sekolah Dulu</option>';
    }
}

function generateBatch() {
    const kelas = document.getElementById('batch_kelas').value;
    const jk = document.getElementById('batch_jenis_kelamin').value;
    const jumlah = parseInt(document.getElementById('batch_jumlah').value);
    const prefix = document.getElementById('batch_prefix').value;
    if (!kelas || !jumlah || !prefix) { alert('Harap lengkapi semua field'); return; }
    const tbody = document.getElementById('batchTable');
    tbody.innerHTML = '';
    for (let i = 1; i <= jumlah; i++) {
        const num = i.toString().padStart(3, '0');
        const gender = jk || (i % 2 === 1 ? 'Laki-laki' : 'Perempuan');
        tbody.innerHTML += `<tr>
            <td>${prefix.toLowerCase()}${num}</td>
            <td>${prefix.toLowerCase()}${num}@sekolah.com</td>
            <td>${prefix} ${num}</td>
            <td><span class="pg-badge">${gender === 'Laki-laki' ? 'L' : 'P'}</span></td>
            <td>${prefix}${num}</td>
        </tr>`;
    }
    document.getElementById('batchPreview').style.display = 'block';
}

function createBatch() {
    const kelas = document.getElementById('batch_kelas').value;
    const jk = document.getElementById('batch_jenis_kelamin').value;
    const jumlah = parseInt(document.getElementById('batch_jumlah').value);
    const prefix = document.getElementById('batch_prefix').value;
    if (confirm(`Yakin ingin membuat ${jumlah} siswa sekaligus?`)) {
        let url = `<?= base_url('admin/siswa/batch') ?>?kelas=${kelas}&jumlah=${jumlah}&prefix=${prefix}`;
        if (jk) url += `&jenis_kelamin=${jk}`;
        window.location.href = url;
    }
}

document.addEventListener('DOMContentLoaded', () => { if (document.getElementById('sekolah_id').value) filterKelas(); });
</script>

<?= $this->endSection() ?>
