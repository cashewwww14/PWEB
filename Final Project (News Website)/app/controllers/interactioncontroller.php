<?php
require_once APP_PATH . '/core/controller.php';
require_once APP_PATH . '/models/interaction.php';
require_once APP_PATH . '/models/comment.php';

class InteractionController extends Controller {
    private $interactionModel;
    private $commentModel;
    
    public function __construct() {
        $this->interactionModel = new Interaction();
        $this->commentModel = new Comment();
    }
    
    // Toggle like (AJAX)
    public function toggleLike() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Please login first']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        $news_id = $_POST['news_id'] ?? null;
        
        if (!$news_id || !is_numeric($news_id)) {
            echo json_encode(['success' => false, 'message' => 'Invalid news ID']);
            return;
        }
        
        $user_id = $_SESSION['user_id'];
        $result = $this->interactionModel->toggleLike($user_id, $news_id);
        
        if ($result) {
            $likes_count = $this->interactionModel->getLikesCount($news_id);
            $status = $this->interactionModel->getUserInteractionStatus($user_id, $news_id);
            
            echo json_encode([
                'success' => true,
                'liked' => $status['liked'],
                'likes_count' => $likes_count
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update like']);
        }
    }
    
    // Toggle bookmark (AJAX)
    public function toggleBookmark() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Please login first']);
            return;
        }
        
        // BLOCK ADMIN FROM BOOKMARKING
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            echo json_encode(['success' => false, 'message' => 'Admins cannot bookmark articles']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        $news_id = $_POST['news_id'] ?? null;
        
        if (!$news_id || !is_numeric($news_id)) {
            echo json_encode(['success' => false, 'message' => 'Invalid news ID']);
            return;
        }
        
        $user_id = $_SESSION['user_id'];
        $result = $this->interactionModel->toggleBookmark($user_id, $news_id);
        
        if ($result) {
            $bookmarks_count = $this->interactionModel->getBookmarksCount($news_id);
            $status = $this->interactionModel->getUserInteractionStatus($user_id, $news_id);
            
            echo json_encode([
                'success' => true,
                'bookmarked' => $status['bookmarked'],
                'bookmarks_count' => $bookmarks_count
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update bookmark']);
        }
    }

    // Add comment (Form submission atau AJAX)
    public function addComment() {
        if (!isset($_SESSION['user_id'])) {
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Please login first']);
                return;
            } else {
                $this->redirect('/auth/login');
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
            return;
        }
        
        $news_id = $_POST['news_id'] ?? null;
        $comment_text = $_POST['comment_text'] ?? '';
        
        if (!$news_id || !is_numeric($news_id)) {
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Invalid news ID']);
                return;
            } else {
                $this->redirect('/');
            }
        }
        
        if (empty(trim($comment_text))) {
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Comment cannot be empty']);
                return;
            } else {
                $_SESSION['error'] = 'Comment cannot be empty';
                $this->redirect('/news/' . $news_id);
            }
        }
        
        $user_id = $_SESSION['user_id'];
        $result = $this->commentModel->addComment($user_id, $news_id, $comment_text);
        
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            if ($result) {
                $comments_count = $this->commentModel->getCommentsCount($news_id);
                echo json_encode([
                    'success' => true,
                    'comments_count' => $comments_count,
                    'message' => 'Comment added successfully'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add comment']);
            }
        } else {
            if ($result) {
                $_SESSION['success'] = 'Comment added successfully!';
            } else {
                $_SESSION['error'] = 'Failed to add comment';
            }
            $this->redirect('/news/' . $news_id);
        }
    }
    
    // Delete comment
    public function deleteComment() {
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Please login first']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        $comment_id = $_POST['comment_id'] ?? null;
        
        if (!$comment_id || !is_numeric($comment_id)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid comment ID']);
            return;
        }
        
        $user_id = $_SESSION['user_id'];
        $result = $this->commentModel->deleteComment($comment_id, $user_id);
        
        header('Content-Type: application/json');
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Comment deleted successfully'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete comment or comment not found']);
        }
    }
}