<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Bahasa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
            margin: 0;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .buttons {
            display: flex;
            justify-content: center;
            margin-top: 50px;
            gap: 20px;
        }
        .buttons a {
            text-decoration: none;
            padding: 15px 30px;
            background-color: #FF9800;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .buttons a:hover {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>
    <header>
        <h1>Kursus Bahasa</h1>
        <p>Belajar bahasa baru dengan mudah dan menyenangkan!</p>
    </header>
    <div class="buttons">
        <a href="pendaftaran_siswa.php">Pendaftaran Siswa</a>
        <a href="pendaftaran_pegawai.php">Pendaftaran Pegawai</a>
        <a href="list_siswa.php">Daftar Siswa</a>
        <a href="list_pegawai.php">Daftar Pegawai</a>
    </div>
</body>
</html>
