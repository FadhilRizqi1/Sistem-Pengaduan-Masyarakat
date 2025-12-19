<?php
	session_start();
	require_once("database.php");
	header("Location: ../index?status=success");
	$nama = $email = $telpon = $alamat = $pengaduan = $captcha = $is_valid = "";
	$namaError = $emailError = $telponError = $alamatError = $pengaduanError = $captchaError = "";

    if (isset($_POST['submit'])){
        $nomor     = $_POST['nomor'];
        $nama      = $_POST['nama'];
        $email     = $_POST['email'];
        $telpon    = $_POST['telpon'];
        $alamat    = $_POST['alamat'];
        $tujuan    = $_POST['tujuan'];
        $pengaduan = $_POST['pengaduan'];
        $captcha   = $_POST['captcha'];
        $is_valid  = true;
        validate_input();

        if ($is_valid) {
			$sql = "INSERT INTO `laporan` (`id`, `nama`, `email`, `telpon`, `alamat`, `tujuan`, `isi`, `tanggal`, `status`) VALUES (:nomor, :nama, :email, :telpon, :alamat, :tujuan, :isi, CURRENT_TIMESTAMP, :status)";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':nomor', $nomor);
			$stmt->bindValue(':nama', $nama);
			$stmt->bindValue(':email', $email);
			$stmt->bindValue(':telpon', $telpon);
			$stmt->bindValue(':alamat', htmlspecialchars($alamat));
			$stmt->bindValue(':tujuan', $tujuan);
			$stmt->bindValue(':isi', htmlspecialchars($pengaduan));
			$stmt->bindValue(':status', "Menunggu");

			$stmt->execute();
			header("Location: ../index?status=success");
        } elseif (!$is_valid) {
            header("Location: ../lapor.php?nomor=$nomor&nama=$nama&namaError=$namaError&email=$email&emailError=$emailError&telpon=$telpon&telponError=$telponError&alamat=$alamat&alamatError=$alamatError&pengaduan=$pengaduan&pengaduanError=$pengaduanError&captcha=$captcha&captchaError=$captchaError");
        }
    }

    function validate_input() {
        global $nama , $email , $telpon , $alamat , $pengaduan , $captcha , $is_valid;
        cek_nama($nama);
        cek_email($email);
        cek_telpon($telpon);
        cek_alamat($alamat);
		cek_pengaduan($pengaduan);
        cek_captcha($captcha);
    }
    
    function cek_nama ($nama) {
        global $nama, $is_valid, $namaError;
        echo "cek_nama      : ", $nama      , "<br>";
        if (!preg_match("/^[a-zA-Z ]*$/",$nama)) { 
            $namaError = "Nama Hanya Boleh Huruf dan Spasi";
            $is_valid = false;
        } else { 
            $namaError = "";
        }
    }

    function cek_email($email) {
        global $email, $is_valid, $emailError;
        echo "cek_email     : ", $email     , "<br>";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $emailError = "Email Tidak Valid";
            $is_valid = false;
        } else { 
            $emailError = "";
        }
    }

    function cek_telpon($telpon) {
        global $telpon, $telponError, $is_valid;
        echo "cek_telpon    : ", $telpon    , "<br>";
        if (!preg_match("/^[0-9]*$/",$telpon)) { 
            $telponError = "Telpon Hanya Boleh Angka";
            $is_valid = false;
        } elseif (strlen($telpon) != 12) { 
            $telponError = "Panjang Telpon Harus 12 Digit";
            $is_valid = false;
        } else {
            $telponError = "";
        }
    }

    function cek_alamat($alamat) {
        global $alamat, $is_valid, $alamatError;
        echo "cek_alamat    : ", $alamat    , "<br>";
        if (!preg_match("/^[a-zA-Z0-9 ]*$/",$alamat)) { 
            $alamatError = "Alamat Hanya Boleh Huruf dan Angka";
            $is_valid = false;
        } else {
            $alamatError = "";
        }
    }

    function cek_pengaduan($pengaduan) {
        global $pengaduan, $is_valid, $pengaduanError;
        echo "cek_pengaduan : ", $pengaduan , "<br>";
        if (strlen($pengaduan) > 2048) {
            $pengaduanError = "Isi Pengaduan Tidak Boleh Huruf Lebih Dari 2048 Karakter";
            $is_valid = false;
        } else { 
            $pengaduanError = "";
        }
    }

    function cek_captcha($captcha) {
        global $captcha, $is_valid, $captchaError;
        echo "cek_captcha   : ", $captcha   , "<br>";
        if ($captcha != $_SESSION['bilangan']) {
            $captchaError = "Captcha Salah atau Silahkan Reload Browser Anda";
            $is_valid = false;
        } else { 
            $captchaError = "";
        }
    }
?>
