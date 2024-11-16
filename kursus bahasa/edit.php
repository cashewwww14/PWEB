<?php 
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM pendaftar WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pendaftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Data Pendaftar</h2>
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="telp" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="telp" name="telp" value="<?php echo $row['telp']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="kursus" class="form-label">Pilih Kursus Bahasa</label>
                <select class="form-control" id="kursus" name="kursus" required>
                    <option value="Bahasa Inggris" <?php if($row['kursus'] == 'Bahasa Inggris') echo 'selected'; ?>>Bahasa Inggris</option>
                    <option value="Bahasa Jepang" <?php if($row['kursus'] == 'Bahasa Jepang') echo 'selected'; ?>>Bahasa Jepang</option>
                    <option value="Bahasa Korea" <?php if($row['kursus'] == 'Bahasa Korea') echo 'selected'; ?>>Bahasa Korea</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $row['tanggal_lahir']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Perbarui</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
