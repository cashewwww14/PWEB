<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "tutorial";

$connect = mysqli_connect($host, $user, $password, $dbname);

if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
