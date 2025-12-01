<?php
require_once("private/database.php");
$nomorError = "";
global $found, $foundreply;

if(isset($_POST['submit'])) {
    $nomor = $_POST['nomor'];
    if (!preg_match("/^[0-9]*$/",$nomor)) {
        $nomorError = "Input hanya boleh angka";
    } else {
        $stmt = $db->prepare("SELECT * FROM laporan LEFT JOIN divisi ON laporan.tujuan = divisi.id_divisi WHERE laporan.id = ?");
        $stmt->execute([$nomor]);
        $statement = $stmt;
        if ($statement->rowCount() < 1) {
            $notFound = true;
        } else {
            $stmt2 = $db->prepare("SELECT * FROM `tanggapan` WHERE id_laporan = ?");
            $stmt2->execute([$nomor]);
            $stat = $stmt2;
            if ($stat->rowCount() > 0) $foundreply = true;
            $found = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cek Status | LaporPeh!</title>
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
                    <li class="nav-item"><a class="nav-link" href="feed">Semua Laporan</a></li>
                    <li class="nav-item"><a class="nav-link active" href="lihat">Cek Status</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a href="lapor" class="btn btn-nav-cta">Buat Laporan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="padding-top: 60px; min-height: 80vh;">

        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div
                    class="d-inline-block p-4 rounded-circle bg-white shadow-sm mb-4 text-primary animate__animated animate__bounceIn">
                    <i class="fa fa-search fa-2x"></i>
                </div>
                <h2 class="mb-3 fw-bold animate__animated animate__fadeInUp">Lacak Pengaduan</h2>
                <p class="text-muted mb-4 animate__animated animate__fadeInUp">Pantau progres laporan Anda dengan
                    memasukkan nomor tiket.</p>

                <div class="card-clean p-5 border-0 shadow-lg text-start animate__animated animate__fadeInUp delay-1s"
                    style="background: var(--primary); border-radius: 20px;">
                    <form method="post">
                        <label class="form-label fw-bold text-white-50 small" style="letter-spacing: 1px;">NOMOR
                            TIKET</label>
                        <div class="input-group input-group-lg mb-4">
                            <span class="input-group-text border-0 text-primary fw-bold bg-white ps-4">#</span>
                            <input type="text" class="form-control border-0 text-primary fw-bold" name="nomor"
                                placeholder="Contoh: 105" required style="box-shadow: none;">
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-gold-custom shadow" type="submit" name="submit">
                                <i class="fa fa-search me-2"></i> Cek Status Sekarang
                            </button>
                        </div>
                        <p class="text-warning mt-3 text-start small fw-bold mb-0"><?= @$nomorError ?></p>
                    </form>
                </div>

                <div
                    class="mt-4 p-3 rounded-3 bg-white border border-secondary border-opacity-10 d-inline-flex align-items-center text-start shadow-sm animate__animated animate__fadeIn">
                    <i class="fa fa-info-circle text-primary fs-3 me-3"></i>
                    <div class="small text-muted">
                        <strong>Lupa Nomor Tiket?</strong><br>
                        Hubungi admin melalui email <span class="text-primary fw-bold">help@laporpeh.id</span>.
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5"></div>

        <?php if (isset($found) && $found) { foreach ($statement as $key) { 
            $tanggal = date('d F Y, H:i', strtotime($key['tanggal']));
        ?>
        <div class="row justify-content-center mt-5 mb-5 animate__animated animate__fadeInUp">
            <div class="col-lg-8">
                <div class="card-clean border-0 shadow-lg">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3 text-primary">
                                <i class="fa fa-ticket-alt fs-4"></i>
                            </div>
                            <div>
                                <span class="text-muted small d-block mb-1 text-uppercase fw-bold">TIKET
                                    PENGADUAN</span>
                                <h4 class="mb-0 text-primary fw-bold">#<?php echo htmlspecialchars($key['id']); ?></h4>
                            </div>
                        </div>
                        <span class="badge bg-success rounded-pill px-4 py-2 fs-6 shadow-sm"><i
                                class="fa fa-check me-1"></i> Terdaftar</span>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><i
                                    class="fa fa-user-circle me-2"></i>Detail Laporan</h6>
                            <div class="bg-light p-4 rounded-4 border shadow-sm">
                                <div class="d-flex justify-content-between mb-3 align-items-center flex-wrap gap-2">
                                    <h5 class="fw-bold text-dark mb-0"><?php echo htmlspecialchars($key['nama']); ?>
                                    </h5>
                                    <span class="badge bg-white text-muted border px-3 py-2 rounded-pill"><i
                                            class="fa fa-clock me-1 text-warning"></i>
                                        <?php echo $tanggal; ?></span>
                                </div>
                                <p class="mb-0 text-dark" style="line-height: 1.8; font-size: 1.05rem;">
                                    <?php echo htmlspecialchars($key['isi']); ?>
                                </p>
                            </div>
                        </div>

                        <div class="col-12">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><i
                                    class="fa fa-reply-all me-2"></i>Respon Petugas</h6>
                            <?php if ($foundreply) { foreach ($stat as $key_resp) { 
                                $tgl_respon = date('d F Y, H:i', strtotime($key_resp['tanggal_tanggapan']));
                            ?>
                            <div
                                class="p-4 rounded-4 border border-start-0 border-end-0 border-top-0 border-bottom-0 border-start border-4 border-warning bg-warning bg-opacity-10 shadow-sm">
                                <div class="d-flex align-items-center mb-2 text-dark small fw-bold">
                                    <span class="bg-warning text-dark px-2 py-1 rounded me-2"><i
                                            class="fa fa-user-shield"></i> Admin</span>
                                    <span>Ditanggapi pada <?php echo $tgl_respon; ?></span>
                                </div>
                                <p class="mb-0 text-dark lead fs-6">
                                    <?php echo htmlspecialchars($key_resp['isi_tanggapan']); ?></p>
                            </div>
                            <?php } } else { ?>
                            <div
                                class="alert alert-light border-dashed border-2 d-flex align-items-center p-4 rounded-4 bg-white">
                                <div class="bg-secondary bg-opacity-10 p-3 rounded-circle text-secondary me-3">
                                    <i class="fa fa-hourglass-half fs-4"></i>
                                </div>
                                <div>
                                    <strong class="d-block text-dark">Sedang Diproses</strong>
                                    <span class="small text-muted">Laporan Anda sedang dalam tahap verifikasi oleh
                                        admin. Mohon cek kembali secara berkala.</span>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } } ?>

    </div>

    <?php if(isset($notFound)) { ?>
    <div class="modal fade" id="failedmodal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center p-4 border-0 rounded-4 shadow-lg">
                <div class="modal-body">
                    <div
                        class="mb-3 text-danger bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block animate__animated animate__tada">
                        <i class="fa fa-times-circle fa-3x"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Tidak Ditemukan</h5>
                    <p class="text-muted small mb-4">Nomor tiket <strong>#<?php echo $_POST['nomor']; ?></strong> tidak
                        terdaftar di sistem kami.</p>
                    <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill w-100 fw-bold"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    var myModal = new bootstrap.Modal(document.getElementById('failedmodal'));
    myModal.show();
    </script>
    <?php } ?>

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