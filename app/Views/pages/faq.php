<?= $this->extend('templates/header') ?>

<?= $this->section('content') ?>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header">
    <div class="container">
        <p class="page-label">FAQ</p>
        <h1 class="page-title">Pertanyaan yang Sering Diajukan</h1>
        <div class="title-accent"></div>
        <p class="page-desc">Temukan jawaban untuk pertanyaan umum seputar CONCERTO</p>
    </div>
</div>

<!-- ===== CONTENT ===== -->
<div class="page-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="accordion faq-accordion" id="faqAccordion">

                    <div class="faq-item">
                        <button class="faq-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
                            <span class="faq-num">01</span>
                            Apa itu <em>Computerized Adaptive Testing</em> (CAT)?
                            <i class="bi bi-chevron-down faq-arrow"></i>
                        </button>
                        <div id="faq1" class="collapse show faq-body" data-bs-parent="#faqAccordion">
                            <em>CAT</em> adalah sistem ujian modern yang secara cerdas menyesuaikan tingkat kesulitan soal berdasarkan jawaban peserta tes secara <em>real-time</em>. Sistem ini membantu memberikan pengukuran kemampuan yang lebih akurat dan efisien.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false">
                            <span class="faq-num">02</span>
                            Bagaimana cara kerja asesmen adaptif?
                            <i class="bi bi-chevron-down faq-arrow"></i>
                        </button>
                        <div id="faq2" class="collapse faq-body" data-bs-parent="#faqAccordion">
                            Jika Anda menjawab benar, sistem akan memberikan soal yang lebih sulit. Jika salah, sistem akan memberikan soal yang lebih mudah untuk menyesuaikan dengan kemampuan Anda secara dinamis.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false">
                            <span class="faq-num">03</span>
                            Apakah platform ini cocok untuk semua tingkatan?
                            <i class="bi bi-chevron-down faq-arrow"></i>
                        </button>
                        <div id="faq3" class="collapse faq-body" data-bs-parent="#faqAccordion">
                            Ya, platform ini dirancang untuk siswa dari semua tingkatan, mulai dari pemula hingga lanjutan. Algoritma adaptif akan menyesuaikan soal sesuai tingkat kemampuan masing-masing peserta.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false">
                            <span class="faq-num">04</span>
                            Apakah saya perlu mendaftar untuk menggunakan platform ini?
                            <i class="bi bi-chevron-down faq-arrow"></i>
                        </button>
                        <div id="faq4" class="collapse faq-body" data-bs-parent="#faqAccordion">
                            Ya, Anda perlu membuat akun untuk mengakses fitur asesmen dan melihat laporan hasil. Proses pendaftaran cepat dan mudah.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false">
                            <span class="faq-num">05</span>
                            Bisakah guru membuat soal sendiri?
                            <i class="bi bi-chevron-down faq-arrow"></i>
                        </button>
                        <div id="faq5" class="collapse faq-body" data-bs-parent="#faqAccordion">
                            Guru dapat mengunggah atau menambahkan soal baru ke dalam bank soal, yang nantinya akan disesuaikan secara otomatis oleh sistem <em>CAT</em>.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6" aria-expanded="false">
                            <span class="faq-num">06</span>
                            Bagaimana cara saya melihat hasil asesmen?
                            <i class="bi bi-chevron-down faq-arrow"></i>
                        </button>
                        <div id="faq6" class="collapse faq-body" data-bs-parent="#faqAccordion">
                            Setelah selesai mengerjakan ujian, Anda dapat langsung melihat hasil berupa skor, analisis kemampuan, dan rekomendasi pembelajaran di halaman riwayat ujian.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7" aria-expanded="false">
                            <span class="faq-num">07</span>
                            Apakah asesmen ini berbatas waktu?
                            <i class="bi bi-chevron-down faq-arrow"></i>
                        </button>
                        <div id="faq7" class="collapse faq-body" data-bs-parent="#faqAccordion">
                            Ya, durasi ujian diatur sesuai jenis asesmen yang dipilih. Informasi batas waktu akan ditampilkan sebelum ujian dimulai.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8" aria-expanded="false">
                            <span class="faq-num">08</span>
                            Apakah laporan hasil dapat diunduh?
                            <i class="bi bi-chevron-down faq-arrow"></i>
                        </button>
                        <div id="faq8" class="collapse faq-body" data-bs-parent="#faqAccordion">
                            Ya, laporan hasil ujian dapat diunduh dalam format <em>PDF</em> melalui menu Riwayat Ujian.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9" aria-expanded="false">
                            <span class="faq-num">09</span>
                            Apa yang harus dilakukan jika mengalami masalah teknis?
                            <i class="bi bi-chevron-down faq-arrow"></i>
                        </button>
                        <div id="faq9" class="collapse faq-body" data-bs-parent="#faqAccordion">
                            Segera hubungi pusat bantuan kami melalui menu Bantuan atau kirim <em>email</em> ke tim dukungan teknis kami di abdulsalam@upi.edu.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq10" aria-expanded="false">
                            <span class="faq-num">10</span>
                            Apakah platform ini mendukung ujian selain fisika?
                            <i class="bi bi-chevron-down faq-arrow"></i>
                        </button>
                        <div id="faq10" class="collapse faq-body" data-bs-parent="#faqAccordion">
                            Saat ini platform kami berfokus pada materi fisika. Namun, kami berencana untuk menambahkan mata pelajaran lain di masa mendatang.
                        </div>
                    </div>

                </div>

                <!-- Still have questions -->
                <div class="faq-footer">
                    <p>Masih ada pertanyaan?</p>
                    <a href="<?= base_url('contact') ?>">Hubungi Kami <i class="bi bi-arrow-right"></i></a>
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

    /* ── FAQ Accordion ── */
    .faq-accordion {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 36px;
    }

    .faq-item {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
    }

    .faq-item:has(> .faq-body.show) {
        border-color: #0051ba;
    }

    .faq-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 20px;
        background: transparent;
        border: none;
        text-align: left;
        font-size: .93rem;
        font-weight: 500;
        color: #111827;
        cursor: pointer;
        transition: background .2s;
    }

    .faq-btn:not(.collapsed) {
        color: #0051ba;
        font-weight: 600;
    }

    .faq-btn:hover {
        background: #f9fafb;
    }

    .faq-num {
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .5px;
        color: #0051ba;
        background: #f0f5ff;
        padding: 3px 8px;
        border-radius: 4px;
        flex-shrink: 0;
    }

    .faq-arrow {
        margin-left: auto;
        flex-shrink: 0;
        font-size: .85rem;
        color: #9ca3af;
        transition: transform .25s;
    }

    .faq-btn:not(.collapsed) .faq-arrow {
        transform: rotate(180deg);
        color: #0051ba;
    }

    .faq-body {
        padding: 0 20px 18px 56px;
        font-size: .9rem;
        color: #4b5563;
        line-height: 1.75;
    }

    /* ── FAQ Footer ── */
    .faq-footer {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .faq-footer p {
        font-size: .88rem;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .faq-footer a {
        font-size: .9rem;
        font-weight: 600;
        color: #0051ba;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: gap .2s;
    }

    .faq-footer a:hover {
        gap: 10px;
    }

    @media (max-width: 768px) {
        .page-header { padding: 45px 0 35px; }
        .page-title { font-size: 1.8rem; }
        .faq-body { padding-left: 20px; }
    }
</style>

<?= $this->endSection() ?>
