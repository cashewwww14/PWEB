<?php
session_start();
include('config.php');

$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM news";
$conditions = [];

if ($category_filter) {
    $conditions[] = "category = '$category_filter'";
}
if ($search_query) {
    $conditions[] = "title LIKE '%$search_query%'";
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$result = $conn->query($sql);

$user_name = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_sql = "SELECT name FROM users WHERE id = '$user_id'";
    $user_result = $conn->query($user_sql);
    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $user_name = $user_row['name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown-content {
            display: none;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100">

    <header class="bg-blue-600 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl">News Portal</h1>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="mr-4">Hello, <?php echo $_SESSION['role'] === 'admin' ? 'Admin' : $user_name; ?></span>
                <div class="dropdown inline-block relative">
                    <button id="dropdownButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Dashboard
                    </button>
                    <div id="dropdownMenu" class="dropdown-content absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md hidden">
                        <a href="<?php echo $_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                            Go to Dashboard
                        </a>
                        <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                            Logout
                        </a>
                    </div>
                </div>

                <script>
                    document.getElementById('dropdownButton').addEventListener('click', function() {
                        var menu = document.getElementById('dropdownMenu');
                        menu.classList.toggle('hidden');
                    });
                </script>

            <?php else: ?>
                <a href="login.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</a>
                <a href="register.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 ml-2">Register</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container mx-auto p-4">
        <form action="index.php" method="GET" class="mb-4">
            <input 
                type="text" 
                name="search" 
                placeholder="Search by title..." 
                value="<?php echo htmlspecialchars($search_query); ?>" 
                class="p-2 border border-gray-300 rounded w-full md:w-1/2"
            >
            <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 mt-2 md:mt-0">
                Search
            </button>
        </form>

        <div class="mb-4">
            <button class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                <a href="index.php">All</a>
            </button>
            <?php
            $categories = ['Gadget', 'E-Sport', 'Health', 'Finansial', 'Infrastruktur', 'Fintech', 'Travel'];
            foreach ($categories as $category) {
                echo '<button class="bg-blue-500 text-white p-2 rounded ml-2 hover:bg-blue-600"><a href="index.php?category=' . $category . '">' . $category . '</a></button>';
            }
            ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($news = $result->fetch_assoc()): ?>
                    <div class="bg-white p-4 rounded shadow">
                        <img src="<?php echo $news['image']; ?>" alt="News Image" class="w-full h-40 object-cover rounded mb-4">
                        <h2 class="text-lg font-bold"><?php echo $news['title']; ?></h2>
                        <p class="mt-2 text-gray-600"><?php echo substr($news['content'], 0, 150) . '...'; ?></p>
                        <a href="news_detail.php?id=<?php echo $news['id']; ?>" class="text-blue-500 mt-2 block">Read more</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-gray-600">No news found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
