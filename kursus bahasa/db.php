<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kursus_bahasa";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
