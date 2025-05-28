<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$sql = "SELECT id, title, release_date FROM news ORDER BY release_date DESC";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM news WHERE id = '$delete_id'";
    if ($conn->query($delete_sql) === TRUE) {
        header('Location: list.php');
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-blue-600 text-white p-6 text-center">
        <h1 class="text-2xl font-semibold">News List</h1>
    </header>

    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">
        <div class="mb-4">
            <a href="admin_dashboard.php" class="bg-gray-500 text-white p-2 rounded hover:bg-gray-600 inline-block">Back to Dashboard</a>
        </div>

        <h2 class="text-xl font-semibold mb-4">All News</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-4 border">ID</th>
                    <th class="p-4 border">Title</th>
                    <th class="p-4 border">Release Date</th>
                    <th class="p-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="p-4 border"><?php echo $row['id']; ?></td>
                            <td class="p-4 border"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td class="p-4 border"><?php echo $row['release_date']; ?></td>
                            <td class="p-4 border flex gap-2">
                                <a href="edit_news.php?id=<?php echo $row['id']; ?>" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">Edit</a>
                                
                                <form action="list.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this news?');">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="p-4 text-center">No news found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
