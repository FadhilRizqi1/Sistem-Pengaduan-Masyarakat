<?php
    require_once("database.php");
    require_once("auth.php");
    logged_admin ();
    global $total_laporan_masuk, $total_laporan_menunggu, $total_laporan_ditanggapi;
    // ... Logic PHP Hitung Data (Tetap Sama) ...
    if ($id_admin > 0) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM laporan WHERE laporan.tujuan = ?"); $stmt->execute([$id_admin]); $total_laporan_masuk = $stmt->fetch()['COUNT(*)'];
        $stmt = $db->prepare("SELECT COUNT(*) FROM laporan WHERE status = 'Ditanggapi' AND laporan.tujuan = ?"); $stmt->execute([$id_admin]); $total_laporan_ditanggapi = $stmt->fetch()['COUNT(*)'];
        $stmt = $db->prepare("SELECT COUNT(*) FROM laporan WHERE status = 'Menunggu' AND laporan.tujuan = ?"); $stmt->execute([$id_admin]); $total_laporan_menunggu = $stmt->fetch()['COUNT(*)'];
    } else {
        $stmt = $db->prepare("SELECT COUNT(*) FROM laporan"); $stmt->execute(); $total_laporan_masuk = $stmt->fetch()['COUNT(*)'];
        $stmt = $db->prepare("SELECT COUNT(*) FROM laporan WHERE status = 'Ditanggapi'"); $stmt->execute(); $total_laporan_ditanggapi = $stmt->fetch()['COUNT(*)'];
        $stmt = $db->prepare("SELECT COUNT(*) FROM laporan WHERE status = 'Menunggu'"); $stmt->execute(); $total_laporan_menunggu = $stmt->fetch()['COUNT(*)'];
    }
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard - Admin</title>
    <link rel="shortcut icon" href="../images/TeksLogoFix.png">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
</head>

<body class="fixed-nav" id="page-top">

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <a class="navbar-brand" href="index">
            <img src="../images/TeksLogoFix.png" alt="Logo">
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="sidebar-profile">
                    <div class="profile-main">
                        <img src="images/avatar1.png" alt="Admin">
                        <div class="mt-2">
                            <span class="user"><?php echo $divisi; ?></span>
                            <span class="status">● Online</span>
                        </div>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="index"><i class="fa fa-fw fa-dashboard"></i> <span
                            class="nav-link-text">Dashboard</span></a></li>
                <li class="nav-item"><a class="nav-link" href="tables"><i class="fa fa-fw fa-table"></i> <span
                            class="nav-link-text">Kelola Laporan</span></a></li>
                <li class="nav-item"><a class="nav-link" href="export"><i class="fa fa-fw fa-print"></i> <span
                            class="nav-link-text">Ekspor Data</span></a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link text-white" data-toggle="modal" data-target="#exampleModal"><i
                            class="fa fa-fw fa-sign-out"></i> Keluar</a></li>
            </ul>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin Panel</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>

            <div class="row mb-4">
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card card-stat bg-gradient-primary h-100">
                        <div class="icon"><i class="fa fa-fw fa-comments"></i></div>
                        <h2><?php echo $total_laporan_masuk; ?></h2>
                        <span>Total Laporan Masuk</span>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card card-stat bg-gradient-danger h-100">
                        <div class="icon"><i class="fa fa-fw fa-exclamation-circle"></i></div>
                        <h2><?php echo $total_laporan_menunggu; ?></h2>
                        <span>Belum Ditanggapi</span>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card card-stat bg-gradient-success h-100">
                        <div class="icon"><i class="fa fa-fw fa-check-circle"></i></div>
                        <h2><?php echo $total_laporan_ditanggapi; ?></h2>
                        <span>Selesai Ditangani</span>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><i class="fa fa-table me-1"></i> Laporan Terbaru</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Pelapor</th>
                                    <th>Kontak</th>
                                    <th>Isi Laporan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($id_admin > 0) {
                                    $stmt = $db->prepare("SELECT * FROM laporan WHERE tujuan = ? ORDER BY id DESC");
                                    $stmt->execute([$id_admin]);
                                } else {
                                    $stmt = $db->prepare("SELECT * FROM laporan ORDER BY id DESC");
                                    $stmt->execute();
                                }
                                while($key = $stmt->fetch()) {
                                    $tanggal = date('d/m/Y', strtotime($key['tanggal']));
                                    $badge = $key['status'] == "Ditanggapi" ? "<span class='badge badge-success px-3 py-2'>Selesai</span>" : "<span class='badge badge-warning text-white px-3 py-2'>Menunggu</span>";
                                ?>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $key['nama']; ?></td>
                                    <td><small class="text-muted"><?php echo $key['telpon']; ?></small></td>
                                    <td><small><?php echo substr($key['isi'], 0, 80) . '...'; ?></small></td>
                                    <td><?php echo $tanggal; ?></td>
                                    <td><?php echo $badge; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi</h5><button class="close"
                            data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <p>Yakin ingin keluar?</p><a class="btn btn-danger" href="logout.php">Ya, Keluar</a>
                    </div>
                </div>
            </div>
        </div>

        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
        <script src="js/admin.js"></script>
        <script src="js/admin-datatables.js"></script>
    </div>
</body>

</html>