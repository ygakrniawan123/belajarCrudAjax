<?php
$h = "localhost";
$u = "root";
$p = "";
$db = "more_ajax";



$conn = mysqli_connect($h, $u, $p, $db);



// jika koneksi berhasil terhubung
if(!$conn){
    echo "koneksi gagal";
}


?>