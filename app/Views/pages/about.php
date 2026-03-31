<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header">
    <div class="container">
        <p class="page-label">Tentang Platform</p>
        <h1 class="page-title">Tentang CONCERTO</h1>
        <div class="title-accent"></div>
    </div>
</div>


<!-- ===== CONTENT ===== -->
<div class="page-body">
    <div class="container">

        <!-- Apa itu CONCERTO -->
        <div class="content-block">
            <div class="row align-items-start g-5">
                <div class="col-lg-7">
                    <h2 class="block-title">Apa itu CONCERTO?</h2>
                    <p class="block-acronym"><em><strong>C</strong>omputerized <strong>O</strong>nline <strong>N</strong>etwork for <strong>C</strong>ritical Thinking <strong>E</strong>valuation through <strong>R</strong>esponsive <strong>T</strong>esting <strong>O</strong>ptimization</em></p>
                    <p class="block-text">CONCERTO adalah platform asesmen adaptif berbasis web yang menggunakan algoritma <em>Computerized Adaptive Testing</em> (CAT) dan dirancang untuk mengukur kemampuan berpikir kritis peserta tes khususnya pada bidang Fisika secara akurat, efisien, dan adaptif.</p>
                    <p class="block-text">Platform ini memanfaatkan teknologi komputer untuk memberikan soal-soal yang secara otomatis menyesuaikan dengan kemampuan peserta tes. Dengan pendekatan adaptif ini, setiap pengguna mendapatkan pengalaman asesmen yang inovatif, menantang, dan relevan dengan tingkat pemahamannya.</p>
                </div>
                <div class="col-lg-5">
                    <div class="info-list">
                        <div class="info-list-item">
                            <i class="bi bi-cpu-fill"></i>
                            <div>
                                <strong>Algoritma CAT</strong>
                                <span>Item Response Theory (IRT)</span>
                            </div>
                        </div>
                        <div class="info-list-item">
                            <i class="bi bi-lightbulb-fill"></i>
                            <div>
                                <strong>Kemampuan Berpikir Kritis</strong>
                                <span>Pengukuran tervalidasi ilmiah</span>
                            </div>
                        </div>
                        <div class="info-list-item">
                            <i class="bi bi-graph-up-arrow"></i>
                            <div>
                                <strong>Adaptif Real-Time</strong>
                                <span>Soal menyesuaikan kemampuan</span>
                            </div>
                        </div>
                        <div class="info-list-item">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i>
                            <div>
                                <strong>Laporan Mendalam</strong>
                                <span>Profil kemampuan kognitif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-divider"></div>

        <!-- Fitur Utama -->
        <div class="content-block">
            <h2 class="block-title">Fitur Utama</h2>
            <div class="row g-4 mt-1">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-num">01</div>
                        <h3>Adaptif</h3>
                        <p>Sistem menyesuaikan tingkat kesulitan soal dengan kemampuan peserta secara <em>real-time</em> menggunakan model IRT.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card feature-card-accent">
                        <div class="feature-num">02</div>
                        <h3>Kognitif</h3>
                        <p>Memberikan hasil analisis profil kemampuan kognitif dan kemampuan berpikir kritis peserta tes bidang Fisika.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-num">03</div>
                        <h3>Inovatif</h3>
                        <p>Menggunakan teknologi terkini untuk pengalaman asesmen yang efektif, efisien, dan berbasis bukti ilmiah.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* ── Page Header ── */
    .page-header {
        background: linear-gradient(135deg, #001a4f 0%, #0051ba 100%);
        padding: 64px 0 56px;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 60px 60px;
    }

    .page-header .container { position: relative; z-index: 1; }

    .page-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(255,255,255,.5);
        margin-bottom: 12px;
    }

    .page-label::before {
        content: '';
        display: inline-block;
        width: 20px;
        height: 1px;
        background: rgba(255,255,255,.4);
    }

    .page-title {
        font-size: 2.4rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 14px;
        letter-spacing: -.3px;
    }

    .title-accent {
        width: 48px;
        height: 2px;
        background: linear-gradient(90deg, #ffda1a, transparent);
        border-radius: 2px;
    }

    /* ── Page Body ── */
    .page-body {
        background: #fafafa;
        padding: 70px 0;
    }

    .content-block {
        margin-bottom: 60px;
    }

    .block-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
    }

    .block-acronym {
        font-size: .85rem;
        color: #6b7280;
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .block-text {
        font-size: .95rem;
        color: #374151;
        line-height: 1.8;
        margin-bottom: 14px;
    }

    /* ── Info List ── */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 0;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
    }

    .info-list-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        transition: background .2s;
    }

    .info-list-item:last-child {
        border-bottom: none;
    }

    .info-list-item:hover {
        background: #f8faff;
    }

    .info-list-item i {
        color: #0051ba;
        font-size: 1.05rem;
        flex-shrink: 0;
        width: 20px;
        text-align: center;
    }

    .info-list-item div {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .info-list-item strong {
        font-size: .88rem;
        font-weight: 600;
        color: #111827;
    }

    .info-list-item span {
        font-size: .8rem;
        color: #6b7280;
    }

    /* ── Divider ── */
    .section-divider {
        border-top: 1px solid #e5e7eb;
        margin-bottom: 60px;
    }

    /* ── Feature Cards ── */
    .feature-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 28px;
        height: 100%;
        transition: all .3s;
    }

    .feature-card:hover {
        border-color: #0051ba;
        box-shadow: 0 6px 22px rgba(0,81,186,.09);
        transform: translateY(-3px);
    }

    .feature-card-accent {
        border-left: 3px solid #0051ba;
    }

    .feature-num {
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: 1px;
        color: #0051ba;
        margin-bottom: 10px;
    }

    .feature-card h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }

    .feature-card p {
        font-size: .88rem;
        color: #6b7280;
        line-height: 1.7;
        margin: 0;
    }

    @media (max-width: 768px) {
        .page-header { padding: 45px 0 35px; }
        .page-title { font-size: 1.9rem; }
        .page-body { padding: 45px 0; }
    }
</style>

<?= $this->endSection() ?>
