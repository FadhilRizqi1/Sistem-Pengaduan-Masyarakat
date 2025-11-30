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
                    <li class="nav-item"><a class="nav-link active" href="lapor">Buat Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="lihat">Cek Status</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pb-5" style="padding-top: 50px;">
        <div class="row justify-content-center">

            <div class="col-lg-8">
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-2">Buat Laporan Baru</h2>
                    <p class="text-muted">Isi formulir di bawah ini dengan data yang valid.</p>
                </div>

                <div class="card-clean border-top border-4 border-primary">
                    <form method="post" action="private/validasi.php">
                        <div class="bg-light p-3 rounded mb-4 border d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted fw-bold d-block">NOMOR TIKET ANDA</small>
                                <span class="text-muted small">Simpan nomor ini untuk pengecekan.</span>
                            </div>
                            <span class="text-primary fs-3 fw-bold">#<?php echo $max_id; ?></span>
                            <input type="hidden" name="nomor" value="<?php echo $max_id; ?>">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" value="<?= @$_GET['nama'] ?>"
                                    required>
                                <small class="text-danger"><?= @$_GET['namaError'] ?></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= @$_GET['email'] ?>"
                                    required>
                                <small class="text-danger"><?= @$_GET['emailError'] ?></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. Handphone/WA</label>
                                <input type="text" class="form-control" name="telpon" value="<?= @$_GET['telpon'] ?>"
                                    required>
                                <small class="text-danger"><?= @$_GET['telponError'] ?></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kategori Laporan</label>
                                <select class="form-select" name="tujuan">
                                    <option value="1">Administrasi Kependudukan</option>
                                    <option value="2">Fasilitas Umum & Jalan</option>
                                    <option value="3">Ketertiban & Keamanan</option>
                                    <option value="4">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Lokasi Kejadian</label>
                                <input type="text" class="form-control" name="alamat"
                                    placeholder="Jalan, Kecamatan, Patokan..." value="<?= @$_GET['alamat'] ?>" required>
                                <small class="text-danger"><?= @$_GET['alamatError'] ?></small>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Isi Laporan</label>
                                <textarea class="form-control" name="pengaduan" rows="5"
                                    placeholder="Jelaskan detail masalah..."
                                    required><?= @$_GET['pengaduan'] ?></textarea>
                                <small class="text-danger"><?= @$_GET['pengaduanError'] ?></small>
                            </div>

                            <div class="col-12 mt-4">
                                <label class="form-label">Keamanan</label>
                                <div class="d-flex align-items-center bg-light p-2 rounded border">
                                    <img src="private/captcha.php" alt="Captcha" class="rounded me-3 border bg-white">
                                    <input type="text" class="form-control border-0 bg-transparent" name="captcha"
                                        placeholder="Ketik kode captcha" required>
                                </div>
                                <small class="text-danger"><?= @$_GET['captchaError'] ?></small>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" name="submit" class="btn btn-primary-custom btn-lg">
                                Kirim Laporan Sekarang
                            </button>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-4 text-muted small">
                    <i class="fa fa-lock me-1"></i> Data pelapor dijamin kerahasiaannya.
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <img src="images/TeksLogoFix.png" alt="Logo Footer" class="footer-logo-img">
                    <p class="footer-desc pe-lg-5">Layanan aspirasi masyarakat.</p>
                </div>
                <div class="col-lg-3 offset-lg-1 footer-links">
                    <h5 class="footer-heading">Menu</h5>
                    <a href="index">Beranda</a>
                    <a href="lapor">Buat Laporan</a>
                    <a href="lihat">Cek Status</a>
                </div>
                <div class="col-lg-3 footer-links">
                    <h5 class="footer-heading">Kontak</h5>
                    <a href="#">help@laporpeh.id</a>
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