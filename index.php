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
                    <li class="nav-item"><a class="nav-link" href="lapor">Buat Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="lihat">Cek Status</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a href="lapor" class="btn btn-nav-cta">Lapor Sekarang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <span class="hero-tag animate__animated animate__fadeInDown">Layanan Pengaduan Digital</span>
                    <h1 class="hero-title animate__animated animate__zoomIn">
                        Suara Anda,<br>Perubahan Untuk Kita Semua
                    </h1>
                    <p class="text-muted mb-4 animate__animated animate__fadeInUp">
                        Platform resmi pelaporan masalah kota secara online. Cepat, Mudah, dan Terpercaya.
                    </p>
                    <div class="d-flex justify-content-center gap-3 animate__animated animate__fadeInUp delay-1s">
                        <a href="lapor" class="btn btn-primary-custom shadow">
                            <i class="fa fa-pen-nib me-2"></i> Tulis Laporan
                        </a>
                        <a href="lihat" class="btn btn-accent-custom shadow">
                            <i class="fa fa-search me-2"></i> Cek Tiket
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-5 g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="card-clean card-compact h-100-card text-center">
                        <i class="fa fa-edit fa-2x text-primary mb-3"></i>
                        <h5>1. Tulis Laporan</h5>
                        <p class="text-muted small m-0">Laporkan keluhan dengan jelas.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-clean card-compact h-100-card text-center">
                        <i class="fa fa-sync fa-2x text-primary mb-3"></i>
                        <h5>2. Tindak Lanjut</h5>
                        <p class="text-muted small m-0">Laporan diverifikasi & diproses.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-clean card-compact h-100-card text-center">
                        <i class="fa fa-check-circle fa-2x text-primary mb-3"></i>
                        <h5>3. Selesai</h5>
                        <p class="text-muted small m-0">Masalah tuntas ditangani.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container pb-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Aspirasi Terkini</h4>
                    <a href="lihat" class="text-decoration-none fw-bold small" style="color: var(--accent);">Lihat Semua
                        <i class="fa fa-arrow-right"></i></a>
                </div>

                <div class="card-clean p-0 overflow-hidden">
                    <div class="p-3">
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
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0"><?php echo htmlspecialchars($key['nama']); ?></h6>
                                    <span class="laporan-date"><?php echo $tanggal; ?></span>
                                </div>
                                <p class="mb-0 small"
                                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?php echo htmlspecialchars($key['isi']); ?>
                                </p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-clean card-compact bg-white text-center mb-4">
                    <h5 class="mb-3">Statistik</h5>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 rounded border bg-light">
                                <h3 class="fw-bold mb-0 text-primary">150+</h3>
                                <small class="text-muted fw-bold" style="font-size: 0.8rem;">MASUK</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded border bg-light">
                                <h3 class="fw-bold mb-0 text-success">90%</h3>
                                <small class="text-muted fw-bold" style="font-size: 0.8rem;">SELESAI</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-clean card-compact text-center text-white border-0"
                    style="background: var(--primary);">
                    <div class="mb-2">
                        <div class="bg-white bg-opacity-10 d-inline-flex p-3 rounded-circle">
                            <i class="fa fa-headset fs-2 text-white"></i>
                        </div>
                    </div>
                    <h5 class="text-white mb-1">Call Center 112</h5>
                    <p class="text-white-50 small mb-3">Layanan darurat 24 Jam.</p>
                    <a href="#" class="btn btn-sm btn-light w-100 rounded-pill text-primary fw-bold">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <img src="images/TeksLogoFix.png" alt="Logo Footer" class="footer-logo-img">
                    <p class="footer-desc pe-lg-5">Layanan aspirasi dan pengaduan masyarakat Palembang yang terpercaya.
                    </p>
                </div>
                <div class="col-lg-3 offset-lg-1 footer-links">
                    <h5 class="footer-heading">Menu</h5>
                    <a href="index">Beranda</a>
                    <a href="lapor">Buat Laporan</a>
                    <a href="lihat">Cek Status</a>
                </div>
                <div class="col-lg-3 footer-links">
                    <h5 class="footer-heading">Kontak</h5>
                    <a href="#"><i class="fa fa-map-marker-alt me-2"></i> Jl. Merdeka No. 1</a>
                    <a href="#"><i class="fa fa-envelope me-2"></i> help@laporpeh.id</a>
                </div>
            </div>
            <div class="border-top border-secondary border-opacity-25 mt-4 pt-4 text-center text-white-50 small">
                &copy; 2025 LaporPeh! All Rights Reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>