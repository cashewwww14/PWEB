<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT foto FROM siswa WHERE id = $id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    if ($row) {
        $fotoPath = "uploads/" . $row['foto'];
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }
        $conn->query("DELETE FROM siswa WHERE id = $id");
    }

    header("Location: list_siswa.php");
}
?>
