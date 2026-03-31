<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Phy-FA-CAT</title>

    <link rel="icon" type="image/png" href="<?= base_url('assets/images/icon-cat.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('assets/images/icon-cat.png') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/images/icon-cat.png') ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 280px;
            --navbar-height: 70px;
            --clr-primary: #0051ba;
            --clr-primary-dark: #003d8f;
            --clr-primary-deeper: #001a4f;
            --clr-blue-light: #e1fffc;
            --clr-yellow: #ffda1a;
            --clr-yellow-dark: #e5c300;
            --primary-gradient: linear-gradient(135deg, #001a4f 0%, #0051ba 100%);
        }

        body {
            min-height: 100vh;
            background-color: #f4f7fe;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* Navbar Styles */
        .main-navbar {
            background: var(--primary-gradient);
            height: var(--navbar-height);
            padding: 0.5rem 1.5rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
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

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: var(--navbar-height);
            bottom: 0;
            left: 0;
            z-index: 1025;
            transition: transform 0.3s ease;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar .nav-link {
            color: #64748b;
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-radius: 0.75rem;
            margin: 0.4rem 1rem;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            background-color: #f0f7ff;
            color: var(--clr-primary);
        }

        .sidebar .nav-link.active {
            background-color: var(--clr-primary);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 81, 186, 0.25);
        }

        .sidebar .nav-link i {
            font-size: 1.25rem;
            margin-right: 1rem;
        }

        /* Content Wrapper */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            padding: calc(var(--navbar-height) + 1.5rem) 2.5rem 2.5rem;
            min-height: calc(100vh - var(--navbar-height));
            transition: margin 0.3s ease;
        }

        /* Menu Cards */
        .menu-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 1.25rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
            overflow: hidden;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: var(--clr-primary);
        }

        .menu-card .card-body {
            padding: 2.5rem 2rem;
        }

        .menu-card .icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.75rem;
            transition: all 0.3s ease;
        }

        .menu-card:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .menu-card .card-title {
            font-weight: 700;
            color: var(--clr-primary-deeper);
        }

        /* Profile Dropdown */
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

        .profile-dropdown .btn, .panduan-dropdown .btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 0.5rem 0.75rem;
            transition: all 0.2s;
        }

        .profile-dropdown .btn:hover, .panduan-dropdown .btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Mobile Responsiveness */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .content-wrapper {
                margin-left: 0;
                padding: calc(var(--navbar-height) + 1rem) 1.5rem 1.5rem;
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
                background: rgba(0, 0, 0, 0.4);
                backdrop-filter: blur(4px);
                z-index: 1020;
                display: none;
            }

            .nav-overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar main-navbar fixed-top">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <button class="btn text-white me-3 d-lg-none" id="sidebarToggle" style="z-index: 2;">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <a class="navbar-brand" href="<?= base_url('siswa/dashboard') ?>">
                    <i class="bi bi-mortarboard-fill me-2"></i>
                    <span>CONCERTO</span>
                </a>
            </div>

            <div class="d-flex align-items-center">
                <span class="user-info me-3 d-none d-md-block">
                    Halo, <strong><?= session()->get('username') ?></strong>
                </span>
                
                <!-- Dropdown Panduan -->
                <div class="dropdown panduan-dropdown me-2">
                    <button class="btn text-white dropdown-toggle no-caret" type="button" id="panduanDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-question-circle fs-5"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="panduanDropdown">
                        <li>
                            <h6 class="dropdown-header">Bantuan</h6>
                        </li>
                        <li><a class="dropdown-item" href="https://bit.ly/PanduanPenggunaanPhy-FA-CAT-Siswa" target="_blank">
                                <i class="bi bi-file-earmark-text me-2"></i> Panduan Siswa
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
                        <li><a class="dropdown-item" href="<?= base_url('siswa/profil') ?>">
                                <i class="bi bi-person me-2"></i> Profil
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Overlay -->
    <div class="nav-overlay" id="navOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a href="<?= base_url('siswa/dashboard') ?>" class="nav-link <?= current_url() == base_url('siswa/dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-house-door"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('siswa/pengumuman') ?>" class="nav-link <?= current_url() == base_url('siswa/pengumuman') ? 'active' : '' ?>">
                    <i class="bi bi-megaphone"></i>
                    <span>Pengumuman</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('siswa/ujian') ?>" class="nav-link <?= current_url() == base_url('siswa/ujian') ? 'active' : '' ?>">
                    <i class="bi bi-journal-text"></i>
                    <span>Ujian</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('siswa/hasil') ?>" class="nav-link <?= current_url() == base_url('siswa/hasil') ? 'active' : '' ?>">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Hasil Ujian</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
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

            // Toggle sidebar
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
