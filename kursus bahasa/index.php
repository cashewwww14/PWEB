<?php include('db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Kursus Bahasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Pendaftaran Kursus Bahasa</h2>
        <div class="row">
            <div class="col-md-6">
                <h3>Form Pendaftaran</h3>
                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telp" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="telp" name="telp" required>
                    </div>
                    <div class="mb-3">
                        <label for="kursus" class="form-label">Pilih Kursus Bahasa</label>
                        <select class="form-control" id="kursus" name="kursus" required>
                            <option value="">--Pilih Kursus--</option>
                            <option value="Bahasa Inggris">Bahasa Inggris</option>
                            <option value="Bahasa Jepang">Bahasa Jepang</option>
                            <option value="Bahasa Korea">Bahasa Korea</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Daftar</button>
                </form>
            </div>
            <div class="col-md-6">
                <img src="assets/images/gambar1.jpg" class="img-fluid" alt="Gambar Kursus">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
