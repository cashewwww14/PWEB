<?php 
$title = 'Admin Dashboard - News Portal';
require_once APP_PATH . '/views/layouts/header.php'; 
?>

<style>
.custom-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<header class="custom-gradient text-white p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <p class="mt-2 opacity-90">Manage your news portal</p>
    </div>
</header>

<div class="container mx-auto px-6 py-4">
    <div class="flex space-x-4">
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
</div>

<div class="container mx-auto p-6">
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <a href="/admin/add-news" class="group">
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Add News</h3>
                        <p class="text-sm text-gray-600">Create and add new articles</p>
                    </div>
                </div>
            </div>
        </a>

        <a href="/admin/news-list" class="group">
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">View News List</h3>
                        <p class="text-sm text-gray-600">Manage and view all news articles</p>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Latest News -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Latest News</h2>
        </div>
        
        <?php if (!empty($latestNews)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($latestNews as $article): ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                <?= htmlspecialchars($article['categoryName'] ?? 'No Category') ?>
                            </span>
                            <!-- Created By Information -->
                            <div class="flex items-center text-xs text-gray-500">
                                <div class="w-5 h-5 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mr-1">
                                    <span class="text-white text-xs font-bold">
                                        <?= strtoupper(substr($article['createdByName'] ?? 'U', 0, 1)) ?>
                                    </span>
                                </div>
                                <span class="text-purple-600 font-medium">
                                    <?= htmlspecialchars($article['createdByName'] ?? 'Unknown') ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Enhanced Time Display -->
                        <div class="flex items-center text-xs text-gray-500 mb-3">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="mr-3">
                                Release: <?= date('M j, Y g:i A', strtotime($article['release_date'])) ?>
                            </span>
                        </div>
                        
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                            <?= htmlspecialchars($article['title']) ?>
                        </h3>
                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                            <?= htmlspecialchars(substr($article['content'], 0, 100)) ?>...
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No news articles</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating your first article.</p>
                <div class="mt-6">
                    <a href="/admin/add-news" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Add News Article
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>