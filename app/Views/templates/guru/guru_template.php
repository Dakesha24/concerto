<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Phy-FA-CAT</title>

    <link rel="icon" type="image/png" href="<?= base_url('assets/images/icon-cat.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('assets/images/icon-cat.png') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/images/icon-cat.png') ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- tiny MCE -->
    <script src="https://cdn.tiny.cloud/1/8qmtg0msjjyjo95gyqyzxsvhpf40ztljiqeyxuxxc8hgts8y/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.js"></script>
    <style>
        :root {
            --sidebar-width: 280px;
            --navbar-height: 70px;
            --clr-primary: #0051ba;
            --clr-primary-dark: #003d8f;
            --clr-primary-deeper: #001a4f;
            --clr-yellow: #ffda1a;
            --primary-gradient: linear-gradient(135deg, #001a4f 0%, #0051ba 100%);
        }

        body {
            min-height: 100vh;
            background-color: #f4f7fe;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .main-navbar {
            background: var(--primary-gradient);
            height: var(--navbar-height);
            padding: 0.5rem 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1030;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            overflow: visible;
        }

        .main-navbar::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .04) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .main-navbar .navbar-brand {
            color: white;
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: 1px;
            z-index: 1;
        }

        .main-navbar .navbar-brand span {
            color: var(--clr-yellow);
        }

        .main-navbar .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .user-info {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            z-index: 1;
        }

        .profile-dropdown .btn,
        .panduan-dropdown .btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 0.5rem 0.75rem;
            transition: all 0.2s;
        }

        .profile-dropdown .btn:hover,
        .panduan-dropdown .btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .profile-dropdown .dropdown-menu,
        .panduan-dropdown .dropdown-menu {
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-radius: 1rem;
            padding: 0.5rem;
            margin-top: 0.5rem !important;
            z-index: 1050;
        }

        .profile-dropdown .dropdown-item,
        .panduan-dropdown .dropdown-item {
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            color: #475569;
            transition: all 0.2s;
        }

        .profile-dropdown .dropdown-item:hover,
        .panduan-dropdown .dropdown-item:hover {
            background-color: #f1f5f9;
            color: var(--clr-primary);
        }

        .sidebar {
            width: var(--sidebar-width);
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: var(--navbar-height);
            bottom: 0;
            left: 0;
            z-index: 1025;
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link {
            color: #424242;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-radius: 0.5rem;
            margin: 0.2rem 0.8rem;
        }

        .sidebar .nav-link:hover {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .sidebar .nav-link.active {
            background-color: #1565c0;
            color: white;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
            margin-right: 1rem;
        }

        .content-wrapper {
            margin-left: var(--sidebar-width);
            padding: calc(var(--navbar-height) + 1.25rem) 2rem 2rem;
            min-height: calc(100vh - var(--navbar-height));
            transition: margin 0.3s ease;
        }

        .menu-card {
            border: none;
            border-radius: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .menu-card .card-body {
            padding: 2rem;
        }

        .menu-card .icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .content-wrapper {
                margin-left: 0;
                padding: calc(var(--navbar-height) + 1rem) 1.25rem 1.25rem;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .nav-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1020;
                display: none;
            }

            .nav-overlay.show {
                display: block;
            }

            .main-navbar .container-fluid {
                flex-wrap: nowrap !important;
            }

            .main-navbar .navbar-brand {
                font-size: 1.1rem;
                white-space: nowrap;
            }

            .profile-dropdown,
            .panduan-dropdown {
                margin-left: 0.5rem !important;
                margin-right: 0 !important;
            }

            .profile-dropdown .btn,
            .panduan-dropdown .btn {
                padding: 0.4rem 0.6rem;
                font-size: 0.9rem;
            }

            .user-info {
                display: none !important;
            }

            .profile-dropdown .dropdown-menu,
            .panduan-dropdown .dropdown-menu {
                left: auto !important;
                right: 0 !important;
                transform: translateX(0) !important;
                min-width: 180px;
            }
        }

        /* Untuk layar sangat kecil */
        @media (max-width: 576px) {
            .main-navbar {
                padding: 0.5rem 1rem;
            }

            .main-navbar .navbar-brand {
                font-size: 1rem;
            }

            .profile-dropdown .btn,
            .panduan-dropdown .btn {
                padding: 0.3rem 0.5rem;
            }

            .profile-dropdown .dropdown-menu,
            .panduan-dropdown .dropdown-menu {
                min-width: 160px;
                transform: translateX(10px) !important;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar main-navbar fixed-top">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <button class="btn text-white me-3 d-lg-none" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <a class="navbar-brand" href="<?= base_url('guru/dashboard') ?>">
                    <i class="bi bi-mortarboard-fill me-2"></i>
                    <span>CONCERTO</span>
                </a>
            </div>

            <div class="d-flex align-items-center">
                <span class="user-info me-3 d-none d-md-block">
                    Halo, <strong><?= session()->get('username') ?></strong>
                </span>

                <div class="dropdown panduan-dropdown me-2">
                    <button class="btn text-white dropdown-toggle no-caret" type="button" id="panduanDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="panduanDropdown">
                        <li>
                            <h6 class="dropdown-header">Bantuan</h6>
                        </li>
                        <li><a class="dropdown-item" href="https://bit.ly/PanduanPhy-FA-CAT-GURU" target="_blank">
                                <i class="bi bi-file-earmark-text me-2"></i> Panduan Guru
                            </a></li>
                    </ul>
                </div>

                <div class="dropdown profile-dropdown">
                    <button class="btn text-white dropdown-toggle no-caret" type="button" id="profileDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li>
                            <h6 class="dropdown-header">Akun Saya</h6>
                        </li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="nav-overlay" id="navOverlay"></div>

    <div class="sidebar" id="sidebar">
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a href="<?= base_url('guru/dashboard') ?>" class="nav-link <?= current_url() == base_url('guru/dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-house-door"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('guru/jenis-ujian') ?>" class="nav-link <?= current_url() == base_url('guru/jenis-ujian') ? 'active' : '' ?>">
                    <i class="bi bi-journal-text"></i>
                    <span>Mata Pelajaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('guru/bank-soal') ?>" class="nav-link <?= current_url() == base_url('guru/bank-soal') ? 'active' : '' ?>">
                    <i class="bi bi-bank"></i>
                    <span>Bank Soal</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('guru/ujian') ?>" class="nav-link <?= current_url() == base_url('guru/ujian') ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Ujian</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('guru/jadwal-ujian') ?>" class="nav-link <?= current_url() == base_url('guru/jadwal-ujian') ? 'active' : '' ?>">
                    <i class="bi bi-calendar-event"></i>
                    <span>Jadwal Ujian</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('guru/hasil-ujian') ?>" class="nav-link <?= current_url() == base_url('guru/hasil-ujian') ? 'active' : '' ?>">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Hasil Ujian</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('guru/pengumuman') ?>" class="nav-link <?= current_url() == base_url('guru/pengumuman') ? 'active' : '' ?>">
                    <i class="bi bi-megaphone"></i>
                    <span>Pengumuman</span>
                </a>
            </li>
        </ul>
    </div>

    <main class="content-wrapper">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const navOverlay = document.getElementById('navOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                navOverlay.classList.toggle('show');
            }

            sidebarToggle.addEventListener('click', toggleSidebar);
            navOverlay.addEventListener('click', toggleSidebar);
        });
    </script>

</body>

</html>
