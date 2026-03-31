<?= $this->extend('templates/admin/admin_template') ?>

<?= $this->section('title') ?>Hasil Ujian<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Monitoring</p>
            <h1 class="pg-title">Hasil Ujian</h1>
            <p class="pg-sub">Pantau progress dan hasil ujian dari seluruh kelas.</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="<?= base_url('admin/ujian') ?>" class="btn-back">
                <i class="bi bi-file-earmark-text me-1"></i>Kelola Ujian
            </a>
            <a href="<?= base_url('admin/jadwal') ?>" class="btn-back">
                <i class="bi bi-calendar-event me-1"></i>Jadwal Ujian
            </a>
        </div>
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

    <!-- Legend -->
    <div class="legend-bar">
        <span class="pg-badge pg-badge--gray me-1">Belum Mulai</span> Ujian belum dimulai &nbsp;&nbsp;
        <span class="pg-badge pg-badge--yellow me-1">Sedang Berlangsung</span> Ujian sedang berlangsung &nbsp;&nbsp;
        <span class="pg-badge pg-badge--green me-1">Selesai</span> Ujian telah selesai
    </div>

    <?php if (empty($daftarUjian)): ?>
        <div class="tbl-card">
            <div class="tbl-empty">
                <i class="bi bi-bar-chart"></i>
                <p>Belum ada ujian terjadwal</p>
                <p style="font-size:.8rem;color:#9ca3af">Daftar ujian akan muncul setelah ada jadwal ujian yang dibuat.</p>
            </div>
        </div>
    <?php else: ?>
        <!-- Filter Bar -->
        <div class="filter-card">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="filter-label">Cari</label>
                    <input type="text" class="f-input" id="searchUjian" placeholder="Nama ujian...">
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Sekolah</label>
                    <select class="f-input" id="filterSekolah">
                        <option value="">Semua Sekolah</option>
                        <?php
                        $sekolahUnique = array_unique(array_filter(array_column($daftarUjian, 'nama_sekolah')));
                        foreach ($sekolahUnique as $sekolah): ?>
                            <option value="<?= esc($sekolah) ?>"><?= esc($sekolah) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Kelas</label>
                    <select class="f-input" id="filterKelas">
                        <option value="">Semua Kelas</option>
                        <?php
                        $kelasUnique = array_unique(array_filter(array_column($daftarUjian, 'nama_kelas')));
                        foreach ($kelasUnique as $kelas): ?>
                            <option value="<?= esc($kelas) ?>"><?= esc($kelas) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Status</label>
                    <select class="f-input" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="belum_mulai">Belum Mulai</option>
                        <option value="sedang_berlangsung">Sedang Berlangsung</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Mata Pelajaran</label>
                    <select class="f-input" id="filterMatpel">
                        <option value="">Semua</option>
                        <?php
                        $matpelUnique = array_unique(array_filter(array_column($daftarUjian, 'nama_jenis')));
                        foreach ($matpelUnique as $matpel): ?>
                            <option value="<?= esc($matpel) ?>"><?= esc($matpel) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn-reset w-100" onclick="resetFilter()" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-3" id="hasilGrid">
            <?php foreach ($daftarUjian as $ujian): ?>
                <div class="col-md-6 h-card-wrap"
                    data-sekolah="<?= esc($ujian['nama_sekolah']) ?>"
                    data-kelas="<?= esc($ujian['nama_kelas']) ?>"
                    data-status="<?= esc($ujian['status_ujian']) ?>"
                    data-matpel="<?= esc($ujian['nama_jenis']) ?>">
                    <div class="h-card">
                        <!-- Card Header: Sekolah & Status -->
                        <div class="h-card-header">
                            <div class="h-school-info">
                                <div class="h-school-icon"><i class="bi bi-building"></i></div>
                                <div>
                                    <p class="h-school-name"><?= esc($ujian['nama_sekolah']) ?></p>
                                    <p class="h-school-kelas">
                                        <i class="bi bi-people me-1"></i><?= esc($ujian['nama_kelas']) ?>
                                        <?php if ($ujian['tahun_ajaran']): ?> &middot; <?= esc($ujian['tahun_ajaran']) ?><?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            <span class="pg-badge <?= 'pg-badge--' . $ujian['status_class'] ?>"><?= $ujian['status_text'] ?></span>
                        </div>

                        <div class="h-card-body">
                            <!-- Judul & Mapel -->
                            <h5 class="h-title"><?= esc($ujian['nama_ujian']) ?></h5>
                            <span class="pg-badge" style="margin-bottom:.75rem;display:inline-block"><?= esc($ujian['nama_jenis']) ?></span>

                            <p class="h-desc"><?= strlen($ujian['deskripsi']) > 100 ? substr(esc($ujian['deskripsi']), 0, 100) . '…' : esc($ujian['deskripsi']) ?></p>

                            <!-- Waktu -->
                            <div class="h-time-row">
                                <div class="h-time-item">
                                    <span class="h-time-label"><i class="bi bi-calendar-check me-1"></i>Mulai</span>
                                    <span class="h-time-val"><?= $ujian['tanggal_mulai_format'] ?></span>
                                </div>
                                <div class="h-time-item">
                                    <span class="h-time-label"><i class="bi bi-calendar-x me-1"></i>Selesai</span>
                                    <span class="h-time-val"><?= $ujian['tanggal_selesai_format'] ?></span>
                                </div>
                            </div>

                            <?php if ($ujian['status_ujian'] !== 'selesai'): ?>
                                <div class="h-akses">
                                    <span class="h-time-label"><i class="bi bi-key me-1"></i>Kode Akses:</span>
                                    <span class="h-akses-val"><?= esc($ujian['kode_akses']) ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Statistik Peserta -->
                            <div class="h-stats">
                                <div class="h-stat">
                                    <span class="h-stat-val h-stat-green"><?= $ujian['peserta_selesai'] ?></span>
                                    <span class="h-stat-label">Selesai</span>
                                </div>
                                <div class="h-stat">
                                    <span class="h-stat-val h-stat-yellow"><?= $ujian['peserta_sedang_mengerjakan'] ?></span>
                                    <span class="h-stat-label">Aktif</span>
                                </div>
                                <div class="h-stat">
                                    <span class="h-stat-val" style="color:#6b7280"><?= $ujian['peserta_belum_mulai'] ?></span>
                                    <span class="h-stat-label">Belum</span>
                                </div>
                                <div class="h-stat">
                                    <span class="h-stat-val" style="color:#0051ba"><?= $ujian['jumlah_peserta'] ?></span>
                                    <span class="h-stat-label">Total</span>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <?php if ($ujian['jumlah_peserta'] > 0): ?>
                                <?php
                                $pSelesai = round(($ujian['peserta_selesai'] / $ujian['jumlah_peserta']) * 100);
                                $pAktif   = round(($ujian['peserta_sedang_mengerjakan'] / $ujian['jumlah_peserta']) * 100);
                                ?>
                                <div class="h-progress">
                                    <div style="height:6px;background:#f1f5f9;border-radius:4px;overflow:hidden;display:flex">
                                        <div style="width:<?= $pSelesai ?>%;background:#16a34a;transition:width .3s"></div>
                                        <div style="width:<?= $pAktif ?>%;background:#f59e0b;transition:width .3s"></div>
                                    </div>
                                    <p class="h-progress-label"><?= $pSelesai ?>% selesai<?= $pAktif ? ', ' . $pAktif . '% sedang mengerjakan' : '' ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Statistik Waktu -->
                            <?php if ($ujian['peserta_selesai'] > 0): ?>
                                <div class="h-time-stats">
                                    <p class="h-time-stats-title"><i class="bi bi-stopwatch me-1"></i>Statistik Waktu</p>
                                    <div class="h-time-row">
                                        <div class="h-time-item">
                                            <span class="h-time-label">Rata-rata</span>
                                            <span class="h-time-val" style="color:#0051ba"><?= $ujian['rata_rata_durasi_format'] ?></span>
                                        </div>
                                        <div class="h-time-item">
                                            <span class="h-time-label">Tercepat</span>
                                            <span class="h-time-val" style="color:#16a34a"><?= $ujian['durasi_tercepat_format'] ?></span>
                                        </div>
                                        <div class="h-time-item">
                                            <span class="h-time-label">Terlama</span>
                                            <span class="h-time-val" style="color:#d97706"><?= $ujian['durasi_terlama_format'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Guru -->
                            <p class="h-guru"><i class="bi bi-person-video3 me-1"></i><?= esc($ujian['nama_guru']) ?></p>
                        </div>

                        <!-- Action -->
                        <div class="h-card-footer">
                            <?php if ($ujian['jumlah_peserta'] > 0): ?>
                                <a href="<?= base_url('admin/hasil-ujian/siswa/' . $ujian['jadwal_id']) ?>" class="btn-submit w-100" style="text-decoration:none;justify-content:center">
                                    <i class="bi bi-eye me-1"></i>
                                    <?= $ujian['status_ujian'] === 'selesai' ? 'Lihat Hasil Ujian' : 'Pantau Progress Ujian' ?>
                                    <span class="pg-badge" style="background:rgba(255,255,255,.2);color:#fff;margin-left:4px"><?= $ujian['peserta_selesai'] ?>/<?= $ujian['jumlah_peserta'] ?></span>
                                </a>
                            <?php else: ?>
                                <button class="btn-cancel w-100" disabled style="justify-content:center;opacity:.6;cursor:default">
                                    <i class="bi bi-people me-1"></i>Belum Ada Peserta Terdaftar
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<style>
.pg-wrap{padding:2rem 2rem 3rem;max-width:1280px}
.pg-header{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem}
.pg-eyebrow{font-size:.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#0051ba;margin-bottom:4px}
.pg-title{font-size:1.5rem;font-weight:800;color:#0f172a;margin-bottom:4px}
.pg-sub{font-size:.84rem;color:#6b7280;margin:0}
.btn-back{display:inline-flex;align-items:center;gap:6px;font-size:.84rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:8px 16px;border-radius:8px;text-decoration:none;white-space:nowrap;transition:all .15s}
.btn-back:hover{background:#f8fafc;color:#0051ba;border-color:#c7d7f5}
.alert-pg{display:flex;align-items:center;font-size:.875rem;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem;position:relative}
.alert-pg--success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534}
.alert-pg--danger{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}
.alert-pg-close{position:absolute;right:.75rem;background:none;border:none;font-size:1.1rem;cursor:pointer;color:inherit;opacity:.5;line-height:1;padding:0}
.alert-pg-close:hover{opacity:1}
/* Legend */
.legend-bar{font-size:.8rem;color:#6b7280;background:#fff;border:1px solid rgba(15,23,42,.07);border-radius:8px;padding:.6rem 1rem;margin-bottom:1rem}
/* Badges */
.pg-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:rgba(0,81,186,.07);color:#0051ba}
.pg-badge--gray{background:rgba(107,114,128,.08);color:#4b5563}
.pg-badge--yellow{background:rgba(245,158,11,.1);color:#92400e}
.pg-badge--green{background:rgba(22,163,74,.08);color:#166534}
.pg-badge--dark{background:rgba(15,23,42,.07);color:#374151}
/* Filter */
.filter-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:10px;padding:1rem 1.25rem;margin-bottom:1rem;box-shadow:0 2px 8px rgba(15,23,42,.03)}
.filter-label{display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;margin-bottom:5px}
.f-input{display:block;width:100%;padding:.55rem .875rem;font-size:.875rem;color:#0f172a;background:#fff;border:1px solid #d1d5db;border-radius:8px;outline:none;transition:border-color .2s,box-shadow .2s;font-family:inherit}
.f-input:focus{border-color:#0051ba;box-shadow:0 0 0 3px rgba(0,81,186,.1)}
.btn-reset{display:inline-flex;align-items:center;justify-content:center;font-size:.85rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:9px;border-radius:8px;cursor:pointer;transition:all .15s;height:37px}
.btn-reset:hover{background:#f0f5ff;color:#0051ba;border-color:#c7d7f5}
/* Hasil Card */
.h-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;box-shadow:0 4px 16px rgba(15,23,42,.04);display:flex;flex-direction:column;overflow:hidden;transition:box-shadow .2s,transform .2s}
.h-card:hover{box-shadow:0 8px 28px rgba(15,23,42,.09);transform:translateY(-2px)}
.h-card-header{display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;background:#f8fafc;border-bottom:1px solid #f1f5f9}
.h-school-info{display:flex;align-items:flex-start;gap:.625rem}
.h-school-icon{width:34px;height:34px;border-radius:8px;background:rgba(0,81,186,.08);color:#0051ba;display:inline-flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;margin-top:1px}
.h-school-name{font-size:.88rem;font-weight:700;color:#0f172a;margin-bottom:2px}
.h-school-kelas{font-size:.75rem;color:#6b7280;margin:0}
.h-card-body{padding:1rem 1.25rem;flex:1}
.h-title{font-size:.95rem;font-weight:700;color:#0f172a;margin-bottom:4px;line-height:1.3}
.h-desc{font-size:.8rem;color:#6b7280;margin:.5rem 0 .75rem;overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2}
.h-time-row{display:flex;gap:.75rem;margin-bottom:.625rem;flex-wrap:wrap}
.h-time-item{flex:1;min-width:140px}
.h-time-label{display:block;font-size:.72rem;color:#9ca3af;margin-bottom:2px}
.h-time-val{font-size:.8rem;font-weight:600;color:#374151}
.h-akses{display:flex;align-items:center;gap:.5rem;background:#f0f5ff;border:1px solid rgba(0,81,186,.12);border-radius:7px;padding:.4rem .75rem;margin-bottom:.75rem}
.h-akses-val{font-size:.84rem;font-weight:700;color:#0051ba;letter-spacing:.5px}
.h-stats{display:flex;gap:.5rem;margin:.75rem 0}
.h-stat{flex:1;display:flex;flex-direction:column;align-items:center;padding:.4rem;background:#f8fafc;border-radius:8px;border:1px solid #f1f5f9}
.h-stat-val{font-size:1rem;font-weight:800;color:#0f172a;line-height:1}
.h-stat-green{color:#16a34a!important}
.h-stat-yellow{color:#d97706!important}
.h-stat-label{font-size:.68rem;color:#9ca3af;margin-top:2px}
.h-progress{margin-bottom:.75rem}
.h-progress-label{font-size:.72rem;color:#9ca3af;margin-top:4px;margin-bottom:0}
.h-time-stats{background:#f8fafc;border-radius:8px;border:1px solid #f1f5f9;padding:.625rem .875rem;margin-bottom:.75rem}
.h-time-stats-title{font-size:.72rem;font-weight:700;color:#6b7280;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.5px}
.h-guru{font-size:.78rem;color:#9ca3af;margin:0}
.h-card-footer{padding:.875rem 1.25rem;border-top:1px solid #f1f5f9}
.tbl-card{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:12px;overflow:hidden}
.tbl-empty{text-align:center;padding:3rem 1rem}
.tbl-empty i{font-size:2.5rem;display:block;margin-bottom:.75rem;color:#cbd5e1}
.tbl-empty p{color:#9ca3af;margin-bottom:.5rem;font-size:.9rem}
.btn-submit{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#fff;background:#0051ba;border:1px solid #0051ba;padding:8px 22px;border-radius:8px;cursor:pointer;transition:all .15s}
.btn-submit:hover{background:#003d8f}
.btn-cancel{display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:600;color:#475569;background:#fff;border:1px solid #e2e8f0;padding:8px 18px;border-radius:8px;cursor:pointer;transition:all .15s}
.w-100{width:100%}
@media(max-width:768px){.pg-wrap{padding:1.25rem 1rem 2rem}.pg-title{font-size:1.25rem}.pg-header{flex-direction:column}.h-time-item{min-width:100px}}
</style>

<script>
document.getElementById('searchUjian') && document.getElementById('searchUjian').addEventListener('keyup', filterCards);
document.getElementById('filterSekolah') && document.getElementById('filterSekolah').addEventListener('change', filterCards);
document.getElementById('filterKelas') && document.getElementById('filterKelas').addEventListener('change', filterCards);
document.getElementById('filterStatus') && document.getElementById('filterStatus').addEventListener('change', filterCards);
document.getElementById('filterMatpel') && document.getElementById('filterMatpel').addEventListener('change', filterCards);

function filterCards() {
    const searchText   = (document.getElementById('searchUjian') ? document.getElementById('searchUjian').value : '').toLowerCase();
    const sekolahFilter = document.getElementById('filterSekolah') ? document.getElementById('filterSekolah').value : '';
    const kelasFilter   = document.getElementById('filterKelas') ? document.getElementById('filterKelas').value : '';
    const statusFilter  = document.getElementById('filterStatus') ? document.getElementById('filterStatus').value : '';
    const matpelFilter  = document.getElementById('filterMatpel') ? document.getElementById('filterMatpel').value : '';

    document.querySelectorAll('.h-card-wrap').forEach(card => {
        const title   = card.querySelector('.h-title') ? card.querySelector('.h-title').textContent.toLowerCase() : '';
        const sekolah = card.getAttribute('data-sekolah') || '';
        const kelas   = card.getAttribute('data-kelas') || '';
        const status  = card.getAttribute('data-status') || '';
        const matpel  = card.getAttribute('data-matpel') || '';

        const match = (!searchText || title.includes(searchText)) &&
                      (!sekolahFilter || sekolah === sekolahFilter) &&
                      (!kelasFilter || kelas === kelasFilter) &&
                      (!statusFilter || status === statusFilter) &&
                      (!matpelFilter || matpel === matpelFilter);

        card.style.display = match ? '' : 'none';
    });
}

function resetFilter() {
    ['searchUjian','filterSekolah','filterKelas','filterStatus','filterMatpel'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    filterCards();
}
</script>

<?= $this->endSection() ?>
