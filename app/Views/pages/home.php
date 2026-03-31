<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <p class="eyebrow">Platform Asesmen Adaptif Fisika</p>
                <h1 class="h-title">Selamat Datang di<br><span>CONCERTO</span></h1>
                <p class="h-sub"><em>Computerized Online Network for Critical Thinking Evaluation through Responsive Testing Optimization</em></p>
                <p class="h-body">Platform asesmen adaptif berbasis web menggunakan algoritma <em>Computerized Adaptive Testing</em> untuk mengukur kemampuan berpikir kritis peserta tes pada bidang Fisika secara akurat dan efisien.</p>
                <div class="h-cta">
                    <a href="<?= base_url('login') ?>" class="btn-solid">Masuk</a>
                    <a href="<?= base_url('register') ?>" class="btn-ghost">Daftar Sekarang</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?= base_url('assets/images/heros.png') ?>" alt="CONCERTO" class="h-img">
            </div>
        </div>
    </div>
</section>

<!-- STRIP -->
<!-- <div class="strip">
    <div class="container">
        <div class="strip-inner">
            <span><strong>CAT</strong> Computerized Adaptive Testing</span>
            <span><strong>IRT</strong> Item Response Theory</span>
            <span><strong>CTT</strong> Classical Test Theory</span>
        </div>
    </div>
</div> -->

<!-- FEATURES -->
<section class="features">
    <div class="container">
        <div class="row align-items-start g-5">
            <div class="col-lg-4">
                <p class="sec-label">Keunggulan</p>
                <h2 class="sec-title">Mengapa CONCERTO?</h2>
                <p class="sec-desc">Dirancang dengan pendekatan ilmiah untuk asesmen yang akurat, efisien, dan bermakna.</p>
                <a href="<?= base_url('about') ?>" class="sec-link">Pelajari lebih lanjut →</a>
            </div>
            <div class="col-lg-8">
                <div class="f-list">
                    <div class="f-item">
                        <div class="f-icon"><i class="bi bi-cpu-fill"></i></div>
                        <div>
                            <h3>Adaptif &amp; Cerdas</h3>
                            <p>Tingkat kesulitan soal menyesuaikan kemampuan peserta secara otomatis menggunakan algoritma IRT secara <em>real-time</em>.</p>
                        </div>
                    </div>
                    <div class="f-item">
                        <div class="f-icon"><i class="bi bi-lightbulb-fill"></i></div>
                        <div>
                            <h3>Mengukur Berpikir Kritis</h3>
                            <p>Dirancang khusus untuk mengukur kemampuan berpikir kritis bidang Fisika dengan soal-soal tervalidasi ilmiah.</p>
                        </div>
                    </div>
                    <div class="f-item">
                        <div class="f-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                        <div>
                            <h3>Laporan Mendalam</h3>
                            <p>Laporan analisis profil kemampuan kognitif yang komprehensif dan dapat diunduh dalam format PDF.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ═══════════════ HERO ═══════════════ */
.hero {
    background: linear-gradient(135deg, #001a4f 0%, #0051ba 100%);
    padding: 96px 0 88px;
    position: relative;
    overflow: hidden;
}

/* Grid lines */
.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
    background-size: 60px 60px;
}

/* Glow circle kanan */
.hero::after {
    content: '';
    position: absolute;
    right: -100px;
    top: 50%;
    transform: translateY(-50%);
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(0,81,186,.6) 0%, transparent 70%);
    pointer-events: none;
}

.hero .container { position: relative; z-index: 1; }

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(255,255,255,.5);
    margin-bottom: 18px;
}

.eyebrow::before {
    content: '';
    display: inline-block;
    width: 20px;
    height: 1px;
    background: rgba(255,255,255,.4);
}

.h-title {
    font-size: 3rem;
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    margin-bottom: 14px;
    letter-spacing: -.5px;
}

.h-title span {
    color: #ffda1a;
    letter-spacing: 3px;
    position: relative;
}

/* underline accent on CONCERTO */
.h-title span::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -4px;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #ffda1a, transparent);
}

.h-sub {
    font-size: .78rem;
    color: rgba(255,255,255,.38);
    line-height: 1.65;
    margin-bottom: 16px;
}

.h-body {
    font-size: .96rem;
    color: rgba(255,255,255,.75);
    line-height: 1.8;
    margin-bottom: 36px;
    max-width: 480px;
}

.h-cta { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }

.btn-solid {
    background: #fff;
    color: #0051ba;
    font-weight: 700;
    font-size: .92rem;
    padding: 11px 28px;
    border-radius: 6px;
    text-decoration: none;
    transition: all .2s;
    letter-spacing: .2px;
}

.btn-solid:hover {
    background: #ffda1a;
    color: #001a4f;
    box-shadow: 0 0 20px rgba(255,218,26,.3);
}

.btn-ghost {
    font-size: .9rem;
    font-weight: 500;
    color: rgba(255,255,255,.6);
    text-decoration: none;
    border-bottom: 1px solid rgba(255,255,255,.2);
    padding-bottom: 1px;
    transition: all .2s;
}

.btn-ghost:hover { color: #fff; border-color: #fff; }

.h-img {
    max-width: 82%;
    border-radius: 12px;
    filter: drop-shadow(0 20px 50px rgba(0,0,0,.4));
}

/* ═══════════════ STRIP ═══════════════ */
.strip {
    background: #001030;
    border-top: 1px solid rgba(255,255,255,.06);
    border-bottom: 1px solid rgba(255,255,255,.06);
    padding: 16px 0;
}

.strip-inner {
    display: flex;
    justify-content: center;
    gap: 56px;
    flex-wrap: wrap;
}

.strip-inner span {
    font-size: .78rem;
    color: rgba(255,255,255,.35);
    letter-spacing: .4px;
}

.strip-inner strong {
    color: rgba(255,255,255,.7);
    font-weight: 700;
    margin-right: 6px;
}

/* ═══════════════ FEATURES ═══════════════ */
.features {
    padding: 88px 0 80px;
    background: #fff;
}

.sec-label {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #0051ba;
    margin-bottom: 10px;
}

.sec-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #111827;
    line-height: 1.25;
    margin-bottom: 14px;
    letter-spacing: -.2px;
}

.sec-desc {
    font-size: .88rem;
    color: #6b7280;
    line-height: 1.75;
    margin-bottom: 20px;
}

.sec-link {
    font-size: .88rem;
    font-weight: 600;
    color: #0051ba;
    text-decoration: none;
}

.sec-link:hover { text-decoration: underline; }

/* Feature list */
.f-list { display: flex; flex-direction: column; }

.f-item {
    display: flex;
    gap: 18px;
    padding: 26px 0;
    border-bottom: 1px solid #f3f4f6;
    transition: all .2s;
}

.f-item:first-child { border-top: 1px solid #f3f4f6; }

.f-item:hover { padding-left: 8px; }

.f-icon {
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    background: #f0f5ff;
    color: #0051ba;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    margin-top: 2px;
    transition: all .2s;
}

.f-item:hover .f-icon {
    background: #0051ba;
    color: #fff;
}

.f-item h3 {
    font-size: .95rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 5px;
}

.f-item p {
    font-size: .87rem;
    color: #6b7280;
    line-height: 1.72;
    margin: 0;
}

/* ═══════════════ RESPONSIVE ═══════════════ */
@media (max-width: 768px) {
    .hero { padding: 64px 0 56px; text-align: center; }
    .hero-body, .h-body { max-width: 100%; }
    .h-title { font-size: 2.1rem; }
    .h-cta { justify-content: center; }
    .h-img { max-width: 78%; margin-bottom: 36px; }
    .strip-inner { gap: 20px; }
    .features { padding: 60px 0; }
}
</style>

<?= $this->endSection() ?>
