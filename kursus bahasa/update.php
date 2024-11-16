<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $kursus = $_POST['kursus'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    $query = "UPDATE pendaftar SET 
              nama='$nama', email='$email', telp='$telp', kursus='$kursus', tanggal_lahir='$tanggal_lahir' 
              WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location = 'list.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data.'); window.location = 'edit.php?id=$id';</script>";
    }
}
?>
