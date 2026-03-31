<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header">
    <div class="container">
        <p class="page-label">Tim</p>
        <h1 class="page-title">Tim Pengembang CONCERTO</h1>
        <div class="title-accent"></div>
        <p class="page-desc">Kenali orang-orang di balik platform asesmen adaptif Fisika ini</p>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="page-body">
    <div class="container">
        <div class="row justify-content-center g-4">

            <!-- Pengembang -->
            <div class="col-md-4">
                <div class="team-card">
                    <div class="team-img-wrap">
                        <img src="<?= base_url('assets/images/profil/albert.webp') ?>" alt="Jauza Amalia">
                    </div>
                    <div class="team-body">
                        <p class="team-role">Peneliti &amp; Pengembang</p>
                        <h3 class="team-name">Abdul Salam</h3>
                        <p class="team-institution">Universitas Pendidikan Indonesia</p>
                        <button class="btn-profile" data-bs-toggle="modal" data-bs-target="#developerModal">
                            Lihat Profil <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pembimbing 1 -->
            <div class="col-md-4">
                <div class="team-card">
                    <div class="team-img-wrap">
                        <img src="<?= base_url('assets/images/profil/albert.webp') ?>" alt="Dr. Muslim, M.Pd.">
                    </div>
                    <div class="team-body">
                        <p class="team-role">Pembimbing Penelitian</p>
                        <h3 class="team-name">Pembimbing 1</h3>
                        <p class="team-institution">Universitas Pendidikan Indonesia</p>
                        <button class="btn-profile" data-bs-toggle="modal" data-bs-target="#supervisor1Modal">
                            Lihat Profil <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pembimbing 2 -->
            <div class="col-md-4">
                <div class="team-card">
                    <div class="team-img-wrap">
                        <img src="<?= base_url('assets/images/profil/albert.webp') ?>" alt="Rizki Zakwandi, M.Pd.">
                    </div>
                    <div class="team-body">
                        <p class="team-role">Pembimbing Penelitian</p>
                        <h3 class="team-name">Pembimbing 2</h3>
                        <p class="team-institution">Universitas Pendidikan Indonesia</p>
                        <button class="btn-profile" data-bs-toggle="modal" data-bs-target="#supervisor2Modal">
                            Lihat Profil <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ===== MODAL PENGEMBANG ===== -->
<div class="modal fade" id="developerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content concerto-modal">
            <div class="modal-header concerto-modal-header">
                <h5 class="modal-title">Profil Peneliti &amp; Pengembang</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body concerto-modal-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/images/profil/albert.webp') ?>" class="img-fluid modal-profile-img" alt="Jauza Amalia">
                    </div>
                    <div class="col-md-8">
                        <h4 class="modal-name">Abdul Salam</h4>
                        <p class="modal-role">Mahasiswa Pendidikan Fisika FPMIPA UPI</p>
                        <div class="modal-section">
                            <h6>Tentang</h6>
                            <p>Peneliti yang fokus pada pengembangan asesmen yang adaptif khususnya untuk pembelajaran Fisika.</p>
                        </div>
                        <div class="modal-section">
                            <h6>Pendidikan</h6>
                            <ul class="modal-list">
                                <li>S1 Pendidikan Fisika FPMIPA UPI</li>
                                <li>SMAN Bandung</li>
                            </ul>
                        </div>
                        <div class="modal-section">
                            <h6>Pengalaman</h6>
                            <ul class="modal-list">
                                <li>Staff bem</li>
                                <li>Anggota UKM</li>
                            </ul>
                        </div>
                        <div class="modal-section">
                            <h6>Kontak</h6>
                            <div class="modal-contacts">
                                <a href="mailto:jauzaamalia@upi.edu"><i class="bi bi-envelope-fill"></i> jauzaamalia@upi.edu</a>
                                <a href="https://www.linkedin.com/in/jauza-amalia-906070328/?originalSubdomain=id" target="_blank"><i class="bi bi-linkedin"></i> LinkedIn</a>
                                <a href="https://wa.me/6285794124143" target="_blank"><i class="bi bi-whatsapp"></i> +62 857 9412 4143</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL PEMBIMBING 1 ===== -->
<div class="modal fade" id="supervisor1Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content concerto-modal">
            <div class="modal-header concerto-modal-header">
                <h5 class="modal-title">Profil Pembimbing Penelitian</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body concerto-modal-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/images/profil/albert.webp') ?>" class="img-fluid modal-profile-img" alt="Dr. Muslim">
                    </div>
                    <div class="col-md-8">
                        <h4 class="modal-name">Pembimbing 1</h4>
                        <p class="modal-role">Dosen Jurusan Pendidikan Fisika FPMIPA UPI</p>
                        <div class="modal-section">
                            <h6>Tentang</h6>
                            <p>Memiliki kontribusi dalam pengembangan asesmen serta model pembelajaran, khususnya yang menekankan pada kemampuan argumentasi dan pendekatan berbasis simulasi serta eksperimen virtual.</p>
                        </div>
                        <div class="modal-section">
                            <h6>Bidang Keahlian</h6>
                            <ul class="modal-list">
                                <li>Argumentasi</li>
                                <li>Asesmen</li>
                                <li>Model Pembelajaran</li>
                            </ul>
                        </div>
                        <div class="modal-section">
                            <h6>Publikasi Terpilih</h6>
                            <ul class="modal-list">
                                <li><em>Evaluating Students' Argumentation Skills Using an Argument-Generating Learning Model (2024)</em></li>
                                <li>Pemanfaatan Buku Ajar Elektronik Interaktif untuk Pembangunan Berkelanjutan (2024)</li>
                                <li><em>The Implementation of STEM-PBL Learning to Enhance Students' Critical Thinking Skills (2024)</em></li>
                            </ul>
                        </div>
                        <div class="modal-section">
                            <h6>Kontak</h6>
                            <div class="modal-contacts">
                                <a href="mailto:muslim@upi.edu"><i class="bi bi-envelope-fill"></i> albert@upi.edu</a>
                                <a href="https://sinta.kemdikbud.go.id/authors/profile/6028471" target="_blank"><i class="bi bi-diagram-3"></i> Publikasi SINTA</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL PEMBIMBING 2 ===== -->
<div class="modal fade" id="supervisor2Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content concerto-modal">
            <div class="modal-header concerto-modal-header">
                <h5 class="modal-title">Profil Pembimbing Penelitian</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body concerto-modal-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/images/profil/albert.webp') ?>" class="img-fluid modal-profile-img" alt="Rizki Zakwandi">
                    </div>
                    <div class="col-md-8">
                        <h4 class="modal-name">Pembimbing 2</h4>
                        <p class="modal-role">Dosen Jurusan Pendidikan Fisika FPMIPA UPI</p>
                        <div class="modal-section">
                            <h6>Tentang</h6>
                            <p>Memiliki kontribusi dalam pengembangan metode asesmen yang inovatif dan media pembelajaran berbasis teknologi adaptif.</p>
                        </div>
                        <div class="modal-section">
                            <h6>Bidang Keahlian</h6>
                            <ul class="modal-list">
                                <li><em>Digital Learning</em></li>
                                <li><em>Educational Technology</em></li>
                                <li><em>Assessment Model</em></li>
                            </ul>
                        </div>
                        <div class="modal-section">
                            <h6>Riset Terkini</h6>
                            <ul class="modal-list">
                                <li><em>A Two-Tier Computerized Adaptive Test to Measure Student Computational Thinking Skills (2024)</em></li>
                                <li><em>The Impact of Problem Solving Laboratory in Physics Learning (2024)</em></li>
                                <li><em>A Framework for Assessing Computational Thinking Skills in the Physics Classroom (2023)</em></li>
                            </ul>
                        </div>
                        <div class="modal-section">
                            <h6>Kontak</h6>
                            <div class="modal-contacts">
                                <a href="mailto:r.zakwandi@upi.edu"><i class="bi bi-envelope-fill"></i> albert@upi.edu</a>
                                <a href="https://sinta.kemdikbud.go.id/authors/profile/6854652" target="_blank"><i class="bi bi-diagram-3"></i> Publikasi SINTA</a>
                            </div>
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

    /* ── Team Cards ── */
    .team-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        transition: all .3s;
    }

    .team-card:hover {
        border-color: #0051ba;
        box-shadow: 0 8px 28px rgba(0,81,186,.1);
        transform: translateY(-4px);
    }

    .team-img-wrap {
        overflow: hidden;
        height: 260px;
    }

    .team-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s;
    }

    .team-card:hover .team-img-wrap img {
        transform: scale(1.04);
    }

    .team-body {
        padding: 22px 22px 24px;
        border-top: 2px solid #0051ba;
    }

    .team-role {
        font-size: .75rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #0051ba;
        margin-bottom: 6px;
    }

    .team-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .team-institution {
        font-size: .83rem;
        color: #6b7280;
        margin-bottom: 16px;
    }

    .btn-profile {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: none;
        border: none;
        color: #0051ba;
        font-size: .88rem;
        font-weight: 600;
        padding: 0;
        cursor: pointer;
        transition: gap .2s;
    }

    .btn-profile:hover { gap: 10px; }

    /* ── Modal ── */
    .concerto-modal {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .concerto-modal-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .concerto-modal-header .modal-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .btn-close-modal {
        background: #f3f4f6;
        border: none;
        color: #6b7280;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
        cursor: pointer;
        transition: background .2s;
    }

    .btn-close-modal:hover { background: #e5e7eb; color: #111827; }

    .concerto-modal-body {
        padding: 28px;
        background: #fff;
    }

    .modal-profile-img {
        border-radius: 10px;
        width: 100%;
        display: block;
    }

    .modal-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 4px;
    }

    .modal-role {
        font-size: .85rem;
        color: #0051ba;
        font-weight: 600;
        margin-bottom: 22px;
    }

    .modal-section {
        margin-bottom: 18px;
        padding-bottom: 18px;
        border-bottom: 1px solid #f3f4f6;
    }

    .modal-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .modal-section h6 {
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #9ca3af;
        margin-bottom: 8px;
    }

    .modal-section p {
        font-size: .88rem;
        color: #4b5563;
        line-height: 1.7;
        margin: 0;
    }

    .modal-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .modal-list li {
        font-size: .87rem;
        color: #4b5563;
        padding-left: 14px;
        position: relative;
        line-height: 1.6;
    }

    .modal-list li::before {
        content: '·';
        position: absolute;
        left: 3px;
        color: #0051ba;
        font-weight: 700;
    }

    .modal-contacts {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .modal-contacts a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .87rem;
        color: #0051ba;
        text-decoration: none;
        font-weight: 500;
        transition: color .2s;
    }

    .modal-contacts a:hover { color: #003d8f; }

    @media (max-width: 768px) {
        .page-header { padding: 45px 0 35px; }
        .page-title { font-size: 1.8rem; }
        .page-body { padding: 45px 0; }
        .concerto-modal-body { padding: 20px; }
        .modal-profile-img { margin-bottom: 16px; }
    }
</style>

<?= $this->endSection() ?>
