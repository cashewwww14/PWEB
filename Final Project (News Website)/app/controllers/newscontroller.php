<?php
require_once APP_PATH . '/core/controller.php';
require_once APP_PATH . '/models/news.php';
require_once APP_PATH . '/models/user.php';
require_once APP_PATH . '/models/interaction.php';
require_once APP_PATH . '/models/comment.php';

class NewsController extends Controller {
    private $newsModel;
    private $userModel;
    private $interactionModel;
    private $commentModel;
    
    public function __construct() {
        $this->newsModel = new News();
        $this->userModel = new User();
        $this->interactionModel = new Interaction();
        $this->commentModel = new Comment();
    }
    
    public function index() {
        $category = $_GET['category'] ?? null;
        $search = $_GET['search'] ?? null;
        $dateFrom = $_GET['date_from'] ?? null;
        $dateTo = $_GET['date_to'] ?? null;
        
        $news = $this->newsModel->filterNews($category, $search, $dateFrom, $dateTo);
        $categories = $this->newsModel->getCategories();
        
        $user_name = '';
        if (isset($_SESSION['user_id'])) {
            $user = $this->userModel->findById($_SESSION['user_id']);
            $user_name = $user['name'] ?? '';
        }
        
        // Get interaction counts dan user status untuk semua berita
        $interaction_data = $this->getNewsInteractionData($news);
        
        $this->view('home/index', [
            'news' => $news,
            'user_name' => $user_name,
            'categories' => $categories,
            'current_category' => $category,
            'search_query' => $search,
            'interaction_data' => $interaction_data
        ]);
    }
    
    public function detail() {
        $id = $_GET['id'] ?? null;
        
        if (!$id || !is_numeric($id)) {
            $this->redirect('/');
        }
        
        $news = $this->newsModel->findByIdWithCategory($id);
        
        if (!$news) {
            $this->redirect('/');
        }
        
        // Get interaction counts
        $likes_count = $this->interactionModel->getLikesCount($id);
        $comments_count = $this->commentModel->getCommentsCount($id);
        $bookmarks_count = $this->interactionModel->getBookmarksCount($id);
        
        $counts = [
            'likes' => $likes_count,
            'comments' => $comments_count,
            'bookmarks' => $bookmarks_count
        ];
        
        // Get user interaction status
        $user_status = ['liked' => false, 'bookmarked' => false];
        if (isset($_SESSION['user_id'])) {
            $user_status = $this->interactionModel->getUserInteractionStatus($_SESSION['user_id'], $id);
        }
        
        // Get comments
        $comments = $this->commentModel->getComments($id);
        
        $this->view('home/detail_news', [
            'news' => $news,
            'counts' => $counts,
            'user_status' => $user_status,
            'comments' => $comments
        ]);
    }
    
    // Helper method untuk get interaction data untuk multiple news
    private function getNewsInteractionData($news) {
        if (empty($news)) {
            return [];
        }
        
        // Extract news IDs
        $news_ids = array_column($news, 'id');
        
        // Get counts untuk semua news sekaligus
        $interaction_counts = $this->interactionModel->getNewsInteractionCounts($news_ids);
        $comment_counts = $this->commentModel->getNewsCommentCounts($news_ids);
        
        // Get user interaction status jika user login
        $user_interactions = [];
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            foreach ($news_ids as $news_id) {
                $user_interactions[$news_id] = $this->interactionModel->getUserInteractionStatus($user_id, $news_id);
            }
        }
        
        // Format data
        $interaction_data = [];
        foreach ($news as $article) {
            $news_id = $article['id'];
            
            $interaction_data[$news_id] = [
                'counts' => [
                    'likes' => $interaction_counts[$news_id]['like'] ?? 0,
                    'comments' => $comment_counts[$news_id] ?? 0,
                    'bookmarks' => $interaction_counts[$news_id]['bookmark'] ?? 0
                ],
                'user_status' => $user_interactions[$news_id] ?? ['liked' => false, 'bookmarked' => false]
            ];
        }
        
        return $interaction_data;
    }
}