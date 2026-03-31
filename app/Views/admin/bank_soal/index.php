<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Bank Soal</p>
            <h1 class="pg-title">Kelola Bank Soal</h1>
            <p class="pg-sub">Kelola semua bank soal yang tersedia dalam sistem CONCERTO.</p>
        </div>
        <button type="button" class="btn-pg-action" data-bs-toggle="modal" data-bs-target="#modalTambahBankSoal">
            <i class="bi bi-plus-lg"></i> Tambah Bank Soal
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
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert-pg alert-pg--danger" style="align-items:flex-start">
            <i class="bi bi-exclamation-circle-fill me-2" style="margin-top:2px;flex-shrink:0"></i>
            <ul class="mb-0 ps-1">
                <?php foreach (session()->getFlashdata('errors') as $error): ?><li><?= $error ?></li><?php endforeach; ?>
            </ul>
            <button class="alert-pg-close" data-bs-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <div class="row g-3">
        <?php if (!empty($kategoriList)): ?>
            <?php foreach ($kategoriList as $kategori): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="kat-card">
                        <div class="kat-card-top">
                            <div class="kat-icon">
                                <i class="bi <?= $kategori['kategori'] === 'umum' ? 'bi-globe2' : 'bi-mortarboard' ?>"></i>
                            </div>
                            <div class="dropdown ms-auto">
                                <button class="act-btn" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:10px;font-size:.85rem">
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('admin/bank-soal/kategori/' . urlencode($kategori['kategori'])) ?>">
                                            <i class="bi bi-eye me-2"></i>Lihat Detail
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item btn-edit-kategori"
                                            data-bs-toggle="modal" data-bs-target="#editKategoriModal"
                                            data-kategori-name="<?= esc($kategori['kategori']) ?>">
                                            <i class="bi bi-pencil me-2"></i>Edit Kategori
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="<?= base_url('admin/bank-soal/hapus-kategori/' . urlencode($kategori['kategori'])) ?>"
                                            onclick="return confirm('PERHATIAN! Anda akan menghapus kategori \'<?= esc($kategori['kategori']) ?>\' dan SEMUA bank ujian di dalamnya. Aksi ini tidak dapat dibatalkan. Lanjutkan?')">
                                            <i class="bi bi-trash me-2"></i>Hapus Kategori
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="kat-card-body">
                            <h5 class="kat-title">
                                <?= $kategori['kategori'] === 'umum' ? 'Bank Soal Umum' : 'Bank Soal Kelas ' . esc($kategori['kategori']) ?>
                            </h5>
                            <p class="kat-count"><?= $kategori['jumlah_bank'] ?> bank ujian tersedia</p>
                        </div>
                        <div class="kat-card-footer">
                            <a href="<?= base_url('admin/bank-soal/kategori/' . urlencode($kategori['kategori'])) ?>" class="kat-link">
                                Kelola Kategori <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="tbl-card">
                    <div class="tbl-empty">
                        <i class="bi bi-database"></i>
                        <p>Belum ada bank soal</p>
                        <button type="button" class="btn-pg-action btn-pg-action--sm" data-bs-toggle="modal" data-bs-target="#modalTambahBankSoal">
                            <i class="bi bi-plus-lg"></i> Tambah Bank Soal
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Modal Tambah Bank Soal -->
<div class="modal fade" id="modalTambahBankSoal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none;border-radius:14px;box-shadow:0 12px 40px rgba(15,23,42,.12)">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" style="font-size:1rem;color:#0f172a">Tambah Bank Soal Baru</h5>
                    <p style="font-size:.8rem;color:#9ca3af;margin:2px 0 0">Buat kategori dan bank ujian baru</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/bank-soal/tambah') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body pt-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="f-label">Kategori Bank Soal <span class="f-req">*</span></label>
                            <input type="text" class="f-input" name="kategori"
                                placeholder="Contoh: umum, Kelas X IPA 1, dll" required>
                            <p class="f-hint">Masukkan nama kategori (umum untuk akses semua guru)</p>
                        </div>
                        <div class="col-12">
                            <label class="f-label">Mata Pelajaran <span class="f-req">*</span></label>
                            <select class="f-input" name="jenis_ujian_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                <?php foreach ($jenisUjianList as $jenis): ?>
                                    <option value="<?= $jenis['jenis_ujian_id'] ?>"><?= esc($jenis['nama_jenis']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="f-label">Nama Bank Ujian <span class="f-req">*</span></label>
                            <input type="text" class="f-input" name="nama_ujian"
                                placeholder="Contoh: Ujian Tengah Semester Ganjil 2024" required>
                        </div>
                        <div class="col-12">
                            <label class="f-label">Deskripsi <span class="f-req">*</span></label>
                            <textarea class="f-input" name="deskripsi" rows="3"
                                placeholder="Deskripsi bank soal..." required></textarea>
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

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editKategoriModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border:none;border-radius:14px;box-shadow:0 12px 40px rgba(15,23,42,.12)">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" style="font-size:1rem;color:#0f172a">Edit Nama Kategori</h5>
                    <p style="font-size:.8rem;color:#9ca3af;margin:2px 0 0">Perbarui nama kategori bank soal</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/bank-soal/edit-kategori') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="old_kategori_name" id="old_kategori_name">
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="f-label">Nama Kategori Baru <span class="f-req">*</span></label>
                        <input type="text" class="f-input" id="new_kategori_name" name="new_kategori_name" required>
                        <p class="f-hint">Mengubah nama ini akan memperbarui semua bank ujian dalam kategori ini.</p>
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
/* Kategori Card */
.kat-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:.75rem;transition:box-shadow .2s,transform .2s}
.kat-card:hover{box-shadow:0 8px 28px rgba(15,23,42,.09);transform:translateY(-2px)}
.kat-card-top{display:flex;align-items:center;gap:.75rem}
.kat-icon{width:44px;height:44px;border-radius:10px;background:rgba(0,81,186,.08);color:#0051ba;display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0}
.kat-card-body{}
.kat-title{font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:4px}
.kat-count{font-size:.82rem;color:#6b7280;margin:0}
.kat-card-footer{border-top:1px solid #f1f5f9;padding-top:.75rem}
.kat-link{font-size:.84rem;font-weight:600;color:#0051ba;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:gap .15s}
.kat-link:hover{color:#003d8f;gap:8px}
/* Act btn */
.act-btn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:6px;font-size:.85rem;border:1px solid #e2e8f0;background:#fff;color:#475569;cursor:pointer;transition:all .15s}
.act-btn:hover{background:#f0f5ff;border-color:#c7d7f5;color:#0051ba}
/* Empty state */
.tbl-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);overflow:hidden}
.tbl-empty{text-align:center;padding:3rem 1rem}
.tbl-empty i{font-size:2.5rem;display:block;margin-bottom:.75rem;color:#cbd5e1}
.tbl-empty p{color:#9ca3af;margin-bottom:1rem;font-size:.9rem}
/* Form */
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
    const editButtons = document.querySelectorAll('.btn-edit-kategori');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const kategoriName = this.getAttribute('data-kategori-name');
            document.getElementById('old_kategori_name').value = kategoriName;
            document.getElementById('new_kategori_name').value = kategoriName;
        });
    });

    const form = document.querySelector('#modalTambahBankSoal form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const deskripsi = document.getElementById('deskripsi') ? document.querySelector('[name="deskripsi"]').value : '';
            if (deskripsi && deskripsi.length < 10) {
                e.preventDefault();
                alert(`Deskripsi minimal 10 karakter. Saat ini: ${deskripsi.length} karakter`);
                return false;
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
