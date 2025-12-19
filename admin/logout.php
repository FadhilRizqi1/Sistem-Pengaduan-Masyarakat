<?php
session_start();
unset($_SESSION['admin']); 
unset($_SESSION['regenerated']); 
session_destroy(); 
header("Location: login");
exit();
?>