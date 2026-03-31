<?= $this->extend('templates/siswa/siswa_template') ?>

<?= $this->section('content') ?>
<div class="container-fluid profil-siswa-page">
    <div class="row mb-4">
        <div class="col">
            <div class="profile-header-card">
                <p class="profile-kicker mb-2">Dashboard Siswa</p>
                <h2 class="mb-1">Profil Siswa</h2>
                <p class="mb-0 text-muted">Lengkapi identitas Anda agar data ujian dan kelas tetap sinkron.</p>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card profile-main-card border-0">
                <div class="card-header profile-card-header">
                    <h5 class="card-title mb-0">Data Siswa</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('siswa/profil/save') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nomor_peserta" class="form-label">NIS <span class="text-danger">*</span></label>
                                <input type="text" class="form-control profile-input" id="nomor_peserta" name="nomor_peserta"
                                    value="<?= old('nomor_peserta', isset($siswa['nomor_peserta']) ? $siswa['nomor_peserta'] : '') ?>" required>
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('errors')['nomor_peserta'] ?? '' ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control profile-input" id="nama_lengkap" name="nama_lengkap"
                                    value="<?= old('nama_lengkap', isset($siswa['nama_lengkap']) ? $siswa['nama_lengkap'] : '') ?>" required>
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('errors')['nama_lengkap'] ?? '' ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select profile-input" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki"
                                        <?= old('jenis_kelamin', isset($siswa['jenis_kelamin']) ? $siswa['jenis_kelamin'] : '') == 'Laki-laki' ? 'selected' : '' ?>>
                                        Laki-laki
                                    </option>
                                    <option value="Perempuan"
                                        <?= old('jenis_kelamin', isset($siswa['jenis_kelamin']) ? $siswa['jenis_kelamin'] : '') == 'Perempuan' ? 'selected' : '' ?>>
                                        Perempuan
                                    </option>
                                </select>
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('errors')['jenis_kelamin'] ?? '' ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label for="sekolah_id" class="form-label">Sekolah <span class="text-danger">*</span></label>
                                <select class="form-select profile-input" id="sekolah_id" name="sekolah_id" required>
                                    <option value="">Pilih Sekolah</option>
                                    <?php foreach ($sekolah as $s): ?>
                                        <option value="<?= $s['sekolah_id'] ?>"
                                            <?= old('sekolah_id', isset($siswa['sekolah_id']) ? $siswa['sekolah_id'] : '') == $s['sekolah_id'] ? 'selected' : '' ?>>
                                            <?= $s['nama_sekolah'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('errors')['sekolah_id'] ?? '' ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-12">
                                <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                                <select class="form-select profile-input" id="kelas_id" name="kelas_id" required disabled>
                                    <option value="">Pilih Sekolah Terlebih Dahulu</option>
                                </select>
                                <div class="spinner-border spinner-border-sm text-primary d-none mt-2" id="kelas-loading" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session()->getFlashdata('errors')['kelas_id'] ?? '' ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn profile-save-btn">
                                <i class="bi bi-save me-1"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card profile-side-card border-0">
                <div class="card-body p-4">
                    <p class="profile-kicker mb-2">Informasi</p>
                    <h5 class="mb-3">Catatan Pengisian</h5>
                    <div class="info-item">
                        Gunakan nama lengkap yang sesuai dengan data sekolah.
                    </div>
                    <div class="info-item">
                        Pastikan sekolah dan kelas dipilih dengan benar sebelum menyimpan.
                    </div>
                    <div class="info-item mb-0">
                        Perubahan data akan digunakan pada proses ujian dan pelaporan hasil.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profil-siswa-page .profile-kicker {
        color: #0051ba;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .profile-header-card {
        background: white;
        color: #0f172a;
        padding: 2rem;
        border-radius: 0.8rem;
        border: 1px solid rgba(0, 81, 186, 0.12);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        position: relative;
        overflow: hidden;
    }

    .profile-header-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(0,81,186,.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0,81,186,.04) 1px, transparent 1px);
        background-size: 42px 42px;
        pointer-events: none;
    }

    .profile-header-card h2,
    .profile-header-card p {
        position: relative;
        z-index: 1;
    }

    .profile-header-card .profile-kicker {
        color: #0051ba;
    }

    .profile-header-card .text-muted {
        color: #64748b !important;
    }

    .profile-main-card,
    .profile-side-card {
        border-radius: 0.75rem;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
        background: #fff;
    }

    .profile-card-header {
        background: linear-gradient(180deg, #f8fbff 0%, #f2f7ff 100%);
        border-bottom: 1px solid rgba(0, 81, 186, 0.08);
        padding: 1.1rem 1.5rem;
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }

    .profile-card-header .card-title {
        color: #001a4f;
        font-weight: 700;
    }

    .profile-input {
        min-height: 50px;
        border-radius: 0.65rem;
        border: 1px solid #d9e4f2;
        background: #fbfdff;
        padding: 0.8rem 1rem;
    }

    .profile-input:focus {
        border-color: #0051ba;
        box-shadow: 0 0 0 0.25rem rgba(0, 81, 186, 0.12);
        background: #fff;
    }

    .profile-save-btn {
        background: linear-gradient(135deg, #0051ba 0%, #003d8f 100%);
        color: #fff;
        border: 0;
        padding: 0.8rem 1.4rem;
        border-radius: 999px;
        font-weight: 600;
        box-shadow: 0 10px 24px rgba(0, 81, 186, 0.2);
    }

    .profile-save-btn:hover {
        color: #fff;
        transform: translateY(-1px);
    }

    .info-item {
        padding: 0.9rem 1rem;
        background: #f8fbff;
        border: 1px solid rgba(0, 81, 186, 0.08);
        border-radius: 0.65rem;
        color: #475569;
        line-height: 1.65;
        margin-bottom: 0.85rem;
    }

    @media (max-width: 991.98px) {
        .profile-header-card {
            padding: 1.6rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sekolahSelect = document.getElementById('sekolah_id');
        const kelasSelect = document.getElementById('kelas_id');
        const kelasLoading = document.getElementById('kelas-loading');

        const currentSekolahId = '<?= old('sekolah_id', isset($siswa['sekolah_id']) ? $siswa['sekolah_id'] : '') ?>';
        const currentKelasId = '<?= old('kelas_id', isset($siswa['kelas_id']) ? $siswa['kelas_id'] : '') ?>';

        sekolahSelect.addEventListener('change', function() {
            const sekolahId = this.value;

            if (sekolahId) {
                loadKelas(sekolahId);
            } else {
                resetKelasSelect();
            }
        });

        if (currentSekolahId) {
            loadKelas(currentSekolahId, currentKelasId);
        }

        function loadKelas(sekolahId, selectedKelasId = null) {
            kelasLoading.classList.remove('d-none');
            kelasSelect.disabled = true;
            kelasSelect.innerHTML = '<option value="">Loading...</option>';

            fetch(`<?= base_url('siswa/api/kelas-by-sekolah') ?>/${sekolahId}`)
                .then(response => response.json())
                .then(data => {
                    kelasLoading.classList.add('d-none');
                    kelasSelect.disabled = false;

                    if (data.success) {
                        kelasSelect.innerHTML = '<option value="">Pilih Kelas</option>';

                        data.kelas.forEach(kelas => {
                            const option = document.createElement('option');
                            option.value = kelas.kelas_id;
                            option.textContent = kelas.nama_kelas;

                            if (selectedKelasId && selectedKelasId == kelas.kelas_id) {
                                option.selected = true;
                            }

                            kelasSelect.appendChild(option);
                        });
                    } else {
                        kelasSelect.innerHTML = '<option value="">Tidak ada kelas tersedia</option>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    kelasLoading.classList.add('d-none');
                    kelasSelect.disabled = false;
                    kelasSelect.innerHTML = '<option value="">Error memuat data kelas</option>';
                });
        }

        function resetKelasSelect() {
            kelasSelect.disabled = true;
            kelasSelect.innerHTML = '<option value="">Pilih Sekolah Terlebih Dahulu</option>';
        }
    });
</script>

<?= $this->endSection() ?>
