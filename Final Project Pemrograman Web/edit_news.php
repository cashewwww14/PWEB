<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $news_id = $_GET['id'];
    $sql = "SELECT * FROM news WHERE id = '$news_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $news = $result->fetch_assoc();
    } else {
        echo "News not found.";
        exit;
    }
} else {
    header('Location: list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $release_date = $_POST['release_date'];
    $category = $_POST['category'];

    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] !== '') {
        $image_name = basename($_FILES['image']['name']);
        $target_path = "uploads/" . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $sql = "UPDATE news SET title = '$title', content = '$content', release_date = '$release_date', category = '$category', image = '$image_name' WHERE id = '$news_id'";
        } else {
            echo "Failed to upload image.";
            exit;
        }
    } else {
        $sql = "UPDATE news SET title = '$title', content = '$content', release_date = '$release_date', category = '$category' WHERE id = '$news_id'";
    }

    if ($conn->query($sql) === TRUE) {
        header('Location: list.php');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-blue-600 text-white p-4 flex items-center">
        <a href="list.php" class="bg-white text-blue-600 px-4 py-2 rounded mr-4">Back to List</a>
        <h1 class="text-xl">Edit News</h1>
    </header>

    <div class="container mx-auto p-4">
        <form action="edit_news.php?id=<?php echo $news_id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="title" class="block">Title</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($news['title']); ?>" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <div class="mb-4">
                <label for="content" class="block">Content</label>
                <textarea name="content" id="content" rows="4" required class="w-full p-2 border border-gray-300 rounded mt-2"><?php echo htmlspecialchars($news['content']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="release_date" class="block">Release Date</label>
                <input type="date" name="release_date" id="release_date" value="<?php echo $news['release_date']; ?>" required class="w-full p-2 border border-gray-300 rounded mt-2">
            </div>
            <div class="mb-4">
                <label for="category" class="block">Category</label>
                <select name="category" id="category" required class="w-full p-2 border border-gray-300 rounded mt-2">
                    <option value="Gadget" <?php echo $news['category'] === 'Gadget' ? 'selected' : ''; ?>>Gadget</option>
                    <option value="E-Sport" <?php echo $news['category'] === 'E-Sport' ? 'selected' : ''; ?>>E-Sport</option>
                    <option value="Health" <?php echo $news['category'] === 'Health' ? 'selected' : ''; ?>>Health</option>
                    <option value="Finansial" <?php echo $news['category'] === 'Finansial' ? 'selected' : ''; ?>>Finansial</option>
                    <option value="Infrastruktur" <?php echo $news['category'] === 'Infrastruktur' ? 'selected' : ''; ?>>Infrastruktur</option>
                    <option value="Fintech" <?php echo $news['category'] === 'Fintech' ? 'selected' : ''; ?>>Fintech</option>
                    <option value="Travel" <?php echo $news['category'] === 'Travel' ? 'selected' : ''; ?>>Travel</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="image" class="block">Upload New Image (optional)</label>
                <input type="file" name="image" id="image" class="w-full p-2 border border-gray-300 rounded mt-2">
                <p class="text-gray-500 text-sm mt-1">Current Image: <?php echo htmlspecialchars($news['image']); ?></p>
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded mt-4">Update News</button>
        </form>
    </div>

</body>
</html>
