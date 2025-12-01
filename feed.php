<?php
require_once("private/database.php");
function RandomAvatar(){
    $photoAreas = array("avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png", "avatar5.png", "avatar6.png", "avatar7.png", "avatar8.png", "avatar9.png", "avatar10.png", "avatar11.png");
    $randomNumber = array_rand($photoAreas);
    echo $photoAreas[$randomNumber];
}

// Ambil semua data laporan dari yang terbaru
$stmt = $db->prepare("SELECT * FROM laporan ORDER BY id DESC");
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semua Laporan | LaporPeh!</title>
    <link rel="icon" href="images/TeksLogoFix.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
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
                    <li class="nav-item"><a class="nav-link" href="index">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link active" href="feed">Semua Laporan</a></li>
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
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill mb-3 fw-bold">FEED PUBLIK</span>
            <h1 class="fw-bold mb-3">Laporan Masyarakat</h1>
            <p class="opacity-75 lead" style="max-width: 600px; margin: 0 auto;">Transparansi adalah prioritas kami.
                Berikut adalah daftar aspirasi yang masuk.</p>
        </div>
    </div>

    <div class="container pb-8" style="margin-bottom: 50px;">
        <div class="row g-4">
            <?php foreach ($stmt as $key) { 
                $tanggal = date('d F Y', strtotime($key['tanggal']));
                
                // --- LOGIKA CEK STATUS TANGGAPAN ---
                $id_lapor = $key['id'];
                // Cek apakah id laporan ini ada di tabel tanggapan
                $cek_tanggapan = $db->prepare("SELECT * FROM tanggapan WHERE id_laporan = ?");
                $cek_tanggapan->execute([$id_lapor]);
                
                if ($cek_tanggapan->rowCount() > 0) {
                    // Jika ada tanggapan
                    $statusClass = "status-selesai"; 
                    $statusText = "<i class='fa fa-check-circle me-1'></i> Sudah Ditanggapi";
                } else {
                    // Jika belum ada tanggapan
                    $statusClass = "status-menunggu"; 
                    $statusText = "<i class='fa fa-clock me-1'></i> Menunggu Verifikasi";
                }
                // -----------------------------------
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="card card-clean feed-card h-100 p-4 border-0 position-relative">

                    <div class="d-flex align-items-center mb-4">
                        <img src="images/avatar/<?php RandomAvatar(); ?>" class="avatar-img me-3"
                            style="width: 50px; height: 50px;">
                        <div>
                            <h6 class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($key['nama']); ?></h6>
                            <small class="text-muted" style="font-size: 0.8rem;"><i class="fa fa-calendar-alt me-1"></i>
                                <?php echo $tanggal; ?></small>
                        </div>
                    </div>

                    <span class="status-badge <?php echo $statusClass; ?>"
                        style="top: 20px; right: 20px; position: absolute;">
                        <?php echo $statusText; ?>
                    </span>

                    <div class="mb-3">
                        <h6 class="text-primary fw-bold mb-2 small text-uppercase">
                            <i class="fa fa-map-marker-alt me-1"></i> <?php echo htmlspecialchars($key['alamat']); ?>
                        </h6>
                        <p class="text-muted mb-0"
                            style="line-height: 1.6; font-size: 0.95rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo htmlspecialchars($key['isi']); ?>
                        </p>
                    </div>

                    <hr class="mt-auto mb-3 opacity-10">

                    <div class="d-flex justify-content-between align-items-center">
                        <small
                            class="text-muted fw-bold bg-light px-2 py-1 rounded">#TIKET-<?php echo $key['id']; ?></small>
                        <a href="lihat" class="text-decoration-none small fw-bold text-accent">
                            Cek Detail <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <img src="images/TeksLogoFix.png" alt="Logo Footer" class="footer-logo-img">
                    <p class="footer-desc pe-lg-5 text-white-50">Layanan aspirasi masyarakat.</p>
                </div>
                <div class="col-lg-3 offset-lg-1 footer-links">
                    <h5 class="footer-heading">Navigasi</h5>
                    <a href="index">Beranda</a>
                    <a href="tentang">Tentang Kami</a>
                    <a href="feed">Semua Laporan</a>
                    <a href="lihat">Cek Status</a>
                </div>
                <div class="col-lg-3 footer-links">
                    <h5 class="footer-heading">Hubungi</h5>
                    <a href="#">help@laporpeh.id</a>
                </div>
            </div>
            <div class="border-top border-white border-opacity-10 mt-4 pt-4 text-center text-white-50 small">
                &copy; 2025 LaporPeh! All Rights Reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>