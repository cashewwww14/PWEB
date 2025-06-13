<?php 
$title = 'User Dashboard - News Portal';
require_once APP_PATH . '/views/layouts/header.php'; 
?>

<header class="bg-gradient-to-r from-green-600 to-green-800 text-white p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold">User Dashboard</h1>
        <p class="mt-2 opacity-90">Manage your profile and bookmarks</p>
    </div>
</header>

<div class="container mx-auto p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Navigation -->
        <div class="flex space-x-4 mb-6">
            <a href="/" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Homepage
            </a>
            <a href="/auth/logout" class="text-red-600 hover:text-red-800 ml-auto flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Sign Out
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="text-center mb-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-white text-2xl font-bold">
                                <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                            </span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($user['name'] ?? 'User') ?></h2>
                        <p class="text-gray-600">Member since <?= date('F Y', strtotime($user['created_at'] ?? 'now')) ?></p>
                    </div>

                    <!-- Success/Error Messages -->
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                            <?php unset($_SESSION['success']); ?>
                        </div>
                    <?php elseif (isset($_SESSION['error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Profile Form -->
                    <form action="/user/dashboard" method="POST" class="space-y-6">
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="name" id="name" required
                                       value="<?= htmlspecialchars($user['name']) ?>"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" id="email" required
                                       value="<?= htmlspecialchars($user['email']) ?>"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                <input type="date" name="birth_date" id="birth_date"
                                    value="<?= $user['birth_date'] ?>"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                <select name="gender" id="gender" required
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bookmarks Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">My Bookmarks</h3>
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                            <?= count($bookmarked_news) ?> articles
                        </span>
                    </div>

                    <?php if (empty($bookmarked_news)): ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">No bookmarks yet</h4>
                            <p class="text-gray-500 mb-4">Start bookmarking articles to see them here</p>
                            <a href="/" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Browse Articles
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($bookmarked_news as $article): ?>
                                <div class="flex bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors" id="bookmark-<?= $article['id'] ?>">
                                    <!-- Article Image -->
                                    <div class="aspect-[3/4] md:aspect-auto w-24 h-auto flex-shrink-0 relative">
                                        <img src="/<?= htmlspecialchars($article['image']) ?>" 
                                            alt="<?= htmlspecialchars($article['title']) ?>" 
                                            class="absolute inset-0 w-full h-full object-cover rounded-lg">
                                    </div>
        
                                    <!-- Article Info -->
                                    <div class="ml-4 flex-1 min-w-0">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                                <?= htmlspecialchars($article['categoryName'] ?? 'No Category') ?>
                                            </span>
                                            <span class="text-gray-500 text-sm ml-2">
                                                Bookmarked <?= date('M j, Y', strtotime($article['bookmarked_at'])) ?>
                                            </span>
                                        </div>
                                        
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                            <a href="/news/<?= $article['id'] ?>" class="hover:text-blue-600 transition-colors">
                                                <?= htmlspecialchars($article['title']) ?>
                                            </a>
                                        </h4>
                                        
                                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                            <?= htmlspecialchars(substr($article['content'], 0, 120)) ?>...
                                        </p>
                                        
                                        <div class="flex justify-end">
                                            <div class="flex space-x-2">
                                                <a href="/news/<?= $article['id'] ?>" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    Read Article
                                                </a>
                                                <button 
                                                    onclick="removeBookmark(<?= $article['id'] ?>)"
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function removeBookmark(newsId) {
    if (!confirm('Are you sure you want to remove this bookmark?')) {
        return;
    }
    
    fetch('/interactions/toggle-bookmark', {  // Fixed: Added 's' to interactions
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `news_id=${newsId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the bookmark item from DOM instead of reloading
            const bookmarkElement = document.getElementById(`bookmark-${newsId}`);
            if (bookmarkElement) {
                bookmarkElement.remove();
                
                // Update bookmark count
                const countElement = document.querySelector('.bg-blue-100.text-blue-800');
                if (countElement) {
                    const currentCount = parseInt(countElement.textContent.match(/\d+/)[0]);
                    countElement.textContent = `${currentCount - 1} articles`;
                }
                
                // Show empty state if no bookmarks left
                const bookmarksContainer = document.querySelector('.space-y-4');
                if (bookmarksContainer && bookmarksContainer.children.length === 0) {
                    location.reload(); // Reload to show empty state
                }
            }
        } else {
            alert(data.message || 'Failed to remove bookmark');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}
</script>