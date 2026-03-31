<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header">
    <div class="container">
        <p class="page-label">Saran</p>
        <h1 class="page-title">Hubungi Kami</h1>
        <div class="title-accent"></div>
        <p class="page-desc">Sampaikan kritik dan saran Anda untuk pengembangan CONCERTO</p>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="page-body">
    <div class="container">
        <div class="row g-5 justify-content-center">

            <!-- Form -->
            <div class="col-lg-7">
                <div class="form-card">
                    <h3 class="form-card-title">Kritik &amp; Saran</h3>
                    <p class="form-card-desc">Kami sangat menghargai setiap masukan dari Anda.</p>

                    <form id="contactForm" onsubmit="sendEmail(event)" class="contact-form">
                        <div class="form-field">
                            <label class="field-label">Nama Lengkap</label>
                            <input type="text" class="field-input" id="name" name="name" placeholder="Masukkan nama lengkap Anda" required>
                        </div>
                        <div class="form-field">
                            <label class="field-label">Alamat Email</label>
                            <input type="email" class="field-input" id="email" name="email" placeholder="Masukkan alamat email Anda" required>
                        </div>
                        <div class="form-field">
                            <label class="field-label">Pesan</label>
                            <textarea class="field-input field-textarea" id="message" name="message" placeholder="Tuliskan kritik, saran, atau pertanyaan Anda..." required></textarea>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-send"></i> Kirim Pesan
                        </button>
                    </form>

                    <div class="form-alt">
                        atau <a href="mailto:jauzaamalia@upi.edu?subject=Kritik dan Saran CONCERTO">kirim email langsung</a>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="col-lg-4">
                <div class="info-block">
                    <h4 class="info-block-title">Informasi Kontak</h4>
                    <div class="info-item">
                        <i class="bi bi-envelope-fill"></i>
                        <div>
                            <span>Email</span>
                            <strong>abdulsalam@upi.edu</strong>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-telephone-fill"></i>
                        <div>
                            <span>Telepon</span>
                            <strong>+62 857 9412 4143</strong>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div>
                            <span>Lokasi</span>
                            <strong>Bandung, Indonesia</strong>
                        </div>
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

    /* ── Form Card ── */
    .form-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 36px;
    }

    .form-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
    }

    .form-card-desc {
        font-size: .87rem;
        color: #6b7280;
        margin-bottom: 28px;
    }

    .contact-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .form-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .field-label {
        font-size: .83rem;
        font-weight: 600;
        color: #374151;
    }

    .field-input {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        padding: 11px 14px;
        font-size: .9rem;
        color: #111827;
        outline: none;
        font-family: inherit;
        transition: border .2s, box-shadow .2s;
        width: 100%;
    }

    .field-input:focus {
        border-color: #0051ba;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(0,81,186,.08);
    }

    .field-textarea {
        height: 130px;
        resize: vertical;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #0051ba;
        color: #fff;
        font-weight: 600;
        font-size: .93rem;
        padding: 12px 24px;
        border-radius: 7px;
        border: none;
        cursor: pointer;
        transition: background .25s;
        align-self: flex-start;
    }

    .btn-submit:hover {
        background: #003d8f;
    }

    .form-alt {
        margin-top: 18px;
        font-size: .83rem;
        color: #9ca3af;
    }

    .form-alt a {
        color: #0051ba;
        font-weight: 500;
        text-decoration: none;
    }

    .form-alt a:hover { text-decoration: underline; }

    /* Alert */
    .custom-alert {
        margin-top: 14px;
        padding: 10px 14px;
        border-radius: 7px;
        font-size: .87rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-success {
        background: #f0fdf4;
        border-left: 3px solid #22c55e;
        color: #15803d;
    }

    /* ── Info Block ── */
    .info-block {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 28px;
    }

    .info-block-title {
        font-size: .85rem;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 24px;
        padding-bottom: 14px;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 20px;
    }

    .info-item:last-child { margin-bottom: 0; }

    .info-item i {
        color: #0051ba;
        font-size: 1rem;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .info-item div {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .info-item span {
        font-size: .78rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .info-item strong {
        font-size: .9rem;
        color: #111827;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .page-header { padding: 45px 0 35px; }
        .page-title { font-size: 1.8rem; }
        .page-body { padding: 45px 0; }
        .form-card { padding: 24px 20px; }
        .btn-submit { align-self: stretch; }
    }
</style>

<script>
    function sendEmail(e) {
        e.preventDefault();
        const name    = document.getElementById('name').value;
        const email   = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        const subject = encodeURIComponent('Kritik dan Saran CONCERTO');
        const body    = encodeURIComponent(`Nama: ${name}\nEmail: ${email}\n\nPesan:\n${message}\n\n---\nDikirim melalui form kontak CONCERTO`);

        window.location.href = `mailto:jauzaamalia@upi.edu?subject=${subject}&body=${body}`;

        const old = document.querySelector('.custom-alert');
        if (old) old.remove();

        const alert = document.createElement('div');
        alert.className = 'custom-alert alert-success';
        alert.innerHTML = '<i class="bi bi-check-circle-fill"></i> Email client Anda akan terbuka. Silakan kirim email dari aplikasi email Anda.';
        document.getElementById('contactForm').after(alert);
        setTimeout(() => alert.remove(), 5000);
    }
</script>

<?= $this->endSection() ?>
