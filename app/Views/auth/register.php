<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<div class="auth-container">
    <!-- Left Panel -->
    <div class="auth-left-panel">
        <div class="auth-left-content">
            <div class="auth-brand">
                <div class="auth-brand-icon">C</div>
                <span class="auth-brand-name">CONCERTO</span>
            </div>
            <h2 class="auth-left-title">Bergabunglah dengan CONCERTO</h2>
            <p class="auth-left-desc">
                Daftarkan diri Anda dan mulai pengalaman asesmen adaptif Fisika yang akurat dan efisien.
            </p>
            <div class="auth-features">
                <div class="auth-feature-item">
                    <div class="auth-feature-icon"><i class="bi bi-person-check-fill"></i></div>
                    <span>Akun Pribadi yang Aman</span>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon"><i class="bi bi-clock-history"></i></div>
                    <span>Riwayat Asesmen Tersimpan</span>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <span>Pantau Perkembangan Kemampuan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="auth-right-panel">
        <div class="auth-card">
            <div class="auth-card-header">
                <h2 class="auth-card-title">Buat Akun Baru</h2>
                <p class="auth-card-subtitle">Isi form berikut untuk mendaftar ke CONCERTO</p>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="auth-alert auth-alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="post" class="auth-form" autocomplete="on">
                <?= csrf_field() ?>

                <div class="auth-field">
                    <label class="auth-label"><i class="bi bi-person"></i> Username</label>
                    <div class="auth-input-wrap">
                        <input type="text" class="auth-input" name="username" placeholder="Pilih username Anda" autocomplete="username" readonly required>
                    </div>
                </div>

                <div class="auth-field">
                    <label class="auth-label"><i class="bi bi-envelope"></i> Email</label>
                    <div class="auth-input-wrap">
                        <input type="email" class="auth-input" name="email" placeholder="Masukkan alamat email Anda" autocomplete="email" readonly required>
                    </div>
                </div>

                <div class="auth-field">
                    <label class="auth-label"><i class="bi bi-lock"></i> Password</label>
                    <div class="auth-input-wrap auth-input-password">
                        <input type="password" class="auth-input" name="password" id="passwordInput" placeholder="Buat password Anda" autocomplete="new-password" readonly required>
                        <button type="button" class="btn-toggle-pass" onclick="togglePassword('passwordInput', 'togglePass1')">
                            <i class="bi bi-eye-slash" id="togglePass1"></i>
                        </button>
                    </div>
                </div>

                <div class="auth-field">
                    <label class="auth-label"><i class="bi bi-shield-lock"></i> Konfirmasi Password</label>
                    <div class="auth-input-wrap auth-input-password">
                        <input type="password" class="auth-input" name="confirm_password" id="confirmPasswordInput" placeholder="Ulangi password Anda" autocomplete="new-password" readonly required>
                        <button type="button" class="btn-toggle-pass" onclick="togglePassword('confirmPasswordInput', 'togglePass2')">
                            <i class="bi bi-eye-slash" id="togglePass2"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-auth-submit">
                    <i class="bi bi-person-plus-fill me-2"></i>Buat Akun
                </button>
            </form>

            <div class="auth-footer-text">
                Sudah punya akun? <a href="<?= base_url('login') ?>" class="auth-link">Masuk di sini</a>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        margin: 0;
        padding: 0;
        background: #f4f6fb;
    }

    .auth-container {
        min-height: calc(100vh - 58px);
        display: flex;
    }

    /* Left Panel */
    .auth-left-panel {
        background: linear-gradient(135deg, #001a4f 0%, #0051ba 100%);
        flex: 0 0 42%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 50px;
        position: relative;
        overflow: hidden;
    }

    .auth-left-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 60px 60px;
    }

    .auth-left-panel::after {
        content: '';
        position: absolute;
        right: -80px;
        top: 50%;
        transform: translateY(-50%);
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(0,81,186,.5) 0%, transparent 70%);
        pointer-events: none;
    }

    .auth-left-content {
        position: relative;
        z-index: 1;
        max-width: 360px;
    }

    .auth-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 32px;
    }

    .auth-brand-icon {
        background: #ffda1a;
        color: #001a4f;
        width: 38px;
        height: 38px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .auth-brand-name {
        font-size: 1.4rem;
        font-weight: 800;
        letter-spacing: 2.5px;
        color: white;
    }

    .auth-left-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: white;
        margin-bottom: 14px;
        line-height: 1.3;
    }

    .auth-left-desc {
        color: rgba(255, 255, 255, 0.65);
        font-size: 0.87rem;
        line-height: 1.65;
        margin-bottom: 32px;
    }

    .auth-features {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .auth-feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .auth-feature-icon {
        background: rgba(255, 218, 26, 0.18);
        color: #ffda1a;
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Right Panel */
    .auth-right-panel {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 30px;
        background: #f4f6fb;
    }

    .auth-card {
        background: white;
        border-radius: 18px;
        padding: 38px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 8px 32px rgba(0, 81, 186, 0.1);
        border: 1px solid rgba(0, 81, 186, 0.07);
    }

    .auth-card-header {
        margin-bottom: 26px;
    }

    .auth-card-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #001a4f;
        margin-bottom: 6px;
    }

    .auth-card-subtitle {
        color: #5a5a6e;
        font-size: 0.88rem;
        margin: 0;
    }

    /* Alert */
    .auth-alert {
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.88rem;
    }

    .auth-alert i {
        flex-shrink: 0;
        margin-top: 1px;
    }

    .auth-alert-error {
        background: rgba(220, 53, 69, 0.08);
        border-left: 3px solid #dc3545;
        color: #842029;
    }

    /* Form */
    .auth-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 20px;
    }

    .auth-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .auth-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #001a4f;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .auth-label i {
        color: #0051ba;
    }

    .auth-input-wrap {
        display: flex;
        align-items: center;
    }

    .auth-input {
        flex: 1;
        background: #f4f6fb;
        border: 1.5px solid #eae7e7;
        border-radius: 9px;
        padding: 12px 14px;
        font-size: 0.92rem;
        color: #1a1a2e;
        transition: all 0.25s ease;
        outline: none;
        font-family: inherit;
        width: 100%;
    }

    .auth-input:focus {
        border-color: #0051ba;
        background: white;
        box-shadow: 0 0 0 3px rgba(0, 81, 186, 0.1);
    }

    .auth-input-password .auth-input {
        border-radius: 9px 0 0 9px;
        border-right: none;
    }

    .btn-toggle-pass {
        background: #f4f6fb;
        border: 1.5px solid #eae7e7;
        border-left: none;
        border-radius: 0 9px 9px 0;
        padding: 12px 14px;
        color: #5a5a6e;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.95rem;
        line-height: 1;
    }

    .btn-toggle-pass:hover {
        color: #0051ba;
        background: white;
    }

    .btn-auth-submit {
        background: #0051ba;
        color: white;
        font-weight: 700;
        padding: 13px;
        border-radius: 10px;
        border: none;
        font-size: 0.98rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 4px;
    }

    .btn-auth-submit:hover {
        background: #003d8f;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 81, 186, 0.3);
    }

    .auth-footer-text {
        text-align: center;
        font-size: 0.88rem;
        color: #5a5a6e;
    }

    .auth-link {
        color: #0051ba;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }

    .auth-link:hover {
        color: #003d8f;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .auth-container {
            flex-direction: column;
        }

        .auth-left-panel {
            flex: none;
            padding: 40px 30px;
        }

        .auth-right-panel {
            padding: 30px 20px;
        }

        .auth-card {
            padding: 26px 20px;
        }
    }
</style>

<script>
    // Hapus readonly saat diklik agar saran muncul, tapi tidak autofill saat load
    document.querySelectorAll('.auth-input[readonly]').forEach(el => {
        el.addEventListener('focus', () => el.removeAttribute('readonly'), { once: true });
    });

    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    }
</script>

<?= $this->endSection() ?>
