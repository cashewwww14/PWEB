<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $tanggal_lahir = $conn->real_escape_string($_POST['tanggal_lahir']);
    $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);
    $no_telp = $conn->real_escape_string($_POST['no_telp']);
    $email = $conn->real_escape_string($_POST['email']);
    $pegawai_pendaftar_id = $conn->real_escape_string($_POST['pegawai_pendaftar_id']);

    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_folder = "uploads/";
    $foto_path = $foto_folder . basename($foto);

    if (move_uploaded_file($foto_tmp, $foto_path)) {
        $query = "INSERT INTO siswa (nama, alamat, tanggal_lahir, jenis_kelamin, no_telp, email, foto, pegawai_pendaftar_id)
                  VALUES ('$nama', '$alamat', '$tanggal_lahir', '$jenis_kelamin', '$no_telp', '$email', '$foto', '$pegawai_pendaftar_id')";

        if ($conn->query($query)) {
            echo "<script>
                    alert('Pendaftaran berhasil!');
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 1);
                  </script>";
        } else {
            echo "Terjadi kesalahan: " . $conn->error;
        }
    } else {
        echo "Gagal mengunggah foto.";
    }
} else {
    echo "Metode HTTP tidak didukung.";
}
?>
