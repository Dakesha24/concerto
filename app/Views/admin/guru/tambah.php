<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Kelola Pengguna</p>
            <h1 class="pg-title">Tambah Guru</h1>
            <p class="pg-sub">Daftarkan akun guru baru ke dalam sistem CONCERTO.</p>
        </div>
        <a href="<?= base_url('admin/guru') ?>" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali</a>
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

    <form action="<?= base_url('admin/guru/tambah') ?>" method="post" autocomplete="off">
        <?= csrf_field() ?>

        <div class="row g-3">
            <!-- Kolom kiri: Data Login -->
            <div class="col-lg-6">
                <div class="form-card h-100">
                    <p class="form-section-label">Data Login</p>
                    <div class="mb-3">
                        <label class="f-label" for="username">Username <span class="f-req">*</span></label>
                        <input type="text" class="f-input" id="username" name="username" autocomplete="off"
                               value="<?= old('username') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="f-label" for="email">Email <span class="f-req">*</span></label>
                        <input type="email" class="f-input" id="email" name="email" autocomplete="off"
                               value="<?= old('email') ?>" required>
                    </div>
                    <div class="mb-0">
                        <label class="f-label" for="password">Password <span class="f-req">*</span></label>
                        <input type="password" class="f-input" id="password" name="password" autocomplete="new-password" required>
                        <p class="f-hint">Minimal 6 karakter</p>
                    </div>
                </div>
            </div>

            <!-- Kolom kanan: Data Guru -->
            <div class="col-lg-6">
                <div class="form-card h-100">
                    <p class="form-section-label">Data Guru</p>
                    <div class="mb-3">
                        <label class="f-label" for="nama_lengkap">Nama Lengkap <span class="f-req">*</span></label>
                        <input type="text" class="f-input" id="nama_lengkap" name="nama_lengkap" autocomplete="off"
                               value="<?= old('nama_lengkap') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="f-label" for="nip">NIP</label>
                        <input type="text" class="f-input" id="nip" name="nip" autocomplete="off"
                               value="<?= old('nip') ?>">
                        <p class="f-hint">Opsional</p>
                    </div>
                    <div class="mb-3">
                        <label class="f-label" for="jenis_ujian_id">Mata Pelajaran <span class="f-req">*</span></label>
                        <?php if (empty($jenisUjian)): ?>
                            <div class="info-box">
                                <i class="bi bi-info-circle me-2"></i>Mata pelajaran belum tersedia.
                                <a href="<?= base_url('admin/jenis-ujian') ?>" class="ms-2" style="color:#0051ba;font-weight:600">Tambah sekarang →</a>
                            </div>
                        <?php else: ?>
                            <select class="f-input" id="jenis_ujian_id" name="jenis_ujian_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                <?php foreach ($jenisUjian as $j): ?>
                                    <option value="<?= $j['jenis_ujian_id'] ?>" <?= old('jenis_ujian_id') == $j['jenis_ujian_id'] ? 'selected' : '' ?>>
                                        <?= esc($j['nama_jenis']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <div class="mb-0">
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
                </div>
            </div>

            <!-- Kelas yang Diajar -->
            <div class="col-12">
                <div class="form-card">
                    <p class="form-section-label">Kelas yang Diajar <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#9ca3af">(opsional)</span></p>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="f-label" for="kelas_ids">Pilih Kelas</label>
                            <select class="f-input" id="kelas_ids" name="kelas_ids[]" multiple disabled style="min-height:80px">
                                <option value="">Pilih sekolah terlebih dahulu</option>
                            </select>
                            <p class="f-hint">Tahan Ctrl / Cmd untuk memilih lebih dari satu kelas. Dapat juga ditambahkan setelah guru dibuat.</p>
                        </div>
                        <div class="col-md-4">
                            <div id="selectedKelasPreview" style="display:none">
                                <label class="f-label">Kelas Dipilih</label>
                                <div id="selectedKelasList" class="kelas-preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-footer mt-3">
            <a href="<?= base_url('admin/guru') ?>" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit"><i class="bi bi-check-lg me-1"></i>Simpan Guru</button>
        </div>
    </form>

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
.f-input{display:block;width:100%;padding:.6rem .875rem;font-size:.875rem;color:#0f172a;background:#fff;border:1px solid #d1d5db;border-radius:8px;outline:none;transition:border-color .2s,box-shadow .2s;font-family:inherit;resize:vertical}
.f-input:focus{border-color:#0051ba;box-shadow:0 0 0 3px rgba(0,81,186,.1)}
.f-input::placeholder{color:#9ca3af}
.f-hint{font-size:.76rem;color:#9ca3af;margin-top:4px;margin-bottom:0}
.info-box{font-size:.84rem;background:#f0f5ff;border:1px solid rgba(0,81,186,.15);border-radius:8px;padding:.6rem .875rem;color:#374151}
.kelas-preview{display:flex;flex-wrap:wrap;gap:6px;padding:.75rem;background:#f8fafc;border-radius:8px;border:1px solid #e9eef5;min-height:60px}
.form-footer{display:flex;justify-content:flex-end;gap:8px;flex-wrap:wrap}
.btn-cancel{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:8px 18px;border-radius:8px;text-decoration:none;cursor:pointer;transition:all .15s}
.btn-cancel:hover{background:#f8fafc}
.btn-submit{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#fff;background:#0051ba;border:1px solid #0051ba;padding:8px 22px;border-radius:8px;cursor:pointer;transition:all .15s}
.btn-submit:hover{background:#003d8f;transform:translateY(-1px)}
@media(max-width:768px){.pg-wrap{padding:1.25rem 1rem 2rem}.pg-title{font-size:1.25rem}.pg-header{flex-direction:column}.form-card{padding:1.25rem}}
</style>

<script>
const kelasData = <?= json_encode($kelas) ?>;

function filterKelas() {
    const sekolahId = document.getElementById('sekolah_id').value;
    const sel = document.getElementById('kelas_ids');
    sel.innerHTML = '';
    if (sekolahId) {
        sel.disabled = false;
        const filtered = kelasData.filter(k => k.sekolah_id == sekolahId);
        if (filtered.length) {
            filtered.forEach(k => sel.add(new Option(`${k.nama_kelas} — ${k.tahun_ajaran}`, k.kelas_id)));
            const old = <?= json_encode(old('kelas_ids') ?? []) ?>;
            if (old.length) Array.from(sel.options).forEach(o => { if (old.includes(o.value)) o.selected = true; });
            updatePreview();
        } else {
            const o = new Option('Tidak ada kelas tersedia', ''); o.disabled = true; sel.add(o);
        }
    } else {
        sel.disabled = true;
        sel.add(new Option('Pilih sekolah terlebih dahulu', ''));
        document.getElementById('selectedKelasPreview').style.display = 'none';
    }
}

function updatePreview() {
    const sel = document.getElementById('kelas_ids');
    const selected = Array.from(sel.selectedOptions);
    const preview = document.getElementById('selectedKelasPreview');
    const list = document.getElementById('selectedKelasList');
    if (selected.length) {
        preview.style.display = 'block';
        list.innerHTML = selected.map(o => `<span class="pg-badge">${o.text}</span>`).join('');
    } else {
        preview.style.display = 'none';
    }
}

document.getElementById('kelas_ids').addEventListener('change', updatePreview);
document.addEventListener('DOMContentLoaded', () => { if (document.getElementById('sekolah_id').value) filterKelas(); });
</script>

<?= $this->endSection() ?>
