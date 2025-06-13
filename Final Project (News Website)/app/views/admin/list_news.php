<?php 
$title = 'News List - Admin Panel';
require_once APP_PATH . '/views/layouts/header.php'; 
?>

<style>
    .custom-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .back-link {
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        backdrop-filter: blur(10px);
        display: inline-flex;
        align-items: center;
    }

    .back-link:hover {
    background: rgba(255, 255, 255, 0.3);
    }

    .btn-green {
    background-color: #4caf50;
    color: white;
    padding: 10px 16px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease;
    }

    .btn-green:hover {
    background-color: #388e3c;
    }
</style>

<header class="custom-gradient text-white p-6 flex justify-between items-center">
    <div class="flex items-center">
        <a href="/admin/dashboard" class="back-link flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Dashboard
        </a>
        <h1 class="text-xl font-semibold">News Management</h1>
    </div>
<a href="/admin/add-news" class="btn-green">+ Add New Article</a>
</header>

<!-- Success Notification -->
<?php if (isset($successMessage)): ?>
<div id="successNotification" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
    <div class="flex items-center">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium"><?= htmlspecialchars($successMessage) ?></span>
    </div>
    <button onclick="closeNotification()" class="absolute top-1 right-2 text-white hover:text-gray-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
<?php endif; ?>

<div class="container mx-auto p-6">
    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="/admin/news-list" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2 lg:col-span-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Articles</label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            id="search"
                            placeholder="Search by title or content..." 
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" id="category" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Categories</option>
                        <?php if (isset($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" 
                                        <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                    <div class="relative">
                        <input 
                            type="date" 
                            name="date_from" 
                            id="date_from"
                            value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                    <div class="relative">
                        <input 
                            type="date" 
                            name="date_to" 
                            id="date_to"
                            value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3 pt-4">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>
                
                <?php if (!empty($_GET['search']) || !empty($_GET['category']) || !empty($_GET['date_from']) || !empty($_GET['date_to'])): ?>
                    <a href="/admin/news-list" 
                       class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear All
                    </a>
                <?php endif; ?>
                
                <!-- Results Count -->
                <div class="text-sm text-gray-600 ml-auto">
                    <?php if (!empty($_GET['search']) || !empty($_GET['category']) || !empty($_GET['date_from']) || !empty($_GET['date_to'])): ?>
                        <span class="font-medium"><?= count($news) ?></span> articles found
                        <?php if (!empty($_GET['search'])): ?>
                            for "<span class="font-medium"><?= htmlspecialchars($_GET['search']) ?></span>"
                        <?php endif; ?>
                        <?php if (!empty($_GET['date_from']) || !empty($_GET['date_to'])): ?>
                            <br>
                            <span class="text-xs">
                                <?php if (!empty($_GET['date_from']) && !empty($_GET['date_to'])): ?>
                                    Between <?= date('M d, Y', strtotime($_GET['date_from'])) ?> - <?= date('M d, Y', strtotime($_GET['date_to'])) ?>
                                <?php elseif (!empty($_GET['date_from'])): ?>
                                    From <?= date('M d, Y', strtotime($_GET['date_from'])) ?>
                                <?php elseif (!empty($_GET['date_to'])): ?>
                                    Until <?= date('M d, Y', strtotime($_GET['date_to'])) ?>
                                <?php endif; ?>
                            </span>
                        <?php endif; ?>
                    <?php else: ?>
                        Total: <span class="font-medium"><?= count($news) ?></span> articles
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <!-- News Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Image
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                Release Date
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created By
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($news)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <?php if (!empty($_GET['search']) || !empty($_GET['category']) || !empty($_GET['date_from']) || !empty($_GET['date_to'])): ?>
                                        <p class="text-lg font-medium">No articles found</p>
                                        <p class="text-sm">Try adjusting your search criteria</p>
                                        <a href="/admin/news-list" class="mt-3 text-blue-600 hover:text-blue-800">Clear filters</a>
                                    <?php else: ?>
                                        <p class="text-lg font-medium">No news articles found</p>
                                        <p class="text-sm">Get started by creating your first news article</p>
                                        <a href="/admin/add-news" class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                            Add News Article
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($news as $article): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if (!empty($article['image'])): ?>
                                        <img src="/<?= htmlspecialchars($article['image']) ?>" 
                                             alt="<?= htmlspecialchars($article['title']) ?>" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?php 
                                        $title = htmlspecialchars($article['title']);
                                        // Highlight search term if searching
                                        if (!empty($_GET['search'])) {
                                            $searchTerm = htmlspecialchars($_GET['search']);
                                            $title = str_ireplace($searchTerm, '<mark class="bg-yellow-200">' . $searchTerm . '</mark>', $title);
                                        }
                                        echo $title;
                                        ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        <?php 
                                        $content = htmlspecialchars(substr($article['content'], 0, 100)) . '...';
                                        // Highlight search term in content if searching
                                        if (!empty($_GET['search'])) {
                                            $searchTerm = htmlspecialchars($_GET['search']);
                                            $content = str_ireplace($searchTerm, '<mark class="bg-yellow-200">' . $searchTerm . '</mark>', $content);
                                        }
                                        echo $content;
                                        ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?= htmlspecialchars($article['categoryName'] ?? 'Uncategorized') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <div class="font-medium">
                                                <?= date('M d, Y', strtotime($article['release_date'])) ?>
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                <?= date('g:i A', strtotime($article['release_date'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mr-2">
                                            <span class="text-white text-xs font-bold">
                                                <?= strtoupper(substr($article['createdByName'] ?? 'U', 0, 1)) ?>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-medium">
                                                <?= htmlspecialchars($article['createdByName'] ?? 'Unknown') ?>
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                <?= htmlspecialchars($article['createdByEmail'] ?? '') ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="/admin/edit-news?id=<?= $article['id'] ?>" 
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <button onclick="confirmDelete(<?= $article['id'] ?>, '<?= addslashes($article['title']) ?>')" 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-2">Delete Article</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete "<span id="articleTitle" class="font-medium"></span>"? 
                    This action cannot be undone.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="deleteForm" method="POST" action="/admin/delete-news">
                    <input type="hidden" name="delete_id" id="deleteId">
                    <div class="flex space-x-4">
                        <button type="button" onclick="closeDeleteModal()" 
                                class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Success notification animation
document.addEventListener('DOMContentLoaded', function() {
    const notification = document.getElementById('successNotification');
    if (notification) {
        // Show notification
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto hide after 4 seconds
        setTimeout(() => {
            hideNotification();
        }, 4000);
    }
});

function hideNotification() {
    const notification = document.getElementById('successNotification');
    if (notification) {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }
}

function closeNotification() {
    hideNotification();
}

// Delete confirmation modal
function confirmDelete(id, title) {
    document.getElementById('deleteId').value = id;
    document.getElementById('articleTitle').textContent = title;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Date validation
document.getElementById('date_from').addEventListener('change', function() {
    const dateFrom = this.value;
    const dateTo = document.getElementById('date_to').value;
    
    if (dateFrom && dateTo && dateFrom > dateTo) {
        alert('From date cannot be later than To date');
        this.value = '';
    }
});

document.getElementById('date_to').addEventListener('change', function() {
    const dateFrom = document.getElementById('date_from').value;
    const dateTo = this.value;
    
    if (dateFrom && dateTo && dateFrom > dateTo) {
        alert('To date cannot be earlier than From date');
        this.value = '';
    }
});
</script>