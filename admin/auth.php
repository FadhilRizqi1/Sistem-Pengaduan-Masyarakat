<?php
# @Author: Wahid Ari <wahidari>
# @Date:   8 January 2018, 5:05
# @Copyright: (c) wahidari 2018
?>
<?php

session_start();
// Regenerate session ID to prevent session fixation
if (!isset($_SESSION['regenerated'])) {
    session_regenerate_id(true);
    $_SESSION['regenerated'] = true;
}
$admin_login = $_SESSION["admin"];
// Jika Belum Login Redirect Ke Index
if(!isset($_SESSION["admin"])) {
    header("Location: login");
    exit();
}

?>