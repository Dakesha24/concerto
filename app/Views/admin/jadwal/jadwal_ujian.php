<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Kelola Konten</p>
            <h1 class="pg-title">Jadwal Ujian</h1>
            <p class="pg-sub">Atur jadwal pelaksanaan ujian untuk kelas yang Anda ajar.</p>
        </div>
        <button type="button" class="btn-pg-action" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
            <i class="bi bi-plus-lg"></i> Tambah Jadwal
        </button>
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
        <?php if (!empty($jadwal)): ?>
            <?php foreach ($jadwal as $j): ?>
                <?php
                $statusClass = 'pg-badge--gray';
                $statusText  = ucwords(str_replace('_', ' ', $j['status']));
                if ($j['status'] == 'sedang_berlangsung') $statusClass = 'pg-badge--green';
                elseif ($j['status'] == 'selesai')        $statusClass = 'pg-badge--dark';
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="j-card">
                        <div class="j-card-top">
                            <div class="j-icon"><i class="bi bi-calendar-event"></i></div>
                            <span class="pg-badge <?= $statusClass ?>"><?= $statusText ?></span>
                            <div class="dropdown ms-auto">
                                <button class="act-btn" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:10px;font-size:.85rem">
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editJadwalModal<?= $j['jadwal_id'] ?>">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="<?= base_url('admin/jadwal-ujian/hapus/' . $j['jadwal_id']) ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="j-card-body">
                            <h5 class="j-title"><?= esc($j['nama_ujian']) ?></h5>
                            <p class="j-kode"><i class="bi bi-code-square me-1"></i>Kode: <?= esc($j['kode_ujian']) ?></p>
                            <div class="j-info">
                                <p><i class="bi bi-building me-1"></i><?= esc($j['nama_sekolah']) ?></p>
                                <p><i class="bi bi-people me-1"></i>Kelas <?= esc($j['nama_kelas']) ?></p>
                                <p><i class="bi bi-person-check me-1"></i>Pengawas: <?= esc($j['nama_lengkap']) ?></p>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-12">
                                    <div class="stat-mini">
                                        <span class="stat-mini-val"><?= date('d/m/Y H:i', strtotime($j['tanggal_mulai'])) ?></span>
                                        <span class="stat-mini-label">Mulai</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="stat-mini">
                                        <span class="stat-mini-val"><?= date('d/m/Y H:i', strtotime($j['tanggal_selesai'])) ?></span>
                                        <span class="stat-mini-label">Selesai</span>
                                    </div>
                                </div>
                            </div>

                            <div class="j-akses">
                                <span class="j-akses-label">Kode Akses:</span>
                                <span class="j-akses-val"><?= esc($j['kode_akses']) ?></span>
                            </div>
                        </div>

                        <div class="j-card-footer">
                            <button class="kat-link" type="button" data-bs-toggle="modal" data-bs-target="#editJadwalModal<?= $j['jadwal_id'] ?>">
                                <i class="bi bi-pencil me-1"></i>Edit Jadwal
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="tbl-card">
                    <div class="tbl-empty">
                        <i class="bi bi-calendar-x"></i>
                        <p>Belum ada jadwal ujian</p>
                        <button type="button" class="btn-pg-action btn-pg-action--sm" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
                            <i class="bi bi-plus-lg"></i> Tambah Jadwal
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahJadwalModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none;border-radius:14px;box-shadow:0 12px 40px rgba(15,23,42,.12)">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" style="font-size:1rem;color:#0f172a">Tambah Jadwal Ujian</h5>
                    <p style="font-size:.8rem;color:#9ca3af;margin:2px 0 0">Isi detail jadwal ujian baru</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/jadwal-ujian/tambah') ?>" method="post" id="formTambahJadwal">
                <div class="modal-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="f-label">Sekolah <span class="f-req">*</span></label>
                            <select id="sekolah-select-tambah" name="sekolah_id" class="f-input" required>
                                <option value="">Pilih Sekolah Terlebih Dahulu</option>
                                <?php if (!empty($sekolah)): ?>
                                    <?php foreach ($sekolah as $s): ?>
                                        <option value="<?= $s['sekolah_id'] ?>"><?= esc($s['nama_sekolah']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="f-label">Kelas <span class="f-req">*</span></label>
                            <select id="kelas-select-tambah" name="kelas_id" class="f-input" required disabled>
                                <option value="">Pilih Sekolah Terlebih Dahulu</option>
                            </select>
                            <p class="f-hint">Pilih kelas yang akan mengikuti ujian</p>
                        </div>
                        <div class="col-12">
                            <label class="f-label">Ujian <span class="f-req">*</span></label>
                            <select id="ujian-select-tambah" name="ujian_id" class="f-input" required disabled>
                                <option value="">Pilih Kelas Terlebih Dahulu</option>
                            </select>
                            <p class="f-hint">Menampilkan ujian umum dan ujian khusus untuk kelas yang dipilih</p>
                        </div>
                        <div class="col-12">
                            <label class="f-label">Guru Pengawas <span class="f-req">*</span></label>
                            <select name="guru_id" class="f-input" required>
                                <option value="">Pilih Guru Pengawas</option>
                                <?php if (!empty($guru)): ?>
                                    <?php foreach ($guru as $g): ?>
                                        <option value="<?= $g['guru_id'] ?>">
                                            <?= esc($g['nama_lengkap']) ?> - <?= esc($g['mata_pelajaran']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-12"><hr style="border-color:#f1f5f9;margin:.25rem 0"></div>
                        <div class="col-12">
                            <p style="font-size:.78rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#9ca3af;margin-bottom:.5rem">
                                <i class="bi bi-clock me-1"></i>Pengaturan Waktu
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="f-label">Tanggal & Waktu Mulai <span class="f-req">*</span></label>
                            <input type="datetime-local" name="tanggal_mulai" class="f-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="f-label">Tanggal & Waktu Selesai <span class="f-req">*</span></label>
                            <input type="datetime-local" name="tanggal_selesai" class="f-input" required>
                        </div>
                        <div class="col-12">
                            <label class="f-label">Kode Akses <span class="f-req">*</span></label>
                            <div style="display:flex;gap:8px">
                                <input type="text" name="kode_akses" class="f-input" placeholder="Masukkan kode akses ujian" required>
                                <button type="button" class="btn-cancel" style="white-space:nowrap" onclick="generateKodeAkses()">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Generate
                                </button>
                            </div>
                            <p class="f-hint">Kode yang akan digunakan siswa untuk mengakses ujian</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit"><i class="bi bi-check-lg me-1"></i>Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit per jadwal -->
<?php if (!empty($jadwal)): ?>
    <?php foreach ($jadwal as $j): ?>
        <div class="modal fade" id="editJadwalModal<?= $j['jadwal_id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border:none;border-radius:14px;box-shadow:0 12px 40px rgba(15,23,42,.12)">
                    <div class="modal-header border-0 pb-0">
                        <div>
                            <h5 class="modal-title fw-bold" style="font-size:1rem;color:#0f172a">Edit Jadwal Ujian</h5>
                            <p style="font-size:.8rem;color:#9ca3af;margin:2px 0 0"><?= esc($j['nama_ujian']) ?></p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?= base_url('admin/jadwal-ujian/edit/' . $j['jadwal_id']) ?>" method="post">
                        <div class="modal-body pt-3">
                            <div class="info-box mb-3">
                                <strong>Ujian:</strong> <?= esc($j['nama_ujian']) ?> &nbsp;&middot;&nbsp;
                                <strong>Kelas:</strong> <?= esc($j['nama_kelas']) ?> &nbsp;&middot;&nbsp;
                                <strong>Sekolah:</strong> <?= esc($j['nama_sekolah']) ?>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="f-label">Sekolah <span class="f-req">*</span></label>
                                    <select class="f-input sekolah-select-edit" name="sekolah_id" data-jadwal-id="<?= $j['jadwal_id'] ?>" required>
                                        <option value="">Pilih Sekolah</option>
                                        <?php if (!empty($sekolah)): ?>
                                            <?php foreach ($sekolah as $s): ?>
                                                <option value="<?= $s['sekolah_id'] ?>"
                                                    <?= (isset($j['sekolah_id']) && $j['sekolah_id'] == $s['sekolah_id']) ? 'selected' : '' ?>>
                                                    <?= esc($s['nama_sekolah']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-label">Kelas <span class="f-req">*</span></label>
                                    <select class="f-input kelas-select-edit" name="kelas_id" data-jadwal-id="<?= $j['jadwal_id'] ?>" required>
                                        <option value="<?= $j['kelas_id'] ?>" selected>
                                            <?= esc($j['nama_kelas']) ?> (<?= esc($j['nama_sekolah']) ?>)
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="f-label">Ujian <span class="f-req">*</span></label>
                                    <select class="f-input ujian-select-edit" name="ujian_id" data-jadwal-id="<?= $j['jadwal_id'] ?>" required>
                                        <option value="<?= $j['ujian_id'] ?>" selected>
                                            <?= esc($j['nama_ujian']) ?> (<?= esc($j['kode_ujian']) ?>)
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="f-label">Guru Pengawas <span class="f-req">*</span></label>
                                    <select name="guru_id" class="f-input" required>
                                        <option value="">Pilih Guru Pengawas</option>
                                        <?php if (!empty($guru)): ?>
                                            <?php foreach ($guru as $g): ?>
                                                <option value="<?= $g['guru_id'] ?>" <?= ($g['guru_id'] == $j['guru_id']) ? 'selected' : '' ?>>
                                                    <?= esc($g['nama_lengkap']) ?> - <?= esc($g['mata_pelajaran']) ?> (<?= esc($g['nama_sekolah']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-label">Tanggal & Waktu Mulai <span class="f-req">*</span></label>
                                    <input type="datetime-local" name="tanggal_mulai" class="f-input" value="<?= date('Y-m-d\TH:i', strtotime($j['tanggal_mulai'])) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-label">Tanggal & Waktu Selesai <span class="f-req">*</span></label>
                                    <input type="datetime-local" name="tanggal_selesai" class="f-input" value="<?= date('Y-m-d\TH:i', strtotime($j['tanggal_selesai'])) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-label">Kode Akses <span class="f-req">*</span></label>
                                    <input type="text" name="kode_akses" class="f-input" value="<?= esc($j['kode_akses']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-label">Status <span class="f-req">*</span></label>
                                    <select name="status" class="f-input" required>
                                        <option value="belum_mulai" <?= ($j['status'] == 'belum_mulai') ? 'selected' : '' ?>>Belum Mulai</option>
                                        <option value="sedang_berlangsung" <?= ($j['status'] == 'sedang_berlangsung') ? 'selected' : '' ?>>Sedang Berlangsung</option>
                                        <option value="selesai" <?= ($j['status'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-submit"><i class="bi bi-check-lg me-1"></i>Update Jadwal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

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
/* Jadwal Card */
.j-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:.75rem;transition:box-shadow .2s,transform .2s}
.j-card:hover{box-shadow:0 8px 28px rgba(15,23,42,.09);transform:translateY(-2px)}
.j-card-top{display:flex;align-items:center;gap:.75rem}
.j-icon{width:40px;height:40px;border-radius:9px;background:rgba(0,81,186,.08);color:#0051ba;display:inline-flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0}
.j-card-body{}
.j-title{font-size:.95rem;font-weight:700;color:#0f172a;margin-bottom:3px;line-height:1.3}
.j-kode{font-size:.78rem;color:#6b7280;margin-bottom:.5rem}
.j-info p{font-size:.8rem;color:#6b7280;margin-bottom:2px}
.j-info p i{color:#9ca3af}
.j-info{margin-bottom:.75rem}
.j-akses{display:flex;justify-content:space-between;align-items:center;background:#f8fafc;border:1px solid #f1f5f9;border-radius:8px;padding:.4rem .75rem}
.j-akses-label{font-size:.75rem;color:#9ca3af}
.j-akses-val{font-size:.84rem;font-weight:700;color:#0051ba;letter-spacing:.5px}
.j-card-footer{border-top:1px solid #f1f5f9;padding-top:.75rem}
.kat-link{font-size:.84rem;font-weight:600;color:#0051ba;text-decoration:none;background:none;border:none;padding:0;cursor:pointer;display:inline-flex;align-items:center;gap:4px;transition:gap .15s}
.kat-link:hover{color:#003d8f;gap:8px}
.pg-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:rgba(0,81,186,.07);color:#0051ba}
.pg-badge--gray{background:rgba(107,114,128,.08);color:#4b5563}
.pg-badge--green{background:rgba(22,163,74,.08);color:#166534}
.pg-badge--dark{background:rgba(15,23,42,.07);color:#374151}
.stat-mini{display:flex;flex-direction:column;align-items:center;padding:.4rem .75rem;background:#f8fafc;border-radius:8px;border:1px solid #f1f5f9}
.stat-mini-val{font-size:.82rem;font-weight:700;color:#0f172a;line-height:1.2}
.stat-mini-label{font-size:.68rem;color:#9ca3af;margin-top:1px}
.act-btn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:6px;font-size:.85rem;border:1px solid #e2e8f0;background:#fff;color:#475569;cursor:pointer;transition:all .15s}
.act-btn:hover{background:#f0f5ff;border-color:#c7d7f5;color:#0051ba}
.tbl-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;overflow:hidden}
.tbl-empty{text-align:center;padding:3rem 1rem}
.tbl-empty i{font-size:2.5rem;display:block;margin-bottom:.75rem;color:#cbd5e1}
.tbl-empty p{color:#9ca3af;margin-bottom:1rem;font-size:.9rem}
.info-box{font-size:.82rem;background:#f0f5ff;border:1px solid rgba(0,81,186,.15);border-radius:8px;padding:.6rem .875rem;color:#374151}
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sekolahSelectTambah = document.getElementById('sekolah-select-tambah');
    const kelasSelectTambah  = document.getElementById('kelas-select-tambah');
    const ujianSelectTambah  = document.getElementById('ujian-select-tambah');

    if (sekolahSelectTambah && kelasSelectTambah) {
        sekolahSelectTambah.addEventListener('change', function() {
            handleSekolahChangeTambah(this, kelasSelectTambah, ujianSelectTambah);
        });
    }

    if (kelasSelectTambah && ujianSelectTambah) {
        kelasSelectTambah.addEventListener('change', function() {
            handleKelasChangeTambah(this, ujianSelectTambah);
        });
    }

    const sekolahSelectsEdit = document.querySelectorAll('.sekolah-select-edit');
    sekolahSelectsEdit.forEach(function(sekolahSelect) {
        const jadwalId   = sekolahSelect.dataset.jadwalId;
        const kelasSelect = document.querySelector(`.kelas-select-edit[data-jadwal-id="${jadwalId}"]`);
        const ujianSelect = document.querySelector(`.ujian-select-edit[data-jadwal-id="${jadwalId}"]`);

        if (kelasSelect) {
            sekolahSelect.addEventListener('change', function() {
                handleSekolahChangeEdit(this, kelasSelect, ujianSelect);
            });
        }

        if (kelasSelect && ujianSelect) {
            kelasSelect.addEventListener('change', function() {
                handleKelasChangeEdit(this, ujianSelect);
            });
        }
    });

    function handleSekolahChangeTambah(sekolahSelect, kelasSelect, ujianSelect) {
        const sekolahId = sekolahSelect.value;
        kelasSelect.innerHTML = '<option value="">Memuat kelas...</option>';
        kelasSelect.disabled = true;
        ujianSelect.innerHTML = '<option value="">Pilih Kelas Terlebih Dahulu</option>';
        ujianSelect.disabled = true;

        if (!sekolahId) {
            kelasSelect.innerHTML = '<option value="">Pilih Sekolah Terlebih Dahulu</option>';
            return;
        }

        fetch(`<?= base_url('admin/api/kelas-by-sekolah/') ?>${sekolahId}`)
            .then(r => r.json())
            .then(data => {
                kelasSelect.innerHTML = '<option value="">Pilih Kelas</option>';
                if (data.status === 'success' && Array.isArray(data.data)) {
                    data.data.forEach(k => {
                        const o = document.createElement('option');
                        o.value = k.kelas_id;
                        o.textContent = k.nama_kelas;
                        kelasSelect.appendChild(o);
                    });
                }
                kelasSelect.disabled = false;
            })
            .catch(() => {
                kelasSelect.innerHTML = '<option value="">Gagal memuat kelas</option>';
                kelasSelect.disabled = false;
            });
    }

    function handleKelasChangeTambah(kelasSelect, ujianSelect) {
        const kelasId = kelasSelect.value;
        ujianSelect.innerHTML = '<option value="">Memuat ujian...</option>';
        ujianSelect.disabled = true;

        if (!kelasId) {
            ujianSelect.innerHTML = '<option value="">Pilih Kelas Terlebih Dahulu</option>';
            return;
        }

        fetch(`<?= base_url('admin/api/ujian-by-kelas/') ?>${kelasId}`)
            .then(r => r.json())
            .then(data => {
                ujianSelect.innerHTML = '<option value="">Pilih Ujian</option>';
                if (data.status === 'success' && Array.isArray(data.data)) {
                    data.data.forEach(u => {
                        const o = document.createElement('option');
                        o.value = u.id_ujian;
                        o.textContent = `${u.nama_ujian} (${u.kode_ujian})${!u.kelas_id ? ' - Umum' : ''}`;
                        ujianSelect.appendChild(o);
                    });
                }
                ujianSelect.disabled = false;
            })
            .catch(() => {
                ujianSelect.innerHTML = '<option value="">Gagal memuat ujian</option>';
                ujianSelect.disabled = false;
            });
    }

    function handleSekolahChangeEdit(sekolahSelect, kelasSelect, ujianSelect) {
        const sekolahId = sekolahSelect.value;
        kelasSelect.innerHTML = '<option value="">Memuat kelas...</option>';
        kelasSelect.disabled = true;
        ujianSelect.innerHTML = '<option value="">Pilih Kelas Terlebih Dahulu</option>';
        ujianSelect.disabled = true;

        if (!sekolahId) {
            kelasSelect.innerHTML = '<option value="">Pilih Sekolah Terlebih Dahulu</option>';
            return;
        }

        fetch(`<?= base_url('admin/api/kelas-by-sekolah/') ?>${sekolahId}`)
            .then(r => r.json())
            .then(data => {
                kelasSelect.innerHTML = '<option value="">Pilih Kelas</option>';
                if (data.status === 'success' && Array.isArray(data.data)) {
                    data.data.forEach(k => {
                        const o = document.createElement('option');
                        o.value = k.kelas_id;
                        o.textContent = k.nama_kelas;
                        kelasSelect.appendChild(o);
                    });
                }
                kelasSelect.disabled = false;
            })
            .catch(() => {
                kelasSelect.innerHTML = '<option value="">Gagal memuat kelas</option>';
                kelasSelect.disabled = false;
            });
    }

    function handleKelasChangeEdit(kelasSelect, ujianSelect) {
        const kelasId = kelasSelect.value;
        ujianSelect.innerHTML = '<option value="">Memuat ujian...</option>';
        ujianSelect.disabled = true;

        if (!kelasId) {
            ujianSelect.innerHTML = '<option value="">Pilih Kelas Terlebih Dahulu</option>';
            return;
        }

        fetch(`<?= base_url('admin/api/ujian-by-kelas/') ?>${kelasId}`)
            .then(r => r.json())
            .then(data => {
                ujianSelect.innerHTML = '<option value="">Pilih Ujian</option>';
                if (data.status === 'success' && Array.isArray(data.data)) {
                    data.data.forEach(u => {
                        const o = document.createElement('option');
                        o.value = u.id_ujian;
                        o.textContent = `${u.nama_ujian} (${u.kode_ujian})${!u.kelas_id ? ' - Umum' : ''}`;
                        ujianSelect.appendChild(o);
                    });
                }
                ujianSelect.disabled = false;
            })
            .catch(() => {
                ujianSelect.innerHTML = '<option value="">Gagal memuat ujian</option>';
                ujianSelect.disabled = false;
            });
    }

    // Reset form when modal tambah closed
    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            const form = modal.querySelector('form');
            if (form && form.id === 'formTambahJadwal') {
                form.reset();
                const kel = form.querySelector('#kelas-select-tambah');
                const ujn = form.querySelector('#ujian-select-tambah');
                if (kel) { kel.innerHTML = '<option value="">Pilih Sekolah Terlebih Dahulu</option>'; kel.disabled = true; }
                if (ujn) { ujn.innerHTML = '<option value="">Pilih Kelas Terlebih Dahulu</option>'; ujn.disabled = true; }
            }
        });
    });
});

function generateKodeAkses() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let result = '';
    for (let i = 0; i < 8; i++) result += chars.charAt(Math.floor(Math.random() * chars.length));
    document.querySelector('input[name="kode_akses"]').value = result;
}
</script>

<?= $this->endSection() ?>
