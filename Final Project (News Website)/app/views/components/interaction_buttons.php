<?php
// Component untuk interaction buttons (like, bookmark, comments count)
// Usage: include dengan parameter $news_id, $counts, $user_status

$news_id = $news_id ?? 0;
$counts = $counts ?? ['likes' => 0, 'comments' => 0, 'bookmarks' => 0];
$user_status = $user_status ?? ['liked' => false, 'bookmarked' => false];
$is_logged_in = isset($_SESSION['user_id']);
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<div class="flex items-center space-x-4 pt-4 border-t">
    <!-- Like Button -->
    <button 
        onclick="toggleLike(<?= $news_id ?>)" 
        class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors <?= $user_status['liked'] ? 'bg-red-50 text-red-600' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' ?>"
        <?= !$is_logged_in ? 'title="Please login to like"' : '' ?>
        id="like-btn-<?= $news_id ?>">
        <svg class="w-5 h-5" fill="<?= $user_status['liked'] ? 'currentColor' : 'none' ?>" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        <span id="like-count-<?= $news_id ?>"><?= $counts['likes'] ?></span>
    </button>
    
    <!-- Comments Count -->
    <div class="flex items-center space-x-2 px-3 py-2 bg-gray-50 rounded-lg text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.477 8-10 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.477-8 10-8s10 3.582 10 8z"></path>
        </svg>
        <span id="comment-count-<?= $news_id ?>"><?= $counts['comments'] ?></span>
        <span class="text-sm">Comments</span>
    </div>
    
    <!-- Bookmark Button - Hidden for Admin -->
    <?php if (!$is_admin): ?>
        <button 
            onclick="toggleBookmark(<?= $news_id ?>)" 
            class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors <?= $user_status['bookmarked'] ? 'bg-yellow-50 text-yellow-600' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' ?>"
            <?= !$is_logged_in ? 'title="Please login to bookmark"' : '' ?>
            id="bookmark-btn-<?= $news_id ?>">
            <svg class="w-5 h-5" fill="<?= $user_status['bookmarked'] ? 'currentColor' : 'none' ?>" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
            </svg>
            <span id="bookmark-count-<?= $news_id ?>"><?= $counts['bookmarks'] ?></span>
        </button>
    <?php else: ?>
        <!-- Admin Info: Bookmark not available -->
        <div class="flex items-center space-x-2 px-3 py-2 bg-gray-100 rounded-lg text-gray-500" title="Admins cannot bookmark articles">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
            </svg>
            <span><?= $counts['bookmarks'] ?></span>
            <span class="text-xs opacity-75">(Admin)</span>
        </div>
    <?php endif; ?>
</div>

<script>
// Debug: Check current URL
console.log('Current URL:', window.location.href);
console.log('Base URL will be:', window.location.origin);

// Get base URL dynamically
function getBaseUrl() {
    // Check if we're in public/assets/ structure
    const currentPath = window.location.pathname;
    console.log('Current path:', currentPath);
    
    if (currentPath.includes('/public/assets/')) {
        return window.location.origin + '/public/assets';
    } else if (currentPath.includes('/public/')) {
        return window.location.origin + '/public';
    } else {
        return window.location.origin;
    }
}

// Like functionality
function toggleLike(newsId) {
    <?php if (!$is_logged_in): ?>
        alert('Please login to like articles');
        return;
    <?php endif; ?>
    
    console.log('Toggling like for news ID:', newsId);
    
    const btn = document.getElementById(`like-btn-${newsId}`);
    const count = document.getElementById(`like-count-${newsId}`);
    const svg = btn.querySelector('svg');
    
    // Disable button temporarily
    btn.disabled = true;
    
    const baseUrl = getBaseUrl();
    const url = `${baseUrl}/interactions/toggle-like`;
    console.log('Like URL:', url);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `news_id=${newsId}`
    })
    .then(response => {
        console.log('Like response status:', response.status);
        console.log('Like response headers:', response.headers);
        return response.text(); // Get as text first for debugging
    })
    .then(text => {
        console.log('Like response text:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                count.textContent = data.likes_count;
                
                if (data.liked) {
                    btn.className = 'flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors bg-red-50 text-red-600';
                    svg.setAttribute('fill', 'currentColor');
                } else {
                    btn.className = 'flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors bg-gray-50 text-gray-600 hover:bg-gray-100';
                    svg.setAttribute('fill', 'none');
                }
            } else {
                alert(data.message || 'Failed to update like');
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            console.error('Response was:', text);
            alert('Server returned invalid response');
        }
    })
    .catch(error => {
        console.error('Like fetch error:', error);
        alert('Network error occurred: ' + error.message);
    })
    .finally(() => {
        btn.disabled = false;
    });
}

// Bookmark functionality - Only available for non-admin users
<?php if (!$is_admin): ?>
function toggleBookmark(newsId) {
    <?php if (!$is_logged_in): ?>
        alert('Please login to bookmark articles');
        return;
    <?php endif; ?>
    
    console.log('Toggling bookmark for news ID:', newsId);
    
    const btn = document.getElementById(`bookmark-btn-${newsId}`);
    const count = document.getElementById(`bookmark-count-${newsId}`);
    const svg = btn.querySelector('svg');
    
    btn.disabled = true;
    
    const baseUrl = getBaseUrl();
    const url = `${baseUrl}/interactions/toggle-bookmark`;
    console.log('Bookmark URL:', url);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `news_id=${newsId}`
    })
    .then(response => {
        console.log('Bookmark response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('Bookmark response text:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                count.textContent = data.bookmarks_count;
                
                if (data.bookmarked) {
                    btn.className = 'flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors bg-yellow-50 text-yellow-600';
                    svg.setAttribute('fill', 'currentColor');
                } else {
                    btn.className = 'flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors bg-gray-50 text-gray-600 hover:bg-gray-100';
                    svg.setAttribute('fill', 'none');
                }
            } else {
                alert(data.message || 'Failed to update bookmark');
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            alert('Server returned invalid response');
        }
    })
    .catch(error => {
        console.error('Bookmark fetch error:', error);
        alert('Network error occurred: ' + error.message);
    })
    .finally(() => {
        btn.disabled = false;
    });
}
<?php else: ?>
// Admin users cannot bookmark - function disabled
function toggleBookmark(newsId) {
    alert('Admins cannot bookmark articles');
}
<?php endif; ?>
</script>