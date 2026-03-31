<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header">
    <div class="container">
        <p class="page-label">Panduan</p>
        <h1 class="page-title">Panduan Penggunaan CONCERTO</h1>
        <div class="title-accent"></div>
        <p class="page-desc">Ikuti langkah-langkah berikut untuk memulai asesmen adaptif Fisika</p>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="page-body">
    <div class="container">

        <!-- Apa itu CONCERTO -->
        <div class="info-banner">
            <i class="bi bi-info-circle-fill info-banner-icon"></i>
            <div>
                <strong>Apa itu CONCERTO?</strong>
                <p>CONCERTO merupakan media asesmen adaptif yang dapat digunakan siswa untuk mengerjakan soal berdasarkan kemampuan <em>real-time</em> dan memberikan pengukuran kemampuan berpikir kritis yang lebih akurat. Sistem akan menyesuaikan tingkat kesulitan soal secara otomatis.</p>
            </div>
        </div>

        <!-- Langkah-langkah -->
        <div class="content-block">
            <h2 class="block-title">Langkah-Langkah Penggunaan</h2>
            <div class="steps-list">
                <div class="step-item">
                    <div class="step-left">
                        <div class="step-num">1</div>
                        <div class="step-line"></div>
                    </div>
                    <div class="step-content">
                        <h3>Login</h3>
                        <p>Masuk menggunakan akun yang telah diberikan oleh guru atau admin.</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-left">
                        <div class="step-num">2</div>
                        <div class="step-line"></div>
                    </div>
                    <div class="step-content">
                        <h3>Masukkan Token</h3>
                        <p>Masukkan <em>token</em> ujian yang telah diberikan oleh pengawas ujian.</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-left">
                        <div class="step-num">3</div>
                        <div class="step-line"></div>
                    </div>
                    <div class="step-content">
                        <h3>Kerjakan Ujian</h3>
                        <p>Kerjakan soal dengan teliti sesuai waktu yang ditentukan. Soal akan menyesuaikan secara adaptif.</p>
                    </div>
                </div>
                <div class="step-item step-item-last">
                    <div class="step-left">
                        <div class="step-num">4</div>
                    </div>
                    <div class="step-content">
                        <h3>Lihat Hasil</h3>
                        <p>Hasil analisis kemampuan akan ditampilkan setelah ujian berakhir.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-divider"></div>

        <!-- Peraturan -->
        <div class="content-block">
            <h2 class="block-title">Peraturan Ujian</h2>
            <div class="row g-4 mt-1">
                <div class="col-md-6">
                    <div class="rules-card rules-not-allowed">
                        <div class="rules-header">
                            <i class="bi bi-x-circle-fill"></i>
                            <h4>Tidak Diperbolehkan</h4>
                        </div>
                        <ul class="rules-list">
                            <li>Membuka <em>tab browser</em> lain</li>
                            <li>Menggunakan perangkat elektronik lain</li>
                            <li>Meninggalkan halaman ujian</li>
                            <li>Bekerja sama dengan peserta lain</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rules-card rules-allowed">
                        <div class="rules-header">
                            <i class="bi bi-check-circle-fill"></i>
                            <h4>Diperbolehkan</h4>
                        </div>
                        <ul class="rules-list">
                            <li>Menggunakan kalkulator <em>scientific</em></li>
                            <li>Menggunakan kertas coret-coretan</li>
                            <li>Bertanya pada pengawas jika ada kendala</li>
                            <li>Meminta waktu tambahan jika diperlukan</li>
                        </ul>
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
        margin-bottom: 16px;
    }

    .page-desc {
        font-size: .95rem;
        color: rgba(255,255,255,.6);
        margin: 0;
    }

    /* ── Page Body ── */
    .page-body {
        background: #fafafa;
        padding: 60px 0;
    }

    /* ── Info Banner ── */
    .info-banner {
        display: flex;
        gap: 16px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-left: 3px solid #0051ba;
        border-radius: 8px;
        padding: 22px 24px;
        margin-bottom: 50px;
    }

    .info-banner-icon {
        color: #0051ba;
        font-size: 1.15rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .info-banner strong {
        display: block;
        font-size: .93rem;
        color: #111827;
        margin-bottom: 6px;
    }

    .info-banner p {
        font-size: .88rem;
        color: #4b5563;
        line-height: 1.75;
        margin: 0;
    }

    /* ── Content Block ── */
    .content-block {
        margin-bottom: 50px;
    }

    .block-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 24px;
    }

    /* ── Steps ── */
    .steps-list {
        display: flex;
        flex-direction: column;
    }

    .step-item {
        display: flex;
        gap: 20px;
    }

    .step-left {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex-shrink: 0;
    }

    .step-num {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #0051ba;
        color: #fff;
        font-size: .85rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .step-line {
        width: 1px;
        flex: 1;
        background: #e5e7eb;
        margin: 6px 0;
    }

    .step-content {
        padding-bottom: 28px;
    }

    .step-item-last .step-content {
        padding-bottom: 0;
    }

    .step-content h3 {
        font-size: .97rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
        margin-top: 6px;
    }

    .step-content p {
        font-size: .88rem;
        color: #4b5563;
        line-height: 1.7;
        margin: 0;
    }

    /* ── Divider ── */
    .section-divider {
        border-top: 1px solid #e5e7eb;
        margin-bottom: 50px;
    }

    /* ── Rules ── */
    .rules-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 24px;
        height: 100%;
    }

    .rules-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid #f3f4f6;
    }

    .rules-not-allowed .rules-header i { color: #ef4444; font-size: 1.1rem; }
    .rules-allowed .rules-header i    { color: #22c55e; font-size: 1.1rem; }

    .rules-header h4 {
        font-size: .97rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .rules-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .rules-list li {
        font-size: .88rem;
        color: #4b5563;
        padding-left: 14px;
        position: relative;
        line-height: 1.6;
    }

    .rules-not-allowed .rules-list li::before { content:'—'; position:absolute; left:0; color:#ef4444; font-size:.75rem; top:2px; }
    .rules-allowed    .rules-list li::before { content:'✓'; position:absolute; left:0; color:#22c55e; font-size:.75rem; top:1px; }

    @media (max-width: 768px) {
        .page-header { padding: 45px 0 35px; }
        .page-title { font-size: 1.8rem; }
        .page-body { padding: 45px 0; }
        .info-banner { flex-direction: column; gap: 10px; }
    }
</style>

<?= $this->endSection() ?>
