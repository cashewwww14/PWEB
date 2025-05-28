<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$sql_news = "SELECT id, title, content, release_date, category FROM news ORDER BY release_date DESC";
$result_news = $conn->query($sql_news);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-blue-600 text-white p-6 text-center">
        <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
    </header>

    <div class="max-w-7xl mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            
            <div class="flex justify-center">
                <a href="add_news.php" class="bg-blue-500 text-white p-4 rounded-xl shadow-lg hover:bg-blue-600 transition-all duration-300 w-full text-center">
                    <h2 class="text-lg font-semibold">Add News</h2>
                    <p class="text-sm">Create and add new news articles</p>
                </a>
            </div>

            <div class="flex justify-center">
                <a href="list.php" class="bg-green-500 text-white p-4 rounded-xl shadow-lg hover:bg-green-600 transition-all duration-300 w-full text-center">
                    <h2 class="text-lg font-semibold">View News List</h2>
                    <p class="text-sm">Manage and view all news articles</p>
                </a>
            </div>

            <div class="flex justify-center">
                <a href="logout.php" class="bg-red-500 text-white p-4 rounded-xl shadow-lg hover:bg-red-600 transition-all duration-300 w-full text-center">
                    <h2 class="text-lg font-semibold">Logout</h2>
                    <p class="text-sm">Log out from the admin panel</p>
                </a>
            </div>

        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Latest News</h2>
            <?php if ($result_news->num_rows > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while ($row = $result_news->fetch_assoc()): ?>
                        <div class="bg-gray-100 p-4 rounded-lg shadow hover:shadow-lg transition-all duration-300">
                            <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p class="text-sm text-gray-600 mb-2">Category: <?php echo htmlspecialchars($row['category']); ?></p>
                            <p class="text-sm text-gray-600 mb-2">Release Date: <?php echo htmlspecialchars($row['release_date']); ?></p>
                            <p class="text-gray-700 text-sm mb-4"><?php echo substr(htmlspecialchars($row['content']), 0, 100); ?>...</p>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-600">No news available.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
