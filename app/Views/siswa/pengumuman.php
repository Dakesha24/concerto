<?= $this->extend('templates/siswa/siswa_template') ?>

<?= $this->section('content') ?>
<div class="container-fluid pengumuman-siswa-page">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header-card">
                <p class="page-kicker mb-2">Informasi</p>
                <h2 class="mb-1">Pengumuman</h2>
                <p class="mb-0 text-muted">Lihat informasi terbaru dari sistem, sekolah, dan guru.</p>
            </div>
        </div>
    </div>

    <div class="card announcement-shell border-0">
        <div class="card-body p-4">
            <?php if (empty($pengumuman)) : ?>
                <div class="empty-state text-center">
                    <div class="empty-icon mx-auto mb-3">
                        <i class="bi bi-megaphone"></i>
                    </div>
                    <h5 class="mb-2">Belum ada pengumuman</h5>
                    <p class="text-muted mb-0">Informasi terbaru akan tampil di halaman ini.</p>
                </div>
            <?php else : ?>
                <div class="timeline-list">
                    <?php foreach ($pengumuman as $p) : ?>
                        <?php
                        $isExpired = $p['tanggal_berakhir'] && strtotime($p['tanggal_berakhir']) < time();
                        $badgeClass = $isExpired ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success';
                        $lineClass = $isExpired ? 'timeline-card-expired' : 'timeline-card-active';
                        ?>
                        <div class="timeline-item">
                            <div class="card timeline-card <?= $lineClass ?> border-0">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3 flex-wrap">
                                        <div>
                                            <h5 class="mb-1"><?= esc($p['judul']) ?></h5>
                                            <div class="meta-inline">
                                                <span><i class="bi bi-person"></i> <?= esc($p['username']) ?></span>
                                                <span><i class="bi bi-calendar3"></i> <?= date('d M Y H:i', strtotime($p['tanggal_publish'])) ?></span>
                                            </div>
                                        </div>
                                        <span class="badge <?= $badgeClass ?> status-badge"><?= $isExpired ? 'Berakhir' : 'Aktif' ?></span>
                                    </div>

                                    <div class="announcement-content mb-3">
                                        <?= nl2br(esc($p['isi_pengumuman'])) ?>
                                    </div>

                                    <?php if ($p['tanggal_berakhir']) : ?>
                                        <div class="announcement-footer">
                                            <i class="bi bi-clock-history"></i>
                                            <span>Berakhir: <?= date('d M Y H:i', strtotime($p['tanggal_berakhir'])) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .pengumuman-siswa-page .page-kicker {
        color: #0051ba;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .page-header-card {
        background: linear-gradient(180deg, #f7fbff 0%, #edf5ff 100%);
        color: #0f172a;
        padding: 2rem;
        border-radius: 0.8rem;
        border: 1px solid rgba(0, 81, 186, 0.12);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
    }

    .page-header-card .text-muted {
        color: #64748b !important;
    }

    .announcement-shell {
        border-radius: 0.75rem;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
        background: #fff;
    }

    .timeline-list {
        position: relative;
        display: grid;
        gap: 1rem;
        padding-left: 1.4rem;
    }

    .timeline-list::before {
        content: '';
        position: absolute;
        left: 0.35rem;
        top: 0.4rem;
        bottom: 0.4rem;
        width: 2px;
        background: #dbe7f5;
    }

    .timeline-item {
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.35rem;
        top: 1.35rem;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #0051ba;
        box-shadow: 0 0 0 4px #eaf3ff;
    }

    .timeline-card {
        border-radius: 0.75rem;
        border-left: 4px solid transparent !important;
        box-shadow: 0 8px 16px rgba(15, 23, 42, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .timeline-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 22px rgba(15, 23, 42, 0.07);
    }

    .timeline-card-active {
        border-left-color: #16a34a !important;
    }

    .timeline-card-expired {
        border-left-color: #dc2626 !important;
    }

    .meta-inline {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        color: #64748b;
        font-size: 0.88rem;
    }

    .meta-inline span,
    .announcement-footer {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .announcement-content {
        color: #334155;
        line-height: 1.7;
    }

    .announcement-footer {
        color: #64748b;
        font-size: 0.88rem;
        padding-top: 0.9rem;
        border-top: 1px solid #eef2f7;
    }

    .status-badge {
        border-radius: 999px;
        padding: 0.55rem 0.85rem;
        font-weight: 600;
    }

    .empty-state {
        padding: 3rem 1rem;
    }

    .empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #f8fbff;
        color: #0051ba;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        border: 1px solid rgba(0, 81, 186, 0.08);
    }

    @media (max-width: 767.98px) {
        .page-header-card {
            padding: 1.5rem;
        }

        .timeline-list {
            padding-left: 1rem;
        }

        .timeline-item::before {
            left: -0.95rem;
        }
    }
</style>
<?= $this->endSection() ?>
