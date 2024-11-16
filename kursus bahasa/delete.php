<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM pendaftar WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location = 'list.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.'); window.location = 'list.php';</script>";
    }
}
?>
