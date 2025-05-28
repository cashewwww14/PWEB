<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $release_date = $_POST['release_date'];
    $category = $_POST['category'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_type = $_FILES['image']['type'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image_name);
        $image_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $valid_extensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($image_extension, $valid_extensions)) {
            if ($image_size < 5000000) {
                if (move_uploaded_file($image_tmp_name, $target_file)) {
                    $sql = "INSERT INTO news (title, content, release_date, category, image) 
                            VALUES ('$title', '$content', '$release_date', '$category', '$target_file')";

                    if ($conn->query($sql) === TRUE) {
                        header('Location: admin_dashboard.php');
                        exit;
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, your file is too large.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
        }
    } else {
        echo "Please select an image to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add News</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-blue-600 text-white p-4 flex justify-between items-center">
        <a href="admin_dashboard.php" class="text-white bg-blue-500 px-4 py-2 rounded hover:bg-blue-700">Back to Dashboard</a>
        <h1 class="text-xl">Add News</h1>
    </header>

    <div class="container mx-auto p-4">
        <form action="add_news.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="title" class="block">Title</label>
                <input type="text" name="title" id="title" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <div class="mb-4">
                <label for="content" class="block">Content</label>
                <textarea name="content" id="content" rows="4" required class="w-full p-2 border border-gray-300 rounded mt-2"></textarea>
            </div>
            <div class="mb-4">
                <label for="release_date" class="block">Release Date</label>
                <input type="date" name="release_date" id="release_date" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <div class="mb-4">
                <label for="category" class="block">Category</label>
                <select name="category" id="category" required class="w-full p-2 border border-gray-300 rounded mt-2">
                    <option value="Gadget">Gadget</option>
                    <option value="E-Sport">E-Sport</option>
                    <option value="Health">Health</option>
                    <option value="Finansial">Finansial</option>
                    <option value="Infrastruktur">Infrastruktur</option>
                    <option value="Fintech">Fintech</option>
                    <option value="Travel">Travel</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="image" class="block">Upload Image</label>
                <input type="file" name="image" id="image" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded mt-4">Submit News</button>
        </form>
    </div>

</body>
</html>
