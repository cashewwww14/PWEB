<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $kursus = $_POST['kursus'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    $query = "INSERT INTO pendaftar (nama, email, telp, kursus, tanggal_lahir) 
              VALUES ('$nama', '$email', '$telp', '$kursus', '$tanggal_lahir')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pendaftaran berhasil!'); window.location = 'index.php';</script>";
    } else {
        echo "<script>alert('Pendaftaran gagal!');</script>";
    }
}
?>
