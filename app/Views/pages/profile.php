<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header">
    <div class="container">
        <p class="page-label">Tim</p>
        <h1 class="page-title">Tim Pengembang ADAPT-CT</h1>
        <div class="title-accent"></div>
        <p class="page-desc">Kenali orang-orang di balik platform asesmen adaptif Fisika ini</p>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="page-body">
    <div class="container">
        <div class="row justify-content-center g-4">

            <!-- Card: Peneliti & Pengembang 1 -->
            <div class="col-md-4">
                <div class="profile-card">
                    <div class="profile-card-img">
                        <img src="<?= base_url('assets/images/profil/pengembang1.png') ?>" alt="Lina Aviyanti">
                    </div>
                    <div class="profile-card-body">
                        <span class="profile-card-role">Peneliti &amp; Pengembang 1</span>
                        <h3 class="profile-card-name">Lina Aviyanti, S.Pd., M.Si., Ph.D.</h3>
                        <p class="profile-card-inst">Dosen Program Studi Pendidikan Fisika UPI</p>
                        <button class="profile-card-btn" data-bs-toggle="modal" data-bs-target="#supervisor1Modal">
                            Lihat Profil <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card: Peneliti & Pengembang 2 -->
            <div class="col-md-4">
                <div class="profile-card">
                    <div class="profile-card-img">
                        <img src="<?= base_url('assets/images/profil/pengembang2.png') ?>" alt="Abdul Salam">
                    </div>
                    <div class="profile-card-body">
                        <span class="profile-card-role">Peneliti &amp; Pengembang 2</span>
                        <h3 class="profile-card-name">Abdul Salam</h3>
                        <p class="profile-card-inst">Mahasiswa Program Studi Pendidikan Fisika UPI</p>
                        <button class="profile-card-btn" data-bs-toggle="modal" data-bs-target="#developerModal">
                            Lihat Profil <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ===== MODAL: Peneliti & Pengembang 1 ===== -->
<div class="modal fade" id="supervisor1Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content profile-modal">
            <button type="button" class="modal-close-btn" data-bs-dismiss="modal">
                <i class="bi bi-x-lg"></i>
            </button>
            <div class="modal-body profile-modal-body">
                <div class="row g-0">
                    <div class="col-lg-5">
                        <div class="modal-img-wrap">
                            <img src="<?= base_url('assets/images/profil/pengembang1.png') ?>" alt="Lina Aviyanti">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="modal-info">
                            <span class="modal-info-badge">Peneliti &amp; Pengembang 1</span>
                            <h2 class="modal-info-name">Lina Aviyanti, S.Pd., M.Si., Ph.D.</h2>
                            <p class="modal-info-role">Dosen Jurusan Pendidikan Fisika FPMIPA UPI</p>

                            <div class="modal-section">
                                <h4 class="modal-section-title">Tentang</h4>
                                <p>Memiliki kontribusi dalam pengembangan asesmen dan model pembelajaran interaktif untuk meningkatkan keterampilan berpikir kritis siswa.</p>
                            </div>

                            <div class="modal-section">
                                <h4 class="modal-section-title">Bidang Keahlian</h4>
                                <div class="modal-tags">
                                    <span>Assessment</span>
                                    <span>Model Pembelajaran</span>
                                    <span>Pembelajaran Fisika</span>
                                </div>
                            </div>

                            <div class="modal-section">
                                <h4 class="modal-section-title">Publikasi Terpilih</h4>
                                <ul class="modal-pubs">
                                    <li><em>Enhancing Students' Critical Thinking Skills through IMOREAR: An AR-Based Renewable Energy Module</em></li>
                                    <li>Can Multiple-Choice Items Measure Critical Thinking in Socio-Scientific Environmental Issues? Evidence from a Global Warming Assessment of Grade 10 Students Using Rasch Analysis</li>
                                    <li><em>Exploring HOTS on global warming concepts, self-efficacy and learning motivation among high school students</em></li>
                                </ul>
                            </div>

                            <div class="modal-section">
                                <h4 class="modal-section-title">Kontak</h4>
                                <div class="modal-links">
                                    <a href="mailto:lina@upi.edu"><i class="bi bi-envelope"></i> lina@upi.edu</a>
                                    <a href="https://sinta.kemdiktisaintek.go.id/authors/profile/6735786/?view=books" target="_blank"><i class="bi bi-journal-text"></i> SINTA</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL: Peneliti & Pengembang 2 ===== -->
<div class="modal fade" id="developerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content profile-modal">
            <button type="button" class="modal-close-btn" data-bs-dismiss="modal">
                <i class="bi bi-x-lg"></i>
            </button>
            <div class="modal-body profile-modal-body">
                <div class="row g-0">
                    <div class="col-lg-5">
                        <div class="modal-img-wrap">
                            <img src="<?= base_url('assets/images/profil/pengembang2.png') ?>" alt="Abdul Salam">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="modal-info">
                            <span class="modal-info-badge">Peneliti &amp; Pengembang 2</span>
                            <h2 class="modal-info-name">Abdul Salam</h2>
                            <p class="modal-info-role">Mahasiswa Program Studi Pendidikan Fisika UPI</p>

                            <div class="modal-section">
                                <h4 class="modal-section-title">Tentang</h4>
                                <p>Peneliti yang berfokus pada pengembangan asesmen berpikir kritis, media asesmen, dan analisis psikometrik asesmen.</p>
                            </div>

                            <div class="modal-section">
                                <h4 class="modal-section-title">Bidang Keahlian</h4>
                                <div class="modal-tags">
                                    <span>Assessment</span>
                                    <span>Critical Thinking Skills</span>
                                </div>
                            </div>

                            <div class="modal-section">
                                <h4 class="modal-section-title">Publikasi Terpilih</h4>
                                <ul class="modal-pubs">
                                    <li><em>Assessing students' critical thinking skills in physics learning: a Rasch model analysis</em></li>
                                </ul>
                            </div>

                            <div class="modal-section">
                                <h4 class="modal-section-title">Kontak</h4>
                                <div class="modal-links">
                                    <a href="mailto:abdulsalam@upi.edu"><i class="bi bi-envelope"></i> abdulsalam@upi.edu</a>
                                    <a href="https://www.linkedin.com/in/abdul-salam-09512b382/" target="_blank"><i class="bi bi-linkedin"></i> LinkedIn</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ═══════════════ PAGE HEADER ═══════════════ */
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

    /* ═══════════════ PAGE BODY ═══════════════ */
    .page-body {
        background: #fafafa;
        padding: 64px 0 72px;
    }

    /* ═══════════════ PROFILE CARDS ═══════════════ */
    .profile-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        transition: all .35s ease;
        height: 100%;
    }

    .profile-card:hover {
        border-color: #0051ba;
        box-shadow: 0 10px 28px rgba(0,81,186,.1);
        transform: translateY(-4px);
    }

    .profile-card-img {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background: #f3f4f6;
    }

    .profile-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .profile-card:hover .profile-card-img img {
        transform: scale(1.06);
    }

    .profile-card-body {
        padding: 20px 22px 22px;
    }

    .profile-card-role {
        display: inline-block;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #0051ba;
        margin-bottom: 10px;
    }

    .profile-card-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 5px;
        line-height: 1.35;
    }

    .profile-card-inst {
        font-size: .86rem;
        color: #6b7280;
        margin-bottom: 16px;
        line-height: 1.55;
    }

    .profile-card-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: none;
        border: none;
        color: #0051ba;
        font-size: .86rem;
        font-weight: 600;
        padding: 0;
        cursor: pointer;
        transition: gap .2s, color .2s;
    }

    .profile-card-btn:hover {
        gap: 10px;
        color: #003d8f;
    }

    /* ═══════════════ MODAL ═══════════════ */
    .profile-modal {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 25px 70px rgba(0,0,0,.15);
    }

    .modal-close-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 10;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: rgba(0,0,0,.5);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .85rem;
        cursor: pointer;
        transition: background .2s;
        backdrop-filter: blur(4px);
    }

    .modal-close-btn:hover {
        background: rgba(0,0,0,.7);
    }

    .profile-modal-body {
        padding: 0;
    }

    .modal-img-wrap {
        height: 100%;
        background: #f8fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px;
    }

    .modal-img-wrap img {
        width: 100%;
        max-height: 360px;
        object-fit: contain;
        display: block;
        border-radius: 10px;
        box-shadow: 0 4px 16px rgba(0,0,0,.06);
    }

    .modal-info {
        padding: 36px 32px;
    }

    .modal-info-badge {
        display: inline-block;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: #0051ba;
        background: #f0f5ff;
        padding: 4px 12px;
        border-radius: 4px;
        margin-bottom: 14px;
    }

    .modal-info-name {
        font-size: 1.4rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .modal-info-role {
        font-size: .87rem;
        color: #6b7280;
        margin-bottom: 26px;
        line-height: 1.5;
    }

    .modal-section {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .modal-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .modal-section-title {
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: #9ca3af;
        margin-bottom: 10px;
    }

    .modal-section p {
        font-size: .89rem;
        color: #374151;
        line-height: 1.75;
        margin: 0;
    }

    .modal-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .modal-tags span {
        font-size: .82rem;
        color: #374151;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        padding: 5px 12px;
        border-radius: 6px;
        line-height: 1.4;
    }

    .modal-pubs {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .modal-pubs li {
        font-size: .87rem;
        color: #4b5563;
        padding-left: 16px;
        position: relative;
        line-height: 1.65;
    }

    .modal-pubs li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 9px;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #0051ba;
    }

    .modal-links {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .modal-links a {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: .87rem;
        font-weight: 500;
        color: #0051ba;
        text-decoration: none;
        transition: color .2s;
    }

    .modal-links a:hover {
        color: #003d8f;
    }

    .modal-links a i {
        font-size: .95rem;
    }

    /* ═══════════════ RESPONSIVE ═══════════════ */
    @media (max-width: 991px) {
        .modal-img-wrap {
            padding: 24px;
        }

        .modal-img-wrap img {
            max-height: 260px;
        }

        .modal-info {
            padding: 28px 24px;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 44px 0 36px;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .page-body {
            padding: 40px 0 52px;
        }

        .profile-card-img {
            aspect-ratio: 3 / 2;
        }

        .modal-info {
            padding: 24px 18px;
        }

        .modal-info-name {
            font-size: 1.2rem;
        }
    }
</style>

<?= $this->endSection() ?>
