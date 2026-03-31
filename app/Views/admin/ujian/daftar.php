<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Kelola Konten</p>
            <h1 class="pg-title">Kelola Ujian</h1>
            <p class="pg-sub">Buat dan kelola ujian beserta pengaturan CONCERTO untuk kelas yang Anda ajar.</p>
        </div>
        <button type="button" class="btn-pg-action" data-bs-toggle="modal" data-bs-target="#tambahUjianModal">
            <i class="bi bi-plus-lg"></i> Tambah Ujian
        </button>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-pg alert-pg--success">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
            <button class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-pg alert-pg--danger" style="align-items:flex-start">
            <i class="bi bi-exclamation-circle-fill me-2" style="margin-top:2px;flex-shrink:0"></i>
            <div>
                <?php
                $errors = session()->getFlashdata('error');
                if (is_array($errors)) {
                    echo '<ul class="mb-0 ps-1">';
                    foreach ($errors as $error) {
                        echo '<li>' . esc($error) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo esc($errors);
                }
                ?>
            </div>
            <button class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <div class="row g-3">
        <?php if (!empty($ujian)): ?>
            <?php foreach ($ujian as $u): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="u-card">
                        <div class="u-card-top">
                            <div class="u-icon"><i class="bi bi-file-earmark-text"></i></div>
                            <div class="u-meta">
                                <span class="pg-badge"><?= isset($u['nama_jenis']) ? esc($u['nama_jenis']) : 'Mata Pelajaran tidak ditemukan' ?></span>
                                <?php if (!empty($u['nama_kelas'])): ?>
                                    <span class="u-kelas"><i class="bi bi-mortarboard me-1"></i><?= esc($u['nama_kelas']) ?></span>
                                <?php else: ?>
                                    <span class="u-kelas" style="color:#9ca3af"><i class="bi bi-globe me-1"></i>Umum</span>
                                <?php endif; ?>
                            </div>
                            <div class="dropdown ms-auto">
                                <button class="act-btn" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:10px;font-size:.85rem">
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editUjianModal<?= $u['id_ujian'] ?>">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </button>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('admin/soal/' . $u['id_ujian']) ?>">
                                            <i class="bi bi-list-task me-2"></i>Kelola Soal
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="<?= base_url('admin/ujian/hapus/' . $u['id_ujian']) ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus ujian ini?')">
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="u-card-body">
                            <h5 class="u-title"><?= esc($u['nama_ujian']) ?></h5>
                            <?php if (!empty($u['kode_ujian'])): ?>
                                <p class="u-kode"><i class="bi bi-key me-1"></i>Kode: <strong><?= esc($u['kode_ujian']) ?></strong></p>
                            <?php endif; ?>
                            <p class="u-desc"><?= esc($u['deskripsi']) ?></p>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <div class="stat-mini">
                                        <span class="stat-mini-val"><?= esc($u['durasi']) ?></span>
                                        <span class="stat-mini-label">Durasi</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-mini">
                                        <span class="stat-mini-val"><?= esc($u['se_awal']) ?></span>
                                        <span class="stat-mini-label">SE Awal</span>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($u['guru_pembuat'])): ?>
                                <p class="u-creator"><i class="bi bi-person me-1"></i>Dibuat oleh: <?= esc($u['guru_pembuat']) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="u-card-footer">
                            <a href="<?= base_url('admin/soal/' . $u['id_ujian']) ?>" class="kat-link">
                                <i class="bi bi-list-task me-1"></i>Kelola Soal <i class="bi bi-arrow-right ms-1"></i>
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
                        <p>Belum ada ujian</p>
                        <button type="button" class="btn-pg-action btn-pg-action--sm" data-bs-toggle="modal" data-bs-target="#tambahUjianModal">
                            <i class="bi bi-plus-lg"></i> Tambah Ujian
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Modal Tambah Ujian -->
<div class="modal fade" id="tambahUjianModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none;border-radius:14px;box-shadow:0 12px 40px rgba(15,23,42,.12)">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" style="font-size:1rem;color:#0f172a">Tambah Ujian</h5>
                    <p style="font-size:.8rem;color:#9ca3af;margin:2px 0 0">Isi detail ujian baru</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/ujian/tambah') ?>" method="post" id="formTambahUjian">
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
                            <label class="f-label">Kelas</label>
                            <select id="kelas-select-tambah" class="f-input" name="kelas_id" disabled>
                                <option value="">Pilih Sekolah Terlebih Dahulu</option>
                            </select>
                            <p class="f-hint">Jika tidak dipilih, ujian akan bersifat umum.</p>
                        </div>
                        <div class="col-12">
                            <label class="f-label">Mata Pelajaran <span class="f-req">*</span></label>
                            <select name="jenis_ujian_id" class="f-input" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                <?php if (!empty($jenis_ujian)): ?>
                                    <?php foreach ($jenis_ujian as $ju): ?>
                                        <option value="<?= $ju['jenis_ujian_id'] ?>">
                                            <?= esc($ju['nama_jenis']) ?>
                                            <?php if (!empty($ju['nama_kelas'])): ?> - <?= esc($ju['nama_kelas']) ?><?php endif; ?>
                                            <?php if (!empty($ju['nama_sekolah'])): ?> (<?= esc($ju['nama_sekolah']) ?>)<?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="f-label">Nama Ujian <span class="f-req">*</span></label>
                            <input type="text" name="nama_ujian" class="f-input" placeholder="Contoh: UTS Fisika Semester 1" required>
                        </div>
                        <div class="col-12">
                            <label class="f-label">Kode Ujian <span class="f-req">*</span></label>
                            <input type="text" name="kode_ujian" class="f-input" placeholder="Contoh: FIS_UTS_2025_01" required>
                            <p class="f-hint">Kode unik untuk ujian ini (digunakan untuk identifikasi).</p>
                        </div>
                        <div class="col-12">
                            <label class="f-label">Deskripsi <span class="f-req">*</span></label>
                            <textarea name="deskripsi" class="f-input" rows="3" placeholder="Deskripsi ujian..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="f-label">Durasi (HH:MM:SS) <span class="f-req">*</span></label>
                            <input type="time" name="durasi" class="f-input" step="1" value="01:30:00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="f-label">SE Awal <span class="f-req">*</span></label>
                            <input type="number" name="se_awal" class="f-input" step="0.0001" value="1.0000" required>
                            <p class="f-hint">Standard Error awal</p>
                        </div>
                        <div class="col-md-6">
                            <label class="f-label">SE Minimum <span class="f-req">*</span></label>
                            <input type="number" name="se_minimum" class="f-input" step="0.0001" value="0.2500" required>
                            <p class="f-hint">Batas SE minimum</p>
                        </div>
                        <div class="col-md-6">
                            <label class="f-label">Delta SE Minimum <span class="f-req">*</span></label>
                            <input type="number" name="delta_se_minimum" class="f-input" step="0.0001" value="0.0100" required>
                            <p class="f-hint">Perubahan SE minimum</p>
                        </div>
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

<!-- Modal Edit Ujian -->
<?php if (!empty($ujian)): ?>
    <?php foreach ($ujian as $u): ?>
        <div class="modal fade" id="editUjianModal<?= $u['id_ujian'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border:none;border-radius:14px;box-shadow:0 12px 40px rgba(15,23,42,.12)">
                    <div class="modal-header border-0 pb-0">
                        <div>
                            <h5 class="modal-title fw-bold" style="font-size:1rem;color:#0f172a">Edit Ujian</h5>
                            <p style="font-size:.8rem;color:#9ca3af;margin:2px 0 0"><?= esc($u['nama_ujian']) ?></p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?= base_url('admin/ujian/edit/' . $u['id_ujian']) ?>" method="post">
                        <div class="modal-body pt-3">
                            <div class="info-box mb-3">
                                <strong>Nama:</strong> <?= esc($u['nama_ujian']) ?> &nbsp;&middot;&nbsp;
                                <strong>Kode:</strong> <?= esc($u['kode_ujian']) ?>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="f-label">Sekolah <span class="f-req">*</span></label>
                                    <select class="f-input sekolah-select-edit" name="sekolah_id" data-ujian-id="<?= $u['id_ujian'] ?>" required>
                                        <option value="">Pilih Sekolah</option>
                                        <?php if (!empty($sekolah)): ?>
                                            <?php foreach ($sekolah as $s): ?>
                                                <option value="<?= $s['sekolah_id'] ?>"
                                                    <?= (isset($u['sekolah_id']) && $u['sekolah_id'] == $s['sekolah_id']) ? 'selected' : '' ?>>
                                                    <?= esc($s['nama_sekolah']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-label">Kelas</label>
                                    <select class="f-input kelas-select-edit" name="kelas_id" data-ujian-id="<?= $u['id_ujian'] ?>">
                                        <option value="">Pilih Kelas (Kosongkan untuk umum)</option>
                                        <?php if (!empty($kelas_guru)): ?>
                                            <?php foreach ($kelas_guru as $kelas): ?>
                                                <option value="<?= $kelas['kelas_id'] ?>"
                                                    <?= (isset($u['kelas_id']) && $u['kelas_id'] == $kelas['kelas_id']) ? 'selected' : '' ?>>
                                                    <?= esc($kelas['nama_kelas']) ?>
                                                    <?php if (!empty($kelas['nama_sekolah'])): ?> - <?= esc($kelas['nama_sekolah']) ?><?php endif; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <p class="f-hint">Jika tidak dipilih, ujian akan bersifat umum</p>
                                </div>
                                <div class="col-12">
                                    <label class="f-label">Mata Pelajaran <span class="f-req">*</span></label>
                                    <select name="jenis_ujian_id" class="f-input" required>
                                        <?php if (!empty($jenis_ujian)): ?>
                                            <?php foreach ($jenis_ujian as $ju): ?>
                                                <option value="<?= $ju['jenis_ujian_id'] ?>"
                                                    <?= $ju['jenis_ujian_id'] == $u['jenis_ujian_id'] ? 'selected' : '' ?>>
                                                    <?= esc($ju['nama_jenis']) ?>
                                                    <?php if (!empty($ju['nama_kelas'])): ?> - <?= esc($ju['nama_kelas']) ?><?php endif; ?>
                                                    <?php if (!empty($ju['nama_sekolah'])): ?> (<?= esc($ju['nama_sekolah']) ?>)<?php endif; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="f-label">Nama Ujian <span class="f-req">*</span></label>
                                    <input type="text" name="nama_ujian" class="f-input" value="<?= esc($u['nama_ujian']) ?>" required>
                                </div>
                                <div class="col-12">
                                    <label class="f-label">Kode Ujian <span class="f-req">*</span></label>
                                    <input type="text" name="kode_ujian" class="f-input" value="<?= esc($u['kode_ujian']) ?>" required>
                                    <p class="f-hint">Kode unik untuk ujian ini.</p>
                                </div>
                                <div class="col-12">
                                    <label class="f-label">Deskripsi <span class="f-req">*</span></label>
                                    <textarea name="deskripsi" class="f-input" rows="3" required><?= esc($u['deskripsi']) ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-label">Durasi (HH:MM:SS) <span class="f-req">*</span></label>
                                    <input type="time" name="durasi" class="f-input" step="1" value="<?= esc($u['durasi']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-label">SE Awal <span class="f-req">*</span></label>
                                    <input type="number" name="se_awal" class="f-input" step="0.0001" value="<?= esc($u['se_awal']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-label">SE Minimum <span class="f-req">*</span></label>
                                    <input type="number" name="se_minimum" class="f-input" step="0.0001" value="<?= esc($u['se_minimum']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="f-label">Delta SE Minimum <span class="f-req">*</span></label>
                                    <input type="number" name="delta_se_minimum" class="f-input" step="0.0001" value="<?= esc($u['delta_se_minimum']) ?>" required>
                                </div>
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
/* Ujian Card */
.u-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:.75rem;transition:box-shadow .2s,transform .2s}
.u-card:hover{box-shadow:0 8px 28px rgba(15,23,42,.09);transform:translateY(-2px)}
.u-card-top{display:flex;align-items:flex-start;gap:.75rem}
.u-icon{width:40px;height:40px;border-radius:9px;background:rgba(0,81,186,.08);color:#0051ba;display:inline-flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;margin-top:2px}
.u-meta{display:flex;flex-direction:column;gap:3px;flex:1;min-width:0}
.pg-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:rgba(0,81,186,.07);color:#0051ba;width:fit-content}
.u-kelas{font-size:.76rem;color:#0051ba}
.u-card-body{}
.u-title{font-size:.95rem;font-weight:700;color:#0f172a;margin-bottom:3px;line-height:1.3}
.u-kode{font-size:.78rem;color:#6b7280;margin-bottom:4px}
.u-desc{font-size:.82rem;color:#6b7280;margin-bottom:.75rem;line-height:1.5;overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2}
.u-creator{font-size:.76rem;color:#9ca3af;margin:4px 0 0}
.u-card-footer{border-top:1px solid #f1f5f9;padding-top:.75rem}
.kat-link{font-size:.84rem;font-weight:600;color:#0051ba;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:gap .15s}
.kat-link:hover{color:#003d8f;gap:8px}
.stat-mini{display:flex;flex-direction:column;align-items:center;padding:.5rem;background:#f8fafc;border-radius:8px;border:1px solid #f1f5f9}
.stat-mini-val{font-size:.88rem;font-weight:700;color:#0f172a;line-height:1}
.stat-mini-label{font-size:.7rem;color:#9ca3af;margin-top:2px}
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
    const kelasSelectTambah = document.getElementById('kelas-select-tambah');
    const jenisUjianSelectTambah = document.querySelector('#tambahUjianModal select[name="jenis_ujian_id"]');

    if (sekolahSelectTambah && kelasSelectTambah) {
        sekolahSelectTambah.addEventListener('change', function() {
            handleSekolahChange(this, kelasSelectTambah);
        });
    }

    if (kelasSelectTambah && jenisUjianSelectTambah) {
        kelasSelectTambah.addEventListener('change', function() {
            handleKelasChange(this, jenisUjianSelectTambah);
        });
    }

    const sekolahSelectsEdit = document.querySelectorAll('.sekolah-select-edit');
    sekolahSelectsEdit.forEach(function(sekolahSelect) {
        const ujianId = sekolahSelect.dataset.ujianId;
        const kelasSelect = document.querySelector(`.kelas-select-edit[data-ujian-id="${ujianId}"]`);
        const jenisUjianSelect = sekolahSelect.closest('form').querySelector('select[name="jenis_ujian_id"]');

        if (kelasSelect) {
            sekolahSelect.addEventListener('change', function() {
                handleSekolahChange(this, kelasSelect);
            });
        }

        if (kelasSelect && jenisUjianSelect) {
            kelasSelect.addEventListener('change', function() {
                handleKelasChange(this, jenisUjianSelect);
            });
        }
    });

    function handleSekolahChange(sekolahSelect, kelasSelect) {
        const sekolahId = sekolahSelect.value;
        kelasSelect.innerHTML = '<option value="">Memuat kelas...</option>';
        kelasSelect.disabled = true;

        const jenisUjianSelect = sekolahSelect.closest('.modal').querySelector('select[name="jenis_ujian_id"]');
        if (jenisUjianSelect) resetJenisUjianSelect(jenisUjianSelect);

        if (!sekolahId) {
            kelasSelect.innerHTML = '<option value="">Pilih Sekolah Terlebih Dahulu</option>';
            return;
        }

        fetch(`<?= base_url('admin/api/kelas-by-sekolah/') ?>${sekolahId}`)
            .then(response => response.json())
            .then(responseData => {
                kelasSelect.innerHTML = '';
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Pilih Kelas (Kosongkan untuk umum)';
                kelasSelect.appendChild(defaultOption);

                if (responseData.status === 'success' && Array.isArray(responseData.data)) {
                    if (responseData.data.length > 0) {
                        responseData.data.forEach(kelas => {
                            const option = document.createElement('option');
                            option.value = kelas.kelas_id;
                            option.textContent = kelas.nama_kelas;
                            kelasSelect.appendChild(option);
                        });
                    } else {
                        const noData = document.createElement('option');
                        noData.value = '';
                        noData.textContent = 'Tidak ada kelas tersedia';
                        noData.disabled = true;
                        kelasSelect.appendChild(noData);
                    }
                }
                kelasSelect.disabled = false;
            })
            .catch(() => {
                kelasSelect.innerHTML = '<option value="">Gagal memuat kelas</option>';
                kelasSelect.disabled = false;
            });
    }

    function handleKelasChange(kelasSelect, jenisUjianSelect) {
        const kelasId = kelasSelect.value;
        jenisUjianSelect.innerHTML = '<option value="">Memuat mata pelajaran...</option>';
        jenisUjianSelect.disabled = true;

        if (!kelasId) {
            resetJenisUjianSelect(jenisUjianSelect);
            jenisUjianSelect.disabled = false;
            return;
        }

        fetch(`<?= base_url('admin/api/jenis-ujian-by-kelas/') ?>${kelasId}`)
            .then(response => response.json())
            .then(responseData => {
                jenisUjianSelect.innerHTML = '';
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Pilih Mata Pelajaran';
                jenisUjianSelect.appendChild(defaultOption);

                if (responseData.status === 'success' && Array.isArray(responseData.data)) {
                    if (responseData.data.length > 0) {
                        responseData.data.forEach(ju => {
                            const option = document.createElement('option');
                            option.value = ju.jenis_ujian_id;
                            let text = ju.nama_jenis;
                            if (ju.nama_kelas) text += ` - ${ju.nama_kelas}`;
                            else text += ' (Umum)';
                            if (ju.nama_sekolah) text += ` (${ju.nama_sekolah})`;
                            option.textContent = text;
                            jenisUjianSelect.appendChild(option);
                        });
                    } else {
                        const noData = document.createElement('option');
                        noData.value = '';
                        noData.textContent = 'Tidak ada mata pelajaran tersedia';
                        noData.disabled = true;
                        jenisUjianSelect.appendChild(noData);
                    }
                }
                jenisUjianSelect.disabled = false;
            })
            .catch(() => {
                jenisUjianSelect.innerHTML = '<option value="">Gagal memuat mata pelajaran</option>';
                jenisUjianSelect.disabled = false;
            });
    }

    function resetJenisUjianSelect(jenisUjianSelect) {
        jenisUjianSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
        <?php if (!empty($jenis_ujian)): ?>
            <?php foreach ($jenis_ujian as $ju): ?>
                <?php if (empty($ju['kelas_id'])): ?>
                    const option<?= $ju['jenis_ujian_id'] ?> = document.createElement('option');
                    option<?= $ju['jenis_ujian_id'] ?>.value = '<?= $ju['jenis_ujian_id'] ?>';
                    option<?= $ju['jenis_ujian_id'] ?>.textContent = '<?= esc($ju['nama_jenis']) ?> (Umum)';
                    jenisUjianSelect.appendChild(option<?= $ju['jenis_ujian_id'] ?>);
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    }

    const forms = document.querySelectorAll('form[id^="formTambahUjian"], form[action*="ujian/edit"]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let hasErrors = false;
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    field.style.borderColor = '#fca5a5';
                    hasErrors = true;
                } else {
                    field.style.borderColor = '';
                }
            });
            if (hasErrors) {
                e.preventDefault();
                const firstError = form.querySelector('[required]:not([value])');
                if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });

    document.addEventListener('input', function(e) {
        if (e.target.style.borderColor === 'rgb(252, 165, 165)' && e.target.value.trim()) {
            e.target.style.borderColor = '';
        }
    });

    const modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            const form = modal.querySelector('form');
            if (form && form.id === 'formTambahUjian') {
                form.reset();
                const kelasSelect = form.querySelector('#kelas-select-tambah');
                if (kelasSelect) {
                    kelasSelect.innerHTML = '<option value="">Pilih Sekolah Terlebih Dahulu</option>';
                    kelasSelect.disabled = true;
                }
                const jenisUjianSelect = form.querySelector('select[name="jenis_ujian_id"]');
                if (jenisUjianSelect) resetJenisUjianSelect(jenisUjianSelect);
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
