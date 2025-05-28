<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    $birth_date = isset($user['birth_date']) && $user['birth_date'] != null ? $user['birth_date'] : 'N/A';
} else {
    die("User not found!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];

    $update_sql = "UPDATE users SET name='$name', gender='$gender', email='$email' WHERE id='$user_id'";
    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['success'] = "Profile updated successfully!";
        header('Location: user_dashboard.php');
        exit;
    } else {
        $_SESSION['error'] = "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-blue-600 text-white p-4">
        <h1 class="text-xl">User Dashboard</h1>
    </header>

    <div class="container mx-auto p-4">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <h2 class="text-lg font-bold">Profile Information</h2>
        <form action="user_dashboard.php" method="POST" class="bg-white p-4 rounded shadow">
            <label for="name" class="block mb-2">Name</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" class="w-full p-2 border rounded mb-4" required>

            <label for="birth_date" class="block mb-2">Date of Birth</label>
            <input type="text" value="<?php echo $birth_date !== 'N/A' ? $birth_date : 'N/A'; ?>" class="w-full p-2 border rounded mb-4" disabled>

            <label for="gender" class="block mb-2">Gender</label>
            <select name="gender" class="w-full p-2 border rounded mb-4" required>
                <option value="Male" <?php echo $user['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $user['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
            </select>

            <label for="email" class="block mb-2">Email</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" class="w-full p-2 border rounded mb-4" required>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Update Profile</button>
        </form>

        <a href="index.php" class="mt-4 inline-block text-blue-500">Back to News</a>
        
        <a href="logout.php" class="text-blue-500 mt-4 block">Logout</a>
    </div>

</body>
</html>
