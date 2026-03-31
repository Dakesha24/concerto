<style>
    .navbar-concerto {
        background-color: #0051ba;
        padding: 10px 0;
        box-shadow: 0 2px 12px rgba(0, 81, 186, 0.35);
    }

    .navbar-brand-concerto {
        color: white !important;
        font-weight: 800;
        font-size: 1.3rem;
        letter-spacing: 2.5px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .brand-icon {
        background-color: #ffda1a;
        color: #001a4f;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    .navbar-nav-concerto {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .navbar-nav-concerto .nav-item {
        margin: 0 2px;
    }

    .navbar-nav-concerto .nav-link {
        color: rgba(255, 255, 255, 0.78) !important;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.25s ease;
        padding: 8px 11px;
        border-radius: 7px;
        position: relative;
        text-decoration: none;
    }

    .navbar-nav-concerto .nav-link:hover {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .navbar-nav-concerto .nav-link.active {
        color: #ffda1a !important;
        background-color: rgba(255, 218, 26, 0.12);
        font-weight: 600;
    }

    .navbar-nav-concerto .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 3px;
        left: 50%;
        background-color: #ffda1a;
        transition: all 0.25s ease;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .navbar-nav-concerto .nav-link:hover::after,
    .navbar-nav-concerto .nav-link.active::after {
        width: 60%;
    }

    .navbar-toggler-concerto {
        border: 1.5px solid rgba(255, 255, 255, 0.35);
        padding: 5px 10px;
        border-radius: 7px;
        background: transparent;
        cursor: pointer;
    }

    .navbar-toggler-concerto:focus {
        outline: none;
        box-shadow: none;
    }

    .toggler-icon-line {
        display: block;
        width: 22px;
        height: 2px;
        background: white;
        border-radius: 2px;
        margin: 4px 0;
        transition: all 0.3s ease;
    }

    @media (max-width: 991px) {
        .navbar-nav-concerto {
            flex-direction: column;
            align-items: stretch;
            padding: 12px 0;
            gap: 2px;
        }

        .navbar-nav-concerto .nav-item {
            margin: 0;
        }

        .navbar-nav-concerto .nav-link {
            padding: 10px 14px;
            border-radius: 7px;
        }

        .navbar-nav-concerto .nav-link::after {
            display: none;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-concerto">
    <div class="container">
        <a class="navbar-brand-concerto" href="<?= base_url() ?>">
            <div class="brand-icon">C</div>
            CONCERTO
        </a>

        <button class="navbar-toggler-concerto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="toggler-icon-line"></span>
            <span class="toggler-icon-line"></span>
            <span class="toggler-icon-line"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav-concerto ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == '' ? 'active' : '' ?>" href="<?= base_url() ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'about' ? 'active' : '' ?>" href="<?= base_url('about') ?>">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'faq' ? 'active' : '' ?>" href="<?= base_url('faq') ?>">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'guide' ? 'active' : '' ?>" href="<?= base_url('guide') ?>">Petunjuk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'bantuan' ? 'active' : '' ?>" href="<?= base_url('bantuan') ?>">Bantuan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'profile' ? 'active' : '' ?>" href="<?= base_url('profile') ?>">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'contact' ? 'active' : '' ?>" href="<?= base_url('contact') ?>">Saran</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
