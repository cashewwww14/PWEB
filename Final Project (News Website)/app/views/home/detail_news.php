<?php 
$title = htmlspecialchars($news['title']) . ' - News Portal';
require_once APP_PATH . '/views/layouts/header.php'; 
require_once APP_PATH . '/views/layouts/navbar.php'; 
?>

<div class="container mx-auto p-4">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div class="flex space-x-3">
                <a href="/" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Homepage
                </a>
            </div>
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

        <!-- Article -->
        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Featured Image -->
            <img src="/<?= htmlspecialchars($news['image']) ?>" 
                 alt="<?= htmlspecialchars($news['title']) ?>" 
                 class="w-full object-cover">
            
            <div class="p-8">
                <!-- Article Meta -->
                <div class="flex items-center mb-6">
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                        <?= htmlspecialchars($news['categoryName']) ?>
                    </span>
                    <span class="text-gray-500 ml-4">
                        Published on <?= date('F j, Y g:i A', strtotime($news['release_date'])) ?>
                    </span>
                </div>
                
                <!-- Article Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                    <?= htmlspecialchars($news['title']) ?>
                </h1>
                
                <!-- Article Content -->
                <div class="prose max-w-none">
                    <div class="text-gray-700 leading-relaxed text-lg">
                        <?= nl2br(htmlspecialchars($news['content'])) ?>
                    </div>
                </div>
                
                <!-- Interaction Buttons -->
                <div class="mt-8">
                    <?php 
                    $news_id = $news['id'];
                    include APP_PATH . '/views/components/interaction_buttons.php';
                    ?>
                </div>
                
            </div>
        </article>
        
        <!-- Comments Section -->
        <?php 
        $news_id = $news['id'];
        include APP_PATH . '/views/components/comment_section.php';
        ?>
        
        <!-- Related Articles Section -->
        <div class="mt-8">
            <h3 class="text-2xl font-bold mb-4">Related Articles</h3>
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-gray-600 text-center">
                    <a href="/?category=<?= urlencode($news['categoryId']) ?>" class="text-blue-600 hover:text-blue-800">
                        View more <?= htmlspecialchars($news['categoryName']) ?> articles →
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>