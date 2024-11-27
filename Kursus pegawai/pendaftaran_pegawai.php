<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #00BCD4;
            color: white;
            padding: 20px;
            text-align: center;
        }
        form {
            max-width: 500px;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        form label {
            display: block;
            margin: 10px 0 5px;
        }
        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        form button:hover {
            background-color: #388E3C;
        }
    </style>
</head>
<body>
    <header>
        <h1>Pendaftaran Pegawai</h1>
    </header>
    <form method="POST" action="">
        <label for="nama">Nama Lengkap:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin">
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required>

        <label for="no_telp">Nomor Telepon:</label>
        <input type="text" id="no_telp" name="no_telp" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="divisi">Divisi:</label>
        <input type="text" id="divisi" name="divisi" required>

        <button type="submit" name="submit">Daftar</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        include 'config.php';
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];
        $email = $_POST['email'];
        $divisi = $_POST['divisi'];

        $sql = "INSERT INTO pegawai (nama, jenis_kelamin, alamat, no_telp, email, divisi) 
                VALUES ('$nama', '$jenis_kelamin', '$alamat', '$no_telp', '$email', '$divisi')";
        if ($conn->query($sql) === TRUE) {
            echo "Pendaftaran pegawai berhasil!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
</body>
</html>
