<?php
// Component untuk section komentar
// Usage: include dengan parameter $news_id, $comments

$news_id = $news_id ?? 0;
$comments = $comments ?? [];
$is_logged_in = isset($_SESSION['user_id']);
$current_user_id = $_SESSION['user_id'] ?? null;
?>

<div class="mt-8 bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-2xl font-bold mb-6">Comments (<?= count($comments) ?>)</h3>
    
    <!-- Add Comment Form -->
    <?php if ($is_logged_in): ?>
        <div class="mb-8">
            <form onsubmit="addComment(event, <?= $news_id ?>)" class="space-y-4">
                <div>
                    <label for="comment_text" class="block text-sm font-medium text-gray-700 mb-2">
                        Add your comment
                    </label>
                    <textarea 
                        name="comment_text" 
                        id="comment_text_<?= $news_id ?>"
                        rows="3" 
                        placeholder="Write your comment here..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        required></textarea>
                </div>
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        id="comment-submit-<?= $news_id ?>"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition-colors">
                        Post Comment
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="mb-8 p-4 bg-gray-100 rounded-lg text-center">
            <p class="text-gray-600">
                <a href="/auth/login" class="text-blue-600 hover:text-blue-800 font-medium">Login</a> 
                to leave a comment
            </p>
        </div>
    <?php endif; ?>
    
    <!-- Comments List -->
    <div id="comments-list-<?= $news_id ?>" class="space-y-4">
        <?php if (empty($comments)): ?>
            <div class="text-center py-8 text-gray-500" id="no-comments-<?= $news_id ?>">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.477 8-10 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.477-8 10-8s10 3.582 10 8z"></path>
                </svg>
                <p>No comments yet. Be the first to comment!</p>
            </div>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item bg-gray-50 rounded-lg p-4" id="comment-<?= $comment['id'] ?>">
                    <div class="flex items-start space-x-3">
                        <!-- Avatar -->
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-sm font-bold">
                                <?= strtoupper(substr($comment['user_name'], 0, 1)) ?>
                            </span>
                        </div>
                        
                        <!-- Comment Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2 mb-1">
                                <h4 class="font-medium text-gray-900"><?= htmlspecialchars($comment['user_name']) ?></h4>
                                <span class="text-sm text-gray-500">
                                    <?= date('M j, Y \a\t g:i A', strtotime($comment['created_at'])) ?>
                                </span>
                                
                                <!-- Delete button (only for comment owner) -->
                                <?php if ($current_user_id == $comment['user_id']): ?>
                                    <button 
                                        onclick="deleteComment(<?= $comment['id'] ?>, <?= $news_id ?>)"
                                        class="text-red-500 hover:text-red-700 text-sm"
                                        title="Delete comment">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Comment Text -->
                            <p class="text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
// Get base URL dynamically (same as interaction buttons)
function getBaseUrl() {
    const currentPath = window.location.pathname;
    console.log('Comment - Current path:', currentPath);
    
    if (currentPath.includes('/public/assets/')) {
        return window.location.origin + '/public/assets';
    } else if (currentPath.includes('/public/')) {
        return window.location.origin + '/public';
    } else {
        return window.location.origin;
    }
}

// Add comment functionality
function addComment(event, newsId) {
    event.preventDefault();
    
    console.log('Adding comment for news ID:', newsId);
    
    const form = event.target;
    const textarea = document.getElementById(`comment_text_${newsId}`);
    const submitBtn = document.getElementById(`comment-submit-${newsId}`);
    const commentText = textarea.value.trim();
    
    if (!commentText) {
        alert('Please enter a comment');
        return;
    }
    
    // Disable form
    submitBtn.disabled = true;
    submitBtn.textContent = 'Posting...';
    
    const baseUrl = getBaseUrl();
    const url = `${baseUrl}/interactions/add-comment`;
    console.log('Add comment URL:', url);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `news_id=${newsId}&comment_text=${encodeURIComponent(commentText)}&ajax=1`
    })
    .then(response => {
        console.log('Add comment response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('Add comment response text:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                // Clear form
                textarea.value = '';
                
                // Update comment count in interaction buttons
                const commentCountEl = document.getElementById(`comment-count-${newsId}`);
                if (commentCountEl) {
                    commentCountEl.textContent = data.comments_count;
                }
                
                // Reload page to show new comment (simple approach)
                // Alternative: dynamically add comment to list
                location.reload();
            } else {
                alert(data.message || 'Failed to add comment');
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            alert('Server returned invalid response');
        }
    })
    .catch(error => {
        console.error('Add comment error:', error);
        alert('Network error occurred: ' + error.message);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Post Comment';
    });
}

// Delete comment functionality
function deleteComment(commentId, newsId) {
    if (!confirm('Are you sure you want to delete this comment?')) {
        return;
    }
    
    console.log('Deleting comment ID:', commentId);
    
    const baseUrl = getBaseUrl();
    const url = `${baseUrl}/interactions/delete-comment`;
    console.log('Delete comment URL:', url);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `comment_id=${commentId}`
    })
    .then(response => {
        console.log('Delete comment response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('Delete comment response text:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                // Remove comment from DOM
                const commentEl = document.getElementById(`comment-${commentId}`);
                if (commentEl) {
                    commentEl.remove();
                }
                
                // Update comment count
                const commentCountEl = document.getElementById(`comment-count-${newsId}`);
                if (commentCountEl) {
                    const currentCount = parseInt(commentCountEl.textContent) || 0;
                    commentCountEl.textContent = Math.max(0, currentCount - 1);
                }
                
                // Show "no comments" message if no comments left
                const commentsList = document.getElementById(`comments-list-${newsId}`);
                const remainingComments = commentsList.querySelectorAll('.comment-item');
                if (remainingComments.length === 0) {
                    commentsList.innerHTML = `
                        <div class="text-center py-8 text-gray-500" id="no-comments-${newsId}">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.477 8-10 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.477-8 10-8s10 3.582 10 8z"></path>
                            </svg>
                            <p>No comments yet. Be the first to comment!</p>
                        </div>
                    `;
                }
            } else {
                alert(data.message || 'Failed to delete comment');
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            alert('Server returned invalid response');
        }
    })
    .catch(error => {
        console.error('Delete comment error:', error);
        alert('Network error occurred: ' + error.message);
    });
}
</script>