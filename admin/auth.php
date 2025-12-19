<?php
session_start();

if (!isset($_SESSION['regenerated'])) {
    session_regenerate_id(true);
    $_SESSION['regenerated'] = true;
}
$admin_login = $_SESSION["admin"];

if(!isset($_SESSION["admin"])) {
    header("Location: login");
    exit();
}

?>