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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            width: 90%;
            max-width: 1200px;
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
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:nth-child(odd) {
            background-color: #ffffff;
        }
        .actions a {
            text-decoration: none;
            margin: 0 5px;
            padding: 5px 10px;
            background-color: #FF9800;
            color: white;
            border-radius: 5px;
        }
        .actions a:hover {
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
                    <td class='actions'>
                        <a href='edit_siswa.php?id={$row['id']}'>Edit</a>
                        <a href='delete_siswa.php?id={$row['id']}' onclick=\"return confirm('Yakin ingin menghapus data?')\">Hapus</a>
                    </td>
                </tr>
                ";
                $no++;
            }
            ?>
        </table>
    </div>
</body>
</html>
