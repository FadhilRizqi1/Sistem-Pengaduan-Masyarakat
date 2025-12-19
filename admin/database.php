<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "kp";

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch(PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Terjadi masalah koneksi database. Silakan coba lagi nanti.");
}

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
        $divisi = 'Unknown';
        $id_admin = 0;
    }
}