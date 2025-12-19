<?php
session_start();
$bilangan = rand(10000, 99999);
$_SESSION["bilangan"] = $bilangan;

$gambar = imagecreatetruecolor(65,30);
$background = imagecolorallocate ($gambar, 244,67,54);
$foreground = imagecolorallocate ($gambar, 255,255,255);
imagefill ($gambar, 0,0,$background);
imagestring ($gambar,10,10,6,$bilangan, $foreground);

header("cache-control: no-cache, must-revalidate");
header ("content-type: image/png");
imagepng($gambar);
imagedestroy ($gambar);
?>
