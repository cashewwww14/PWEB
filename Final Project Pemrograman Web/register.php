<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashed_password = hash('sha256', $password);

        $sql = "INSERT INTO users (name, birth_date, gender, email, password, role) VALUES ('$name', '$birth_date', '$gender', '$email', '$hashed_password', 'user')";
        if ($conn->query($sql) === TRUE) {
            header('Location: login.php');
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $error = "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            position: relative;
        }
        .back-button {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            background-color: #FFF;
            color: #00BCD4;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
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
<body class="bg-gray-100">

    <header>
        <a href="index.php" class="back-button">&larr; Back to homepage</a>
        <h1 class="text-xl font-bold">Register for News Portal</h1>
    </header>

    <form action="register.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="birth_date">Date of Birth:</label>
        <input type="date" name="birth_date" required>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <?php if (isset($error)): ?>
            <p class="text-red-500"><?php echo $error; ?></p>
        <?php endif; ?>

        <button type="submit">Register</button>
    </form>
</body>
</html>
