<?= $this->extend('templates/siswa/siswa_template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <span class="text-uppercase fw-bold text-primary small letter-spacing-2" style="letter-spacing: 2px;">Evaluasi</span>
            <h2 class="fw-bold text-dark">Daftar Ujian Tersedia</h2>
            <p class="text-muted">Pilih ujian yang ingin Anda kerjakan di bawah ini.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($jadwalUjian)): ?>
        <div class="card border-0 shadow-sm rounded-4 py-5">
            <div class="card-body text-center">
                <div class="icon-wrapper mx-auto mb-4" style="width: 80px; height: 80px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-journal-x fs-1 text-muted"></i>
                </div>
                <h5 class="text-muted">Belum ada jadwal ujian yang tersedia untuk kelas Anda.</h5>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($jadwalUjian as $jadwal): ?>
                <div class="col-xl-4 col-md-6">
                    <div class="card menu-card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="icon-box p-3 rounded-3 mb-3" style="background: #f0f7ff; color: #0051ba;">
                                    <i class="bi bi-file-earmark-text fs-3"></i>
                                </div>
                                <?php
                                $statusClass = '';
                                $statusText = '';
                                if ($jadwal['status_peserta'] == 'sedang_mengerjakan') {
                                    $statusClass = 'bg-warning text-dark';
                                    $statusText = 'Sedang Mengerjakan';
                                } elseif ($jadwal['status_peserta'] == 'selesai') {
                                    $statusClass = 'bg-success';
                                    $statusText = 'Selesai';
                                } elseif ($jadwal['status_peserta'] == 'belum_mulai') {
                                    $statusClass = 'bg-info text-dark';
                                    $statusText = 'Belum Mulai';
                                }
                                if ($statusText): ?>
                                    <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2"><?= $statusText ?></span>
                                <?php endif; ?>
                            </div>

                            <h4 class="fw-bold mb-1"><?= esc($jadwal['nama_ujian']) ?></h4>
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-light text-dark border me-2"><?= esc($jadwal['kode_ujian']) ?></span>
                                <span class="text-muted small"><i class="bi bi-clock me-1"></i> <?= $jadwal['durasi'] ?></span>
                            </div>

                            <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 3em;">
                                <?= esc($jadwal['deskripsi']) ?>
                            </p>

                            <div class="info-list mb-4 p-3 rounded-3" style="background: #f8fafc;">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar-event text-primary me-2"></i>
                                    <span class="small text-dark"><strong>Mulai:</strong> <?= date('d M Y H:i', strtotime($jadwal['tanggal_mulai'])) ?></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-x text-danger me-2"></i>
                                    <span class="small text-dark"><strong>Selesai:</strong> <?= date('d M Y H:i', strtotime($jadwal['tanggal_selesai'])) ?></span>
                                </div>
                            </div>

                            <?php if ($jadwal['status'] == 'sedang_berlangsung'): ?>
                                <?php if ($jadwal['status_peserta'] == 'sedang_mengerjakan'): ?>
                                    <a href="<?= base_url('siswa/ujian/soal/' . $jadwal['jadwal_id']) ?>"
                                        class="btn btn-warning w-100 rounded-pill fw-bold">
                                        <i class="bi bi-play-fill me-1"></i> Lanjutkan Ujian
                                    </a>
                                <?php elseif ($jadwal['status_peserta'] == 'selesai'): ?>
                                    <button class="btn btn-success w-100 rounded-pill fw-bold" disabled>
                                        <i class="bi bi-check-circle-fill me-1"></i> Ujian Selesai
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-primary w-100 rounded-pill fw-bold"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalKodeAkses"
                                        data-jadwal-id="<?= $jadwal['jadwal_id'] ?>">
                                        <i class="bi bi-pencil-square me-1"></i> Mulai Ujian
                                    </button>
                                <?php endif; ?>
                            <?php elseif ($jadwal['status'] == 'belum_mulai'): ?>
                                <button class="btn btn-secondary w-100 rounded-pill fw-bold" disabled>
                                    <i class="bi bi-lock-fill me-1"></i> Belum Dimulai
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Kode Akses -->
<div class="modal fade" id="modalKodeAkses" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masukkan Kode Akses Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('siswa/ujian/mulai') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="jadwal_id" id="jadwalId">
                    <div class="form-group">
                        <label for="kodeAkses" class="form-label">Kode Akses:</label>
                        <input type="text" class="form-control form-control-lg text-center"
                            id="kodeAkses" name="kode_akses"
                            maxlength="20" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Mulai Ujian</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('modalKodeAkses').addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var jadwalId = button.getAttribute('data-jadwal-id');
        document.getElementById('jadwalId').value = jadwalId;
    });
</script>
<?= $this->endSection() ?>