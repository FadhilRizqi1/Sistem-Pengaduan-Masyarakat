<?php
    require_once("database.php");
    $message = "";
    if (isset($_POST['login']) && $_POST['login'] == "Login") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM admin WHERE username = :username";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $valid_user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($valid_user && hash('sha256', $password) === $valid_user['password']){
            session_start(); session_regenerate_id(true);
            $_SESSION["admin"] = $username;
            header("Location: index"); exit();
        } else { $message = "Username atau Password Salah"; }
    }
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Administrator</title>
    <link rel="shortcut icon" href="../images/TeksLogoFix.png">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
</head>

<body class="bg-login">
    <div class="login-container">
        <div class="login-left">
            <img src="../images/TeksLogoFix.png"
                style="height: 100px; background: white; padding: 10px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); position: relative; z-index: 2;">
            <h2 style="font-weight: 800; position: relative; z-index: 2;">Admin Portal</h2>
            <p style="opacity: 0.8; text-align: center; max-width: 400px; position: relative; z-index: 2;">
                Kelola aspirasi dan pengaduan masyarakat dengan cepat, mudah, dan transparan.
            </p>
        </div>

        <div class="login-right">
            <div class="login-form-wrapper">
                <div class="mb-4">
                    <h3 class="font-weight-bold" style="color: var(--primary);">Selamat Datang</h3>
                    <p class="text-muted small">Silakan login untuk melanjutkan.</p>
                </div>

                <form method="post">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-muted mb-1">USERNAME</label>
                        <input class="form-control form-control-login" type="text" name="username"
                            placeholder="Masukkan username" required>
                    </div>
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-muted mb-1">PASSWORD</label>
                        <input class="form-control form-control-login" type="password" name="password"
                            placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" class="btn btn-primary-custom btn-block py-2 shadow-sm w-100" name="login"
                        value="Login">
                        Masuk Dashboard
                    </button>
                </form>

                <?php if($message): ?>
                <div class="alert alert-danger mt-4 text-center small p-2 rounded border-0 bg-danger text-white">
                    <i class="fa fa-exclamation-circle mr-1"></i> <?php echo $message; ?>
                </div>
                <?php endif; ?>

                <div class="text-center mt-5">
                    <small class="text-muted">&copy; 2025 LaporPeh! Admin</small>
                </div>
            </div>
        </div>
    </div>
</body>

</html>