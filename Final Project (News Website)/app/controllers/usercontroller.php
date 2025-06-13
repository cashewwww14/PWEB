<?php
require_once APP_PATH . '/core/controller.php';
require_once APP_PATH . '/models/user.php';
require_once APP_PATH . '/models/interaction.php';

class UserController extends Controller {
    private $userModel;
    private $interactionModel;
    
    public function __construct() {
        $this->userModel = new User();
        $this->interactionModel = new Interaction();
    }
    public function dashboard() {
        $this->requireAuth();
        
        // BLOCK ADMIN FROM ACCESSING USER DASHBOARD
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            $_SESSION['error'] = 'Admins cannot access user dashboard. Please use admin dashboard.';
            $this->redirect('/admin/dashboard');
            return;
        }
        
        $user_id = $_SESSION['user_id'];
        $user = $this->userModel->findById($user_id);
        
        if (!$user) {
            $this->redirect('/auth/logout');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'birth_date' => $_POST['birth_date'] ?? '',
                'gender' => $_POST['gender'] ?? ''
            ];
            
            // Validation
            if (empty($data['name']) || empty($data['email'])) {
                $_SESSION['error'] = "Name and email are required!";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format!";
            } else {
                if ($this->userModel->updateProfile($user_id, $data)) {
                    $_SESSION['success'] = "Profile updated successfully!";
                } else {
                    $_SESSION['error'] = "Error updating profile.";
                }
            }
            
            $this->redirect('/user/dashboard');
        }
        
        // Get user's bookmarked articles
        $bookmarked_news = $this->interactionModel->getUserBookmarks($user_id);
        
        $this->view('user/dashboard', [
            'user' => $user,
            'bookmarked_news' => $bookmarked_news
        ]);
    }
    
    // Remove bookmark method - ALSO BLOCK ADMIN
    public function removeBookmark() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Please login first']);
            return;
        }
        
        // BLOCK ADMIN FROM REMOVING BOOKMARKS
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            echo json_encode(['success' => false, 'message' => 'Admins cannot manage bookmarks']);
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
        
        // Direct remove bookmark from database
        $result = $this->interactionModel->removeBookmark($user_id, $news_id);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Bookmark removed successfully'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove bookmark or bookmark not found']);
        }
    }
}