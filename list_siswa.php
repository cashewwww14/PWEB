<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #f9f9f9, #e2e2e2);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:nth-child(odd) {
            background-color: #ffffff;
        }
        .actions a {
            text-decoration: none;
            margin: 0 auto;
            padding: 5px 10px;
            background-color: #FF9800;
            color: white;
            border-radius: 5px;
        }
        .actions a:hover {
            background-color: #388E3C;
        }
        .btn-index {
            display: block;
            margin: 10px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-index:hover {
            background-color: #388E3C;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Siswa</h1>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>No Telp</th>
                <th>Email</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
            <?php
            include 'config.php';
            $result = $conn->query("SELECT * FROM siswa");
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$no}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['alamat']}</td>
                    <td>{$row['tanggal_lahir']}</td>
                    <td>{$row['jenis_kelamin']}</td>
                    <td>{$row['no_telp']}</td>
                    <td>{$row['email']}</td>
                    <td><img src='uploads/{$row['foto']}' alt='foto' style='width: 50px; height: 50px; border-radius: 20%;'></td>
                    <td class='actions'>
                        <a href='edit_siswa.php?id={$row['id']}'>Edit</a>
                        <a href='hapus_siswa.php?id={$row['id']}' onclick=\"return confirm('Yakin ingin menghapus data?')\">Hapus</a>
                    </td>
                </tr>
                ";
                $no++;
            }
            ?>
        </table>
        <a href="index.php" class="btn-index">Kembali ke Beranda</a>
        <a href="export_pendaftar.php" class="btn-index" style="background-color: #0000CD" target="_blank">Export PDF</a>
    </div>
</body>
</html>
