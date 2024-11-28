<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT * FROM siswa WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $siswa = $result->fetch_assoc();
    } else {
        echo "Siswa tidak ditemukan!";
        exit;
    }
} else {
    echo "ID siswa tidak diberikan!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];
    $pegawai_pendaftar_id = $_POST['pegawai_pendaftar_id'];

    if ($_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_folder = "uploads/";
        $foto_path = $foto_folder . basename($foto);
        
        if (move_uploaded_file($foto_tmp, $foto_path)) {
            $update_foto = ", foto = '$foto'";
        } else {
            $error_message = "Gagal mengunggah foto.";
        }
    } else {
        $update_foto = "";
    }

    $query_update = "UPDATE siswa SET 
        nama = '$nama', 
        alamat = '$alamat', 
        tanggal_lahir = '$tanggal_lahir', 
        jenis_kelamin = '$jenis_kelamin', 
        no_telp = '$no_telp', 
        email = '$email', 
        pegawai_pendaftar_id = '$pegawai_pendaftar_id' 
        $update_foto 
        WHERE id = $id";
    
    if ($conn->query($query_update)) {
        header('Location: list_siswa.php');
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #f9f9f9, #e2e2e2);
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 50px auto;
            max-width: 60%;
            padding: 20px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"], input[type="date"], input[type="tel"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="file"] {
            margin: 10px 0;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Siswa</h1>
        <form action="edit_siswa.php?id=<?php echo $siswa['id']; ?>" method="POST" enctype="multipart/form-data">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $siswa['nama']; ?>" required>

            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo $siswa['alamat']; ?>" required>

            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $siswa['tanggal_lahir']; ?>" required>

            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="L" <?php echo ($siswa['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="P" <?php echo ($siswa['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
            </select>

            <label for="no_telp">No Telepon:</label>
            <input type="tel" id="no_telp" name="no_telp" value="<?php echo $siswa['no_telp']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $siswa['email']; ?>" required>

            <label for="pegawai_pendaftar_id">Pegawai Pendaftar:</label>
            <select id="pegawai_pendaftar_id" name="pegawai_pendaftar_id" required>
                <?php
                $result = $conn->query("SELECT * FROM pegawai");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}' " . (($siswa['pegawai_pendaftar_id'] == $row['id']) ? 'selected' : '') . ">{$row['nama']}</option>";
                }
                ?>
            </select>

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*">
            <?php if ($siswa['foto']) { ?>
                <br>
                <img src="uploads/<?php echo $siswa['foto']; ?>" alt="Foto Siswa" width="100">
            <?php } ?>

            <input type="submit" value="Simpan Perubahan">
        </form>
    </div>
</body>
</html>
