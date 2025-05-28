<?php
session_start();
include('config.php');

if (isset($_GET['id'])) {
    $news_id = $_GET['id'];
    $sql = "SELECT * FROM news WHERE id = $news_id";
    $result = $conn->query($sql);
    $news = $result->fetch_assoc();
} else {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-blue-600 text-white p-4 text-center">
        <h1 class="text-xl">News Portal</h1>
    </header>

    <div class="container mx-auto p-4">
        <img src="<?php echo $news['image']; ?>" alt="News Image" class="w-full h-64 object-cover rounded mb-4">

        <h2 class="text-2xl font-bold"><?php echo $news['title']; ?></h2>

        <p class="mt-2 text-gray-600"><strong>Category: </strong><?php echo $news['category']; ?></p>

        <p class="mt-4"><?php echo $news['content']; ?></p>

        <a href="index.php" class="text-blue-500 mt-4 inline-block">Back to News</a>
    </div>

</body>
</html>
