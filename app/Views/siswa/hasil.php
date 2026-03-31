<?= $this->extend('templates/siswa/siswa_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <span class="text-uppercase fw-bold text-primary small letter-spacing-2" style="letter-spacing: 2px;">Analisis</span>
            <h2 class="fw-bold text-dark">Riwayat Ujian</h2>
            <p class="text-muted">Pantau hasil dan progress kemampuan kognitif Anda.</p>
        </div>
    </div>

    <?php if (empty($riwayatUjian)): ?>
        <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
            <div class="card-body">
                <div class="icon-wrapper mx-auto mb-4" style="width: 80px; height: 80px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-clipboard-x fs-1 text-muted"></i>
                </div>
                <h5 class="text-muted">Anda belum mengikuti ujian apapun.</h5>
                <p class="text-muted mb-4">Mulai ujian terlebih dahulu untuk melihat hasil dan analisis.</p>
                <a href="<?= base_url('siswa/ujian') ?>" class="btn btn-primary px-4">
                    <i class="bi bi-journal-text me-1"></i> Ke Menu Ujian
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($riwayatUjian as $ujian): ?>
                <div class="col-xl-6">
                    <div class="card menu-card h-100 border-0 shadow-sm overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box p-3 rounded-3 me-3" style="background: #fffaf0; color: #d97706;">
                                        <i class="bi bi-check2-all fs-3"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1 text-dark"><?= esc($ujian['nama_ujian']) ?></h5>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-light text-dark border me-2 small fw-normal"><?= esc($ujian['nama_jenis']) ?></span>
                                            <span class="text-muted small"><i class="bi bi-hash"></i> <?= esc($ujian['kode_ujian']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-success rounded-pill px-3 py-2">Selesai</span>
                            </div>

                            <div class="stats-grid mb-4 p-3 rounded-3" style="background: #f8fafc;">
                                <div class="row text-center g-2">
                                    <div class="col-4 border-end">
                                        <div class="text-uppercase text-muted" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">Mulai</div>
                                        <div class="fw-bold text-dark small mt-1"><?= $ujian['waktu_mulai_format'] ?></div>
                                    </div>
                                    <div class="col-4 border-end">
                                        <div class="text-uppercase text-muted" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">Selesai</div>
                                        <div class="fw-bold text-dark small mt-1"><?= $ujian['waktu_selesai_format'] ?></div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-uppercase text-muted" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">Durasi</div>
                                        <div class="fw-bold text-primary small mt-1"><?= $ujian['durasi_format'] ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-6 border-end">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="bi bi-list-ol text-primary me-2"></i>
                                        <div>
                                            <div class="text-muted" style="font-size: 0.75rem;">Soal Dikerjakan</div>
                                            <div class="fw-bold text-dark"><?= $ujian['jumlah_soal'] ?> Soal</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="bi bi-alarm text-primary me-2"></i>
                                        <div>
                                            <div class="text-muted" style="font-size: 0.75rem;">Batas Waktu</div>
                                            <div class="fw-bold text-dark"><?= $ujian['durasi'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="<?= base_url('siswa/hasil/detail/' . $ujian['peserta_ujian_id']) ?>"
                                    class="btn btn-primary rounded-pill flex-fill fw-bold">
                                    <i class="bi bi-bar-chart-fill me-1"></i> Lihat Analisis Detail
                                </a>
                                <a href="<?= base_url('siswa/hasil/unduh/' . $ujian['peserta_ujian_id']) ?>"
                                    class="btn btn-outline-secondary rounded-pill fw-bold" target="_blank">
                                    <i class="bi bi-download me-1"></i> Sertifikat/Hasil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
  .hover-shadow {
    transition: all 0.3s ease;
  }

  .hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
  }
</style>

<?= $this->endSection() ?>
