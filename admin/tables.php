<?php
    require_once("database.php");
    require_once("auth.php");
    logged_admin();
    
    // Ambil ID Admin jika ada
    $id_admin = 0;
    if(isset($_SESSION['admin'])) {
        $stmt_admin = $db->prepare("SELECT id_admin FROM admin WHERE username = :username");
        $stmt_admin->execute([':username' => $_SESSION['admin']]);
        $row_admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);
        if($row_admin) $id_admin = $row_admin['id_admin'];
    }

    // Logic Hapus & Balas (Tidak Berubah)
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

    // PERBAIKAN QUERY DISINI (Gunakan LEFT JOIN)
    if ($id_admin > 0) {
        // Jika Admin Divisi (Hanya lihat divisi sendiri)
        $stmt = $db->prepare("SELECT * FROM laporan LEFT JOIN divisi ON laporan.tujuan = divisi.id_divisi WHERE laporan.tujuan = ? ORDER BY laporan.id DESC");
        $stmt->execute([$id_admin]);
    } else {
        // Jika Super Admin (Lihat semua + Nama Divisi)
        $stmt = $db->prepare("SELECT * FROM laporan LEFT JOIN divisi ON laporan.tujuan = divisi.id_divisi ORDER BY laporan.id DESC");
        $stmt->execute();
    }
    $laporan_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                            <span class="user">Administrator</span>
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
                                    <th>Pelapor & Kontak</th>
                                    <th>Detail Laporan</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="10%">Status</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($laporan_data as $key) {
                                        $tanggal = date('d/m/Y', strtotime($key['tanggal']));
                                        $badge = ($key['status'] == "Ditanggapi") ? "<span class='badge badge-success px-2'>Selesai</span>" : "<span class='badge badge-warning text-white px-2'>Menunggu</span>";
                                        
                                        // Nama Divisi sekarang akan muncul dengan benar
                                        $divisi_name = !empty($key['nama_divisi']) ? $key['nama_divisi'] : 'Umum';
                                ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-primary"><?php echo $key['nama']; ?></div>
                                        <div class="small text-muted mt-1"><i class="fa fa-envelope mr-1"></i>
                                            <?php echo $key['email']; ?></div>
                                        <div class="small text-muted"><i class="fa fa-phone mr-1"></i>
                                            <?php echo $key['telpon']; ?></div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info mb-2"><?php echo $divisi_name; ?></span>
                                        <div class="text-dark mb-2" style="font-size: 0.95rem; white-space: pre-line;">
                                            <?php echo $key['isi']; ?></div>
                                        <div class="small text-muted"><i class="fa fa-map-marker mr-1 text-danger"></i>
                                            <?php echo $key['alamat']; ?></div>
                                    </td>
                                    <td><?php echo $tanggal; ?></td>
                                    <td><?php echo $badge; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group-vertical">
                                            <button class="btn btn-info btn-sm mb-1" data-toggle="modal"
                                                data-target="#ModalDetail<?php echo $key['id']; ?>"
                                                title="Lihat Detail"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-primary btn-sm mb-1" data-toggle="modal"
                                                data-target="#ModalBalas<?php echo $key['id']; ?>" title="Balas"><i
                                                    class="fa fa-reply"></i></button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#ModalHapus<?php echo $key['id']; ?>" title="Hapus"><i
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
        foreach($laporan_data as $key) { 
            $nomor = $key['id'];
            $stmt3 = $db->prepare("SELECT * FROM `tanggapan` WHERE id_laporan = ?");
            $stmt3->execute([$nomor]);
            $stat = $stmt3->fetchAll();
            $foundreply = count($stat) > 0;
            $divisi_name = !empty($key['nama_divisi']) ? $key['nama_divisi'] : 'Umum';
        ?>
        <div class="modal fade" id="ModalDetail<?php echo $key['id']; ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-file-text-o mr-2"></i> Detail Laporan
                            #<?php echo $key['id']; ?></h5>
                        <button type="button" class="close text-white"
                            data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-primary">Informasi Pelapor</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="100">Nama</td>
                                        <td>: <strong><?php echo $key['nama']; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>: <?php echo $key['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Telpon</td>
                                        <td>: <?php echo $key['telpon']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>: <?php echo $key['alamat']; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-primary">Detail Pengaduan</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="100">Kategori</td>
                                        <td>: <span class="badge badge-info"><?php echo $divisi_name; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>: <?php echo date('d F Y', strtotime($key['tanggal'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:
                                            <?php echo ($key['status'] == 'Ditanggapi') ? '<span class="badge badge-success">Selesai</span>' : '<span class="badge badge-warning">Menunggu</span>'; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h6 class="font-weight-bold text-primary">Isi Laporan</h6>
                            <div class="alert alert-light border text-dark">
                                <?php echo nl2br($key['isi']); ?>
                            </div>
                        </div>
                        <?php if($foundreply) { foreach($stat as $rep) { ?>
                        <div class="mt-4">
                            <h6 class="font-weight-bold text-success"><i class="fa fa-check-circle mr-1"></i> Tanggapan
                                Admin</h6>
                            <div class="alert alert-success border-left-success shadow-sm">
                                <small class="text-muted d-block mb-1">Ditanggapi pada:
                                    <?php echo date('d F Y, H:i', strtotime($rep['tanggal_tanggapan'])); ?></small>
                                <?php echo nl2br($rep['isi_tanggapan']); ?>
                                <form method="post" class="mt-2 text-right">
                                    <input type="hidden" name="id_hapus_tanggapan_laporan"
                                        value="<?php echo $rep['id_laporan']; ?>">
                                    <input type="hidden" name="id_tanggapan"
                                        value="<?php echo $rep['id_tanggapan']; ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" name="HapusTanggapan"
                                        onclick="return confirm('Hapus tanggapan ini?')">Hapus Tanggapan</button>
                                </form>
                            </div>
                        </div>
                        <?php } } else { ?>
                        <div class="alert alert-warning mt-4 text-center">
                            <i class="fa fa-exclamation-circle mr-1"></i> Laporan ini belum ditanggapi.
                        </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary btn-sm" data-dismiss="modal" data-toggle="modal"
                            data-target="#ModalBalas<?php echo $key['id']; ?>">Balas Sekarang</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalBalas<?php echo $key['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Balas Laporan</h5>
                        <button class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label class="font-weight-bold">Isi Laporan:</label>
                                <div class="p-3 bg-light border rounded small text-muted mb-3 font-italic">
                                    "<?php echo $key['isi']; ?>"</div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggapan Anda:</label>
                                <textarea class="form-control" name="isi_tanggapan" rows="5"
                                    placeholder="Tuliskan tanggapan atau tindak lanjut..." required></textarea>
                            </div>
                            <div class="text-right">
                                <input type="hidden" name="id_laporan" value="<?php echo $key['id']; ?>">
                                <button type="button" class="btn btn-light btn-sm mr-2"
                                    data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-sm" name="Balas"><i
                                        class="fa fa-paper-plane mr-1"></i> Kirim Balasan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalHapus<?php echo $key['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center pt-4">
                        <div class="mb-3 text-danger"><i class="fa fa-trash fa-3x"></i></div>
                        <h6 class="font-weight-bold">Hapus Laporan?</h6>
                        <p class="small text-muted">Data yang dihapus tidak dapat dikembalikan.</p>
                        <form method="post">
                            <input type="hidden" name="id_laporan" value="<?php echo $key['id']; ?>">
                            <div class="d-flex justify-content-center mt-4">
                                <button type="button" class="btn btn-light btn-sm mr-2"
                                    data-dismiss="modal">Batal</button>
                                <button class="btn btn-danger btn-sm" name="Hapus">Ya, Hapus</button>
                            </div>
                        </form>
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
                        <p>Keluar dari panel admin?</p><a class="btn btn-danger" href="logout.php">Logout</a>
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