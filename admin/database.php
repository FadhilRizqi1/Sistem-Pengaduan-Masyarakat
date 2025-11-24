<?php
# @Author: Wahid Ari <wahidari>
# @Date:   8 January 2018, 5:05
# @Copyright: (c) wahidari 2018
?>
<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "kp";

try {
    //create PDO connection with better options
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch(PDOException $e) {
    //show error without revealing sensitive info
    error_log("Database connection failed: " . $e->getMessage());
    die("Terjadi masalah koneksi database. Silakan coba lagi nanti.");
}

// ambil data dari user yang login
function logged_admin () {
    global $db, $admin_login, $divisi, $id_admin;
    $sql = "SELECT admin.id_admin, divisi.nama_divisi FROM admin JOIN divisi ON admin.divisi = divisi.id_divisi WHERE admin.username = :username";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $admin_login);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result) {
        $divisi = $result['nama_divisi'];
        $id_admin = $result['id_admin'];
    } else {
        // Handle case where admin not found
        $divisi = 'Unknown';
        $id_admin = 0;
    }
}