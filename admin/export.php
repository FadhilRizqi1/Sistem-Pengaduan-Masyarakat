<?php
    require_once("database.php");
    require_once("auth.php");
    logged_admin();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ekspor Data - Admin</title>
    <link rel="shortcut icon" href="../images/TeksLogoFix.png">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="vendor/datatables/extra/buttons.dataTables.min.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
</head>

<body class="fixed-nav" id="page-top">
    <div id="preloader">
        <div class="loader-container">
            <img src="../images/TeksLogoFix.png" alt="LaporPeh!" class="loader-logo">
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
                <li class="breadcrumb-item active">Ekspor Data</li>
            </ol>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-file-excel-o me-1"></i> Laporan Siap Ekspor
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-left-primary shadow-sm mb-4">
                        <i class="fa fa-info-circle me-2"></i> Gunakan tombol di bawah untuk mengunduh laporan
                        (Excel/PDF/Print). Data yang diekspor mencakup detail lengkap laporan.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="exportTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID Tiket</th>
                                    <th>Pelapor</th>
                                    <th>Kontak (HP)</th>
                                    <th>Lokasi</th>
                                    <th>Isi Laporan</th>
                                    <th>Tujuan Divisi</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Perbaikan Query: Menggunakan JOIN ke tabel divisi untuk mengambil nama divisi
                                if ($id_admin > 0) {
                                    $stmt = $db->prepare("SELECT laporan.*, divisi.nama_divisi 
                                                          FROM laporan 
                                                          LEFT JOIN divisi ON laporan.tujuan = divisi.id_divisi 
                                                          WHERE laporan.tujuan = ? 
                                                          ORDER BY laporan.id DESC");
                                    $stmt->execute([$id_admin]);
                                } else {
                                    $stmt = $db->prepare("SELECT laporan.*, divisi.nama_divisi 
                                                          FROM laporan 
                                                          LEFT JOIN divisi ON laporan.tujuan = divisi.id_divisi 
                                                          ORDER BY laporan.id DESC");
                                    $stmt->execute();
                                }

                                while($row = $stmt->fetch()) {
                                    // Logika Status
                                    if($row['status'] == 'Ditanggapi') {
                                        $statusText = "Selesai";
                                    } elseif($row['status'] == 'Proses') { // Asumsi ada status proses
                                        $statusText = "Diproses";
                                    } else {
                                        $statusText = "Menunggu";
                                    }
                                    
                                    // Format Tanggal
                                    $tanggalIndo = date('d/m/Y H:i', strtotime($row['tanggal']));
                                ?>
                                <tr>
                                    <td>#<?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($row['telpon']); ?></td>
                                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                    <td><?php echo htmlspecialchars($row['isi']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_divisi']); ?></td>
                                    <td><?php echo $tanggalIndo; ?></td>
                                    <td><?php echo $statusText; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

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
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

        <script src="vendor/datatables/extra/dataTables.buttons.min.js"></script>
        <script src="vendor/datatables/extra/buttons.html5.min.js"></script>
        <script src="vendor/datatables/extra/buttons.print.min.js"></script>
        <script src="vendor/datatables/extra/jszip.min.js"></script>
        <script src="vendor/datatables/extra/pdfmake.min.js"></script>
        <script src="vendor/datatables/extra/vfs_fonts.js"></script>

        <script>
        $(document).ready(function() {
            $('#exportTable').DataTable({
                dom: 'Bfrtip',
                // Mengatur kolom mana yang akan di export (opsional, default semua)
                buttons: [{
                        extend: 'excel',
                        className: 'btn btn-success btn-sm',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        title: 'Data Laporan Masyarakat',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm',
                        text: '<i class="fa fa-file-pdf-o"></i> PDF',
                        orientation: 'landscape', // Landscape agar muat banyak kolom
                        pageSize: 'A4',
                        title: 'Data Laporan Masyarakat',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info btn-sm',
                        text: '<i class="fa fa-print"></i> Print',
                        title: 'Data Laporan Masyarakat'
                    }
                ],
                // Supaya tabel responsif di tampilan mobile admin
                scrollX: true
            });
        });
        </script>
        <script src="js/admin.js"></script>
    </div>
</body>

</html>