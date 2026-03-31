<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header">
    <div class="container">
        <p class="page-label">Bantuan</p>
        <h1 class="page-title">Pusat Bantuan</h1>
        <div class="title-accent"></div>
        <p class="page-desc">Temukan solusi untuk kendala yang Anda hadapi di CONCERTO</p>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="page-body">
    <div class="container">

        <!-- Help Cards -->
        <div class="row g-4 mb-5">

            <div class="col-md-6 col-lg-4">
                <div class="help-card">
                    <i class="bi bi-key-fill help-icon"></i>
                    <h3>Masalah Login</h3>
                    <p>Apabila lupa password, silakan hubungi admin untuk mereset password Anda.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="help-card">
                    <i class="bi bi-question-circle-fill help-icon"></i>
                    <h3>Soal Tidak Muncul</h3>
                    <p>Periksa koneksi internet Anda. Jika masalah berlanjut, hubungi admin.</p>
                    <ul class="help-checklist">
                        <li>Periksa koneksi internet</li>
                        <li>Refresh halaman</li>
                        <li>Coba browser berbeda</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="help-card">
                    <i class="bi bi-file-earmark-text-fill help-icon"></i>
                    <h3>Laporan Hasil</h3>
                    <p>Tunggu beberapa saat setelah ujian selesai. Jika masih bermasalah, laporkan melalui pusat bantuan.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="help-card">
                    <i class="bi bi-person-badge-fill help-icon"></i>
                    <h3>Akses Guru / Admin</h3>
                    <p>Pastikan Anda telah terdaftar sebagai guru atau admin. Hubungi admin utama untuk memverifikasi akun Anda.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="help-card">
                    <i class="bi bi-gear-fill help-icon"></i>
                    <h3>Pengaturan Akun</h3>
                    <p>Temukan bantuan untuk mengubah profil, kata sandi, dan pengaturan akun lainnya.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="#" id="teknis-platform-link" class="help-card help-card-link">
                    <i class="bi bi-laptop-fill help-icon"></i>
                    <h3>Teknis Platform</h3>
                    <p>Panduan umum untuk menggunakan platform dan mengatasi masalah teknis.</p>
                    <span class="help-link-hint">Lihat panduan lengkap <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>

        </div>

        <!-- Contact -->
        <div class="contact-row">
            <div>
                <p class="contact-row-label">Butuh bantuan lebih lanjut?</p>
                <p class="contact-row-desc">Jika pertanyaan Anda belum terjawab, kirim email ke tim kami.</p>
            </div>
            <a href="mailto:jauzaamalia@upi.edu" class="btn-contact">
                <i class="bi bi-envelope"></i> Kirim Email
            </a>
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

    /* ── Help Cards ── */
    .help-card {
        display: block;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 24px;
        height: 100%;
        text-decoration: none;
        color: inherit;
        transition: all .25s;
    }

    .help-card:hover {
        border-color: #0051ba;
        box-shadow: 0 6px 20px rgba(0,81,186,.08);
        transform: translateY(-3px);
        color: inherit;
    }

    .help-card-link {
        cursor: pointer;
    }

    .help-icon {
        font-size: 1.25rem;
        color: #0051ba;
        display: block;
        margin-bottom: 14px;
    }

    .help-card h3 {
        font-size: .97rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }

    .help-card p {
        font-size: .87rem;
        color: #4b5563;
        line-height: 1.7;
        margin: 0;
    }

    .help-checklist {
        list-style: none;
        padding: 0;
        margin: 12px 0 0;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .help-checklist li {
        font-size: .83rem;
        color: #6b7280;
        padding-left: 14px;
        position: relative;
    }

    .help-checklist li::before {
        content: '·';
        position: absolute;
        left: 4px;
        color: #0051ba;
        font-weight: 700;
    }

    .help-link-hint {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .82rem;
        font-weight: 600;
        color: #0051ba;
        margin-top: 12px;
    }

    /* ── Contact Row ── */
    .contact-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-left: 3px solid #0051ba;
        border-radius: 8px;
        padding: 24px 28px;
    }

    .contact-row-label {
        font-size: .97rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }

    .contact-row-desc {
        font-size: .87rem;
        color: #6b7280;
        margin: 0;
    }

    .btn-contact {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0051ba;
        color: #fff;
        font-size: .9rem;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 7px;
        text-decoration: none;
        white-space: nowrap;
        transition: background .25s;
    }

    .btn-contact:hover {
        background: #003d8f;
        color: #fff;
    }

    @media (max-width: 768px) {
        .page-header { padding: 45px 0 35px; }
        .page-title { font-size: 1.8rem; }
        .page-body { padding: 45px 0; }
        .contact-row { flex-direction: column; align-items: flex-start; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const link = document.getElementById('teknis-platform-link');
        link.href = 'https://bit.ly/PanduanCONCERTO';
        link.target = '_blank';
    });
</script>

<?= $this->endSection() ?>
