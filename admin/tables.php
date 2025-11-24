<?php
    require_once("database.php");
    require_once("auth.php");
    logged_admin();
    global $nomor, $foundreply;

    // Logic Hapus & Balas
    if (isset($_POST['HapusTanggapan'])) {
        $id = $_POST['id_tanggapan']; $id_laporan = $_POST['id_hapus_tanggapan_laporan'];
        $db->prepare("DELETE FROM tanggapan WHERE id_tanggapan = ?")->execute([$id]);
        $count = $db->prepare("SELECT COUNT(*) FROM tanggapan WHERE id_laporan = ?"); $count->execute([$id_laporan]);
        if($count->fetchColumn() == 0) $db->prepare("UPDATE laporan SET status='Menunggu' WHERE id=?")->execute([$id_laporan]);
    }
    if (isset($_POST['Hapus'])) {
        $id = $_POST['id_laporan'];
        $db->prepare("DELETE FROM tanggapan WHERE id_laporan = ?")->execute([$id]);
        $db->prepare("DELETE FROM laporan WHERE id = ?")->execute([$id]);
    }
    if (isset($_POST['Balas'])) {
        $id = $_POST['id_laporan']; $isi = htmlspecialchars($_POST['isi_tanggapan']);
        $db->prepare("INSERT INTO tanggapan (id_laporan, admin, isi_tanggapan, tanggal_tanggapan) VALUES (?, 'Admin', ?, CURRENT_TIMESTAMP)")->execute([$id, $isi]);
        $db->prepare("UPDATE laporan SET status='Ditanggapi' WHERE id=?")->execute([$id]);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kelola Laporan - Admin</title>
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
                <li class="breadcrumb-item active">Kelola Laporan</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-list-alt me-1"></i> Daftar Semua Laporan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Isi Laporan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if ($id_admin > 0) {
                                        $stmt = $db->prepare("SELECT * FROM laporan, divisi WHERE laporan.tujuan = divisi.id_divisi AND laporan.tujuan = ? ORDER BY laporan.id DESC");
                                        $stmt->execute([$id_admin]);
                                    } else {
                                        $stmt = $db->prepare("SELECT * FROM `laporan` ORDER BY id DESC");
                                        $stmt->execute();
                                    }
                                    while($key = $stmt->fetch()) {
                                        $tanggal = date('d/m/Y', strtotime($key['tanggal']));
                                        $badge = ($key['status'] == "Ditanggapi") ? "<span class='badge badge-success px-2'>Selesai</span>" : "<span class='badge badge-warning text-white px-2'>Menunggu</span>";
                                ?>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $key['nama']; ?></td>
                                    <td><?php echo substr($key['isi'], 0, 60) . '...'; ?></td>
                                    <td><?php echo $tanggal; ?></td>
                                    <td><?php echo $badge; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#ModalDetail<?php echo $key['id']; ?>"><i
                                                    class="fa fa-eye"></i></button>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#ModalBalas<?php echo $key['id']; ?>"><i
                                                    class="fa fa-reply"></i></button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#ModalHapus<?php echo $key['id']; ?>"><i
                                                    class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php 
        if ($id_admin > 0) { $stmt->execute([$id_admin]); } else { $stmt->execute(); }
        while($key = $stmt->fetch()) { 
            $nomor = $key['id'];
            $foundreply = false;
            $stmt3 = $db->prepare("SELECT * FROM `tanggapan` WHERE id_laporan = ?");
            $stmt3->execute([$nomor]);
            $stat = $stmt3->fetchAll();
            if (count($stat) > 0) $foundreply = true;
        ?>
        <div class="modal fade" id="ModalDetail<?php echo $key['id']; ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail</h5><button class="close"
                            data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="alert alert-secondary"><strong>Isi:</strong><br><?php echo $key['isi']; ?></div>
                        <?php if($foundreply) { foreach($stat as $rep) { echo "<div class='alert alert-success mt-2'><strong>Balasan:</strong><br>".$rep['isi_tanggapan']."</div>"; } } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalBalas<?php echo $key['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Balas</h5><button class="close"
                            data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post"><textarea class="form-control" name="isi_tanggapan"
                                required></textarea><input type="hidden" name="id_laporan"
                                value="<?php echo $key['id']; ?>"><button class="btn btn-primary mt-2"
                                name="Balas">Kirim</button></form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalHapus<?php echo $key['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <p>Hapus?</p>
                        <form method="post"><input type="hidden" name="id_laporan"
                                value="<?php echo $key['id']; ?>"><button class="btn btn-danger"
                                name="Hapus">Ya</button></form>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="modal fade" id="exampleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi</h5><button class="close"
                            data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <p>Keluar?</p><a class="btn btn-danger" href="logout.php">Logout</a>
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