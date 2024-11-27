<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa</title>
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
        <h1>Pendaftaran Siswa</h1>
    </header>
    <form method="POST" action="">
        <label for="nama">Nama Lengkap:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin">
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>

        <label for="no_telp">Nomor Telepon:</label>
        <input type="text" id="no_telp" name="no_telp" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="pegawai_pendaftar">Pegawai Pendaftar:</label>
        <select id="pegawai_pendaftar" name="pegawai_pendaftar">
            <!-- Data dari database -->
            <?php
            include 'config.php';
            $result = $conn->query("SELECT id, nama FROM pegawai");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['nama']}</option>";
            }
            ?>
        </select>

        <button type="submit" name="submit">Daftar</button>
    </form>
</body>
</html>
