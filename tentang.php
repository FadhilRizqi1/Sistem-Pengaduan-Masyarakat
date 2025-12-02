<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami | LaporPeh!</title>
    <link rel="icon" href="images/TeksLogoFix.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div id="preloader">
        <div class="loader-container">
            <img src="images/TeksLogoFix.png" alt="LaporPeh!" class="loader-logo">
            <div class="loader-spinner"></div>
            <p class="text-muted small mt-3 fw-bold">Memuat...</p>
        </div>
    </div>

    <script>
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        setTimeout(() => {
            preloader.classList.add('hide');
        }, 500);
    });
    </script>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index">
                <img src="images/TeksLogoFix.png" alt="LaporPeh!">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="fa fa-bars text-white fs-4"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="feed">Semua Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="lihat">Cek Status</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a href="lapor" class="btn btn-nav-cta">Buat Laporan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-header">
        <div class="container">
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill mb-3 fw-bold">PROFIL INSTANSI</span>
            <h1 class="fw-bold mb-3">Tentang LaporPeh!</h1>
            <p class="opacity-75 lead" style="max-width: 600px; margin: 0 auto;">Mengenal lebih dekat sistem pelayanan
                pengaduan masyarakat kota Palembang.</p>
        </div>
    </div>

    <div class="container pb-5" style="margin-top: -80px;">

        <div class="card-clean border-0 shadow-lg mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="images/screenshot_home_placeholder.png" class="img-fluid img-tentang" alt="Tentang Kami">
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h2 class="fw-bold text-primary mb-3">Visi & Misi</h2>
                    <p class="text-muted lead mb-4">Mewujudkan pelayanan publik yang prima, transparan, dan akuntabel
                        melalui teknologi digital yang terintegrasi.</p>

                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fa fa-check-circle text-success fs-4 me-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Respon Cepat</h5>
                            <p class="text-muted small">Menangani setiap laporan masyarakat dengan segera dan
                                profesional.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fa fa-check-circle text-success fs-4 me-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Transparansi Data</h5>
                            <p class="text-muted small">Publik dapat memantau progres penyelesaian masalah secara
                                realtime.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fa fa-check-circle text-success fs-4 me-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Mudah Diakses</h5>
                            <p class="text-muted small">Platform tersedia 24 jam untuk seluruh lapisan masyarakat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary">Tata Cara Melapor</h3>
                <p class="text-muted">Ikuti 4 langkah mudah untuk menyampaikan aspirasi Anda.</p>
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="step-card h-100">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-3">
                            <i class="fa fa-pen-fancy fs-4"></i>
                        </div>
                        <h6 class="fw-bold">1. Tulis Laporan</h6>
                        <p class="small text-muted mb-0">Isi formulir pengaduan dengan data valid dan jelas.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card h-100">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex p-3 mb-3">
                            <i class="fa fa-search fs-4"></i>
                        </div>
                        <h6 class="fw-bold">2. Verifikasi</h6>
                        <p class="small text-muted mb-0">Admin akan memverifikasi dan meneruskan laporan.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card h-100">
                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex p-3 mb-3">
                            <i class="fa fa-tools fs-4"></i>
                        </div>
                        <h6 class="fw-bold">3. Tindak Lanjut</h6>
                        <p class="small text-muted mb-0">Instansi terkait menangani masalah di lapangan.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card h-100">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex p-3 mb-3">
                            <i class="fa fa-check fs-4"></i>
                        </div>
                        <h6 class="fw-bold">4. Selesai</h6>
                        <p class="small text-muted mb-0">Laporan ditutup dan Anda menerima notifikasi.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Sering Ditanyakan (FAQ)</h3>
                    <p class="text-muted">Jawaban atas pertanyaan yang sering diajukan masyarakat.</p>
                </div>

                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq1">
                                Apakah identitas pelapor aman?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                <strong>Sangat Aman.</strong> Kami menjamin kerahasiaan data diri pelapor. Anda juga
                                dapat menggunakan fitur "Anonim" jika tidak ingin nama Anda dipublikasikan pada feed
                                laporan.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq2">
                                Berapa lama laporan akan diproses?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Waktu penyelesaian bervariasi tergantung kompleksitas masalah. Namun, admin kami akan
                                memverifikasi laporan masuk maksimal dalam <strong>1x24 jam</strong> hari kerja.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq3">
                                Apa saja yang bisa dilaporkan?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Anda dapat melaporkan segala hal yang berkaitan dengan pelayanan publik, fasilitas umum
                                rusak (jalan berlubang, lampu mati), masalah kebersihan, keamanan, dan administrasi
                                kependudukan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <img src="images/TeksLogoFix.png" alt="Logo Footer" class="footer-logo-img">
                    <p class="footer-desc pe-lg-5 text-white-50">Layanan aspirasi dan pengaduan masyarakat Palembang
                        yang terpercaya, transparan, dan akuntabel.</p>
                </div>
                <div class="col-lg-3 offset-lg-1 footer-links">
                    <h5 class="footer-heading">Navigasi</h5>
                    <a href="index">Beranda</a>
                    <a href="tentang">Tentang Kami</a>
                    <a href="feed">Semua Laporan</a>
                    <a href="lihat">Cek Status</a>
                </div>
                <div class="col-lg-3 footer-links">
                    <h5 class="footer-heading">Hubungi Kami</h5>
                    <a href="#"><i class="fa fa-map-marker-alt me-2 text-warning"></i> Jl. Merdeka No. 1</a>
                    <a href="#"><i class="fa fa-envelope me-2 text-warning"></i> help@laporpeh.id</a>
                    <a href="#"><i class="fa fa-phone me-2 text-warning"></i> (0711) 123456</a>
                </div>
            </div>
            <div class="border-top border-white border-opacity-10 mt-5 pt-4 text-center text-white-50 small">
                &copy; 2025 LaporPeh! All Rights Reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>