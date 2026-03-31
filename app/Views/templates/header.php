<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONCERTO</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/icon-cat.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('assets/images/icon-cat.png') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/images/icon-cat.png') ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            --clr-primary: #0051ba;
            --clr-primary-dark: #003d8f;
            --clr-primary-deeper: #001a4f;
            --clr-blue-light: #e1fffc;
            --clr-yellow: #ffda1a;
            --clr-yellow-dark: #e5c300;
            --clr-gray: #eae7e7;
            --clr-gray-dark: #b5b2b2;
            --clr-text: #1a1a2e;
            --clr-text-muted: #5a5a6e;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--clr-text);
            background-color: #ffffff;
        }

        /* Global hero section defaults */
        .hero-section {
            background-color: var(--clr-primary);
            padding: 100px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -80px;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: -60px;
            width: 350px;
            height: 350px;
            background: rgba(255, 218, 26, 0.06);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-section .text-section {
            z-index: 2;
            position: relative;
        }

        .hero-section .hero-image-section {
            z-index: 2;
            position: relative;
        }

        .hero-image {
            max-width: 85%;
            height: auto;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        }

        .title-hero {
            font-weight: 800;
            line-height: 1.15;
        }

        /* Hero Buttons */
        .hero-section .btn-primary {
            background-color: var(--clr-yellow);
            color: var(--clr-primary-deeper);
            border: none;
            font-weight: 700;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
        }

        .hero-section .btn-primary:hover {
            background-color: var(--clr-yellow-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 218, 26, 0.45);
            color: var(--clr-primary-deeper);
        }

        .hero-section .btn-outline-primary {
            background-color: transparent;
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.6);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .hero-section .btn-outline-primary:hover {
            background-color: rgba(255, 255, 255, 0.12);
            border-color: white;
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Reusable utility classes */
        .section-badge {
            display: inline-block;
            background: var(--clr-blue-light);
            color: var(--clr-primary);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 5px 14px;
            border-radius: 50px;
            margin-bottom: 12px;
        }

        .section-title-dark {
            font-size: 2rem;
            font-weight: 800;
            color: var(--clr-primary-deeper);
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
                text-align: center;
            }

            .hero-section .row {
                flex-direction: column-reverse;
            }

            .hero-image-section {
                margin-bottom: 30px;
            }

            .hero-buttons {
                justify-content: center !important;
            }
        }
    </style>
</head>

<body>
    <?= $this->include('templates/navbar') ?>

    <?= $this->renderSection('content') ?>

    <?= $this->include('templates/footer') ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
