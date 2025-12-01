<?php
    require_once("private/database.php");
    $stmt = $db->prepare("SELECT id FROM `laporan` ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $max_id = ($stmt->rowCount()>0) ? $stmt->fetch(PDO::FETCH_ASSOC)['id']+1 : 100;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Laporan | LaporPeh!</title>
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
                    <li class="nav-item"><a class="nav-link" href="index">Beranda</a></li>
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

    <div class="container pb-5" style="padding-top: 50px;">
        <div class="row justify-content-center">

            <div class="col-lg-8">
                <div class="text-center mb-5 animate__animated animate__fadeInDown">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3 fw-bold">FORM
                        PENGADUAN</span>
                    <h2 class="fw-bold mb-2">Sampaikan Laporan Anda</h2>
                    <p class="text-muted">Isi formulir di bawah ini dengan data yang valid dan jelas.</p>
                </div>

                <div
                    class="card-clean border-top border-4 border-primary shadow-lg animate__animated animate__fadeInUp">
                    <form method="post" action="private/validasi.php">

                        <div
                            class="bg-primary bg-opacity-10 p-4 rounded-3 mb-4 border border-primary border-opacity-25 d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-white p-3 rounded-circle text-primary me-3 shadow-sm">
                                    <i class="fa fa-ticket-alt fs-4"></i>
                                </div>
                                <div>
                                    <small class="text-primary fw-bold d-block text-uppercase ls-1">Nomor Tiket
                                        Anda</small>
                                    <span class="text-muted small">Harap simpan nomor ini untuk pengecekan
                                        status.</span>
                                </div>
                            </div>
                            <div class="bg-white px-4 py-2 rounded-pill shadow-sm border">
                                <span class="text-primary fs-3 fw-bold">#<?php echo $max_id; ?></span>
                                <input type="hidden" name="nomor" value="<?php echo $max_id; ?>">
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-12">
                                <h6 class="text-uppercase text-muted fw-bold small mb-3 border-bottom pb-2">Identitas
                                    Pelapor</h6>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" value="<?= @$_GET['nama'] ?>"
                                    placeholder="Masukkan nama sesuai KTP" required>
                                <small class="text-danger fw-bold ms-1"><?= @$_GET['namaError'] ?></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= @$_GET['email'] ?>"
                                    placeholder="contoh@email.com" required>
                                <small class="text-danger fw-bold ms-1"><?= @$_GET['emailError'] ?></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Handphone/WA</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">+62</span>
                                    <input type="text" class="form-control" name="telpon"
                                        value="<?= @$_GET['telpon'] ?>" placeholder="812345678" required>
                                </div>
                                <small class="text-danger fw-bold ms-1"><?= @$_GET['telponError'] ?></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kategori Laporan</label>
                                <select class="form-select" name="tujuan">
                                    <option value="1">Administrasi Kependudukan</option>
                                    <option value="2">Fasilitas Umum & Jalan</option>
                                    <option value="3">Ketertiban & Keamanan</option>
                                    <option value="4">Lainnya</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4">
                                <h6 class="text-uppercase text-muted fw-bold small mb-3 border-bottom pb-2">Detail
                                    Kejadian</h6>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Lokasi Kejadian</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fa fa-map-marker-alt text-danger"></i></span>
                                    <input type="text" class="form-control" name="alamat"
                                        placeholder="Nama Jalan, Desa/Kelurahan, Patokan..."
                                        value="<?= @$_GET['alamat'] ?>" required>
                                </div>
                                <small class="text-danger fw-bold ms-1"><?= @$_GET['alamatError'] ?></small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Isi Laporan</label>
                                <textarea class="form-control" name="pengaduan" rows="6"
                                    placeholder="Jelaskan detail masalah, waktu kejadian, dan pihak yang terlibat..."
                                    required><?= @$_GET['pengaduan'] ?></textarea>
                                <small class="text-danger fw-bold ms-1"><?= @$_GET['pengaduanError'] ?></small>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="p-3 bg-light rounded border">
                                    <label class="form-label fw-bold mb-2">Verifikasi Keamanan</label>
                                    <div class="d-flex align-items-center flex-wrap gap-3">
                                        <div class="bg-white p-2 border rounded shadow-sm">
                                            <img src="private/captcha.php" alt="Captcha" class="rounded">
                                        </div>
                                        <input type="text" class="form-control border bg-white" name="captcha"
                                            placeholder="Ketik kode captcha di sini" required style="max-width: 250px;">
                                    </div>
                                    <small class="text-danger fw-bold ms-1"><?= @$_GET['captchaError'] ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" name="submit" class="btn btn-primary-custom btn-lg py-3 shadow">
                                <i class="fa fa-paper-plane me-2"></i> Kirim Laporan Sekarang
                            </button>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-4 text-muted small d-flex justify-content-center align-items-center">
                    <i class="fa fa-lock me-2 text-success"></i> Data pelapor dijamin kerahasiaannya dan dilindungi
                    undang-undang.
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