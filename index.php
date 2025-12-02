<?php
    require_once("private/database.php");
    function RandomAvatar(){
        $photoAreas = array("avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png", "avatar5.png", "avatar6.png", "avatar7.png", "avatar8.png", "avatar9.png", "avatar10.png", "avatar11.png");
        $randomNumber = array_rand($photoAreas);
        echo $photoAreas[$randomNumber];
    }
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LaporPeh! - Layanan Aspirasi</title>
    <link rel="icon" href="images/TeksLogoFix.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/animate.min.css">
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
                    <li class="nav-item"><a class="nav-link active" href="index">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="feed">Semua Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="lihat">Cek Status</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a href="lapor" class="btn btn-nav-cta">Buat Laporan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <span class="hero-tag animate__animated animate__fadeInDown">Layanan Pengaduan Digital</span>
                    <h1 class="hero-title animate__animated animate__zoomIn">
                        Suara Anda,<br>Perubahan Untuk Kita Semua
                    </h1>
                    <p class="text-muted mb-5 fs-5 animate__animated animate__fadeInUp"
                        style="max-width: 700px; margin: 0 auto;">
                        Platform resmi pelaporan masalah kota secara online. Sampaikan aspirasi Anda dengan Cepat,
                        Mudah, dan Terpercaya.
                    </p>
                    <div
                        class="d-flex justify-content-center gap-3 animate__animated animate__fadeInUp delay-1s flex-wrap">
                        <a href="lapor" class="btn btn-primary-custom shadow">
                            <i class="fa fa-pen-nib me-2"></i> Tulis Laporan
                        </a>
                        <a href="lihat" class="btn btn-accent-custom shadow">
                            <i class="fa fa-search me-2"></i> Cek Tiket
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-5 pt-4 g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="card-clean card-compact h-100-card text-center">
                        <div class="mb-3 d-inline-block p-3 rounded-circle bg-primary bg-opacity-10">
                            <i class="fa fa-edit fa-2x text-primary"></i>
                        </div>
                        <h5>1. Tulis Laporan</h5>
                        <p class="text-muted small m-0">Laporkan keluhan dengan jelas melalui formulir digital.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-clean card-compact h-100-card text-center">
                        <div class="mb-3 d-inline-block p-3 rounded-circle bg-warning bg-opacity-10">
                            <i class="fa fa-sync fa-2x text-warning"></i>
                        </div>
                        <h5>2. Tindak Lanjut</h5>
                        <p class="text-muted small m-0">Laporan diverifikasi & diproses oleh dinas terkait.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-clean card-compact h-100-card text-center">
                        <div class="mb-3 d-inline-block p-3 rounded-circle bg-success bg-opacity-10">
                            <i class="fa fa-check-circle fa-2x text-success"></i>
                        </div>
                        <h5>3. Selesai</h5>
                        <p class="text-muted small m-0">Masalah tuntas ditangani dan Anda mendapat notifikasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container pb-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 fw-bold"><i class="fa fa-bullhorn me-2 text-primary"></i> Aspirasi Terkini</h4>
                    <a href="feed" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua <i
                            class="fa fa-arrow-right ms-1"></i></a>
                </div>

                <div class="card-clean p-0 overflow-hidden shadow-sm border-0">
                    <div class="p-4">
                        <?php
                        $stmt = $db->prepare("SELECT * FROM `laporan` ORDER BY id DESC LIMIT 5");
                        $stmt->execute();
                        foreach ($stmt as $key ) {
                            $tanggal = date( 'd M Y, H:i', strtotime($key['tanggal']));
                        ?>
                        <div class="laporan-item">
                            <div class="flex-shrink-0 me-3">
                                <img class="avatar-img" src="images/avatar/<?php RandomAvatar(); ?>" alt="User">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0 fw-bold text-dark"><?php echo htmlspecialchars($key['nama']); ?>
                                    </h6>
                                    <span class="laporan-date"><?php echo $tanggal; ?></span>
                                </div>
                                <p class="mb-0 text-muted"
                                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.95rem;">
                                    <?php echo htmlspecialchars($key['isi']); ?>
                                </p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-clean card-compact bg-white text-center mb-4 border-primary border-top border-4">
                    <h5 class="mb-4 fw-bold">Statistik Laporan</h5>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-3 rounded-3 bg-light border">
                                <h2 class="fw-bold mb-0 text-primary">150+</h2>
                                <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Laporan
                                    Masuk</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 bg-light border">
                                <h2 class="fw-bold mb-0 text-success">90%</h2>
                                <small class="text-muted fw-bold text-uppercase"
                                    style="font-size: 0.7rem;">Selesai</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-clean card-call-center text-start p-4">
                    <i class="fa fa-headset icon-bg"></i>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary me-3 shadow-sm"
                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa fa-phone-alt fs-3"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Call Center</h5>
                            <p class="mb-0 small text-muted">Layanan Darurat 24 Jam</p>
                        </div>
                    </div>
                    <p class="mb-4 text-muted small" style="line-height: 1.6; position: relative; z-index: 2;">
                        Butuh bantuan mendesak? Tim reaksi cepat kami siap membantu anda kapanpun.
                    </p>
                    <a href="tel:112" class="btn btn-call-center w-100 shadow-sm position-relative" style="z-index: 2;">
                        <i class="fa fa-phone me-2"></i> Hubungi 112
                    </a>
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
                        yang terpercaya, transparan, dan akuntabel.
                    </p>
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