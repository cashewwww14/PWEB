<?php include('db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pendaftar Kursus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">List Pendaftar Kursus Bahasa</h2>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM pendaftar");
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Kursus</th>
                            <th>Tanggal Lahir</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['telp']}</td>
                        <td>{$row['kursus']}</td>
                        <td>{$row['tanggal_lahir']}</td>
                        <td>
                            <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Hapus</a>
                        </td>
                    </tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<p class='text-center'>Tidak ada pendaftar.</p>";
        }
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
