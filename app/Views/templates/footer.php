<footer class="footer-concerto">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mb-4">
                <div class="footer-brand">
                    <div class="footer-brand-icon">C</div>
                    <span class="footer-brand-name">CONCERTO</span>
                </div>
                <p class="footer-description">
                    Platform asesmen adaptif berbasis web yang menggunakan algoritma <i>Computerized Adaptive Testing</i>, dirancang untuk mengukur kemampuan berpikir kritis peserta tes khususnya pada bidang Fisika secara akurat, efisien, dan adaptif.
                </p>
                <div class="footer-social">
                    <a href="https://www.instagram.com/phyfacat/" class="footer-social-link" target="_blank" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/jauza-amalia-906070328/?originalSubdomain=id" class="footer-social-link" target="_blank" title="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 ms-auto">
                <h5 class="footer-subtitle">Alamat</h5>
                <ul class="footer-contact-list">
                    <li>
                        <i class="bi bi-geo-alt-fill"></i>
                        <a href="https://www.google.com/maps/search/?api=1&query=Universitas+Pendidikan+Indonesia,+Jl.+Dr.+Setiabudi+No.229,+Isola,+Kec.+Sukasari,+Kota+Bandung,+Jawa+Barat+40154" target="_blank" rel="noopener noreferrer">
                            Universitas Pendidikan Indonesia.<br>
                            Jl. Dr. Setiabudi No.229, Isola, Kec. Sukasari, Kota Bandung, Jawa Barat 40154
                        </a>
                    </li>
                    <li>
                        <i class="bi bi-envelope-fill"></i>
                        <a href="mailto:jauzaamalia@upi.edu">jauzaamalia@upi.edu</a>
                    </li>
                    <li>
                        <i class="bi bi-map-fill"></i>
                        <a href="https://fisika.upi.edu/akademik/pendidikan-fisika/" target="_blank" rel="noopener noreferrer">
                            Pendidikan Fisika UPI
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-divider"></div>

        <div class="row footer-bottom-row align-items-center">
            <div class="col-md-6">
                <p class="footer-copyright">&copy; <?= date('Y') ?> CONCERTO. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="footer-legal-link">Kebijakan Privasi</a>
                <a href="#" class="footer-legal-link">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-concerto {
        background: linear-gradient(180deg, #001a4f 0%, #000e2e 100%);
        color: #fff;
        padding: 65px 0 30px;
    }

    .footer-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }

    .footer-brand-icon {
        background-color: #ffda1a;
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

    .footer-brand-name {
        font-weight: 800;
        font-size: 1.35rem;
        letter-spacing: 2.5px;
        color: white;
    }

    .footer-description {
        color: rgba(255, 255, 255, 0.65);
        line-height: 1.75;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .footer-social {
        display: flex;
        gap: 10px;
        margin-top: 8px;
    }

    .footer-social-link {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer-social-link:hover {
        background: #ffda1a;
        color: #001a4f;
        transform: translateY(-3px);
    }

    .footer-subtitle {
        color: #ffda1a;
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 20px;
    }

    .footer-contact-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-contact-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 14px;
        font-size: 0.88rem;
        line-height: 1.65;
    }

    .footer-contact-list li i {
        color: #ffda1a;
        margin-top: 3px;
        flex-shrink: 0;
        font-size: 0.9rem;
    }

    .footer-contact-list a {
        color: rgba(255, 255, 255, 0.65);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .footer-contact-list a:hover {
        color: #ffda1a;
    }

    .footer-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        margin: 30px 0;
    }

    .footer-bottom-row {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.83rem;
    }

    .footer-copyright {
        margin: 0;
    }

    .footer-legal-link {
        color: rgba(255, 255, 255, 0.4);
        text-decoration: none;
        margin-left: 20px;
        font-size: 0.83rem;
        transition: color 0.2s ease;
    }

    .footer-legal-link:hover {
        color: #ffda1a;
    }

    @media (max-width: 768px) {
        .footer-concerto {
            padding: 45px 0 25px;
        }

        .footer-bottom-row {
            text-align: center;
        }

        .footer-legal-link {
            display: inline-block;
            margin: 6px 10px 0;
        }
    }
</style>
