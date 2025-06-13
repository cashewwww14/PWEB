<?php
require_once APP_PATH . '/core/controller.php';
require_once APP_PATH . '/models/news.php';
require_once APP_PATH . '/models/category.php';

class AdminController extends Controller {
    private $newsModel;
    private $categoryModel;
    
    public function __construct() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->newsModel = new News();
        $this->categoryModel = new Category();
    }
    
    public function dashboard() {
        $this->requireAdmin();
        
        // Update: Dapatkan news dengan kategori dan created_by
        $latestNews = $this->newsModel->getLatestWithCategory(9);
        $this->view('admin/dashboard', ['latestNews' => $latestNews]);
    }

    public function newsList() {
        $this->requireAuth();
        $this->requireAdmin();
        
        // Get search and filter parameters
        $search = $_GET['search'] ?? '';
        $categoryId = $_GET['category'] ?? '';
        $dateFrom = $_GET['date_from'] ?? '';
        $dateTo = $_GET['date_to'] ?? '';
        
        // Fetch news based on filters
        if (!empty($search) || !empty($categoryId) || !empty($dateFrom) || !empty($dateTo)) {
            $news = $this->newsModel->filterNews($categoryId, $search, $dateFrom, $dateTo);
        } else {
            $news = $this->newsModel->findAllWithCategory();
        }
        
        // Get all categories for filter dropdown
        $categories = $this->categoryModel->findAll();
        
        // Check for success message
        $successMessage = null;
        if (isset($_SESSION['success_message'])) {
            $successMessage = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        }
        
        $this->view('admin/list_news', [
            'news' => $news,
            'categories' => $categories,
            'successMessage' => $successMessage
        ]);
    }
    
    public function addNews() {
        $this->requireAuth();
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $release_date = $_POST['release_date'] ?? '';
            
            // Validation
            if (empty($title) || empty($content) || empty($category_id) || empty($release_date)) {
                $error = "All fields are required.";
            } else {
                // Handle file upload
                $image_path = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    // FIXED: Correct upload directory
                    $upload_dir = dirname(APP_PATH) . '/public/assets/news/';
                    
                    // Create uploads directory if it doesn't exist
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    
                    $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if (in_array($file_extension, $allowed_extensions)) {
                        $new_filename = uniqid() . '.' . $file_extension;
                        $target_path = $upload_dir . $new_filename;
                        
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                            // FIXED: Store relative path for database
                            $image_path = 'assets/news/' . $new_filename;
                        } else {
                            $error = "Failed to upload image.";
                        }
                    } else {
                        $error = "Invalid image format. Please use JPG, JPEG, PNG, or GIF.";
                    }
                } else {
                    $error = "Please select an image file.";
                }
                
                // Save to database if no errors
                if (!isset($error)) {
                    $data = [
                        'title' => $title,
                        'content' => $content,
                        'category_id' => $category_id,
                        'release_date' => $release_date,
                        'image' => $image_path,
                        'created_by' => $_SESSION['user_id'] // NEW: Add created_by
                    ];
                    
                    if ($this->newsModel->create($data)) {
                        $_SESSION['success_message'] = "News article created successfully!";
                        $this->redirect('/admin/news-list');
                    } else {
                        $error = "Failed to create news article.";
                    }
                }
            }
            
            // If there's an error, show form again with error message
            $categories = $this->categoryModel->findAll();
            $this->view('admin/add_news', [
                'error' => $error ?? null,
                'categories' => $categories
            ]);
            
        } else {
            // Show form
            $categories = $this->categoryModel->findAll();
            $this->view('admin/add_news', [
                'categories' => $categories
            ]);
        }
    }

    public function editNews() {
        $this->requireAuth();
        $this->requireAdmin();
        
        $id = $_GET['id'] ?? null;
        
        if (!$id || !is_numeric($id)) {
            $this->redirect('/admin/news-list');
        }
        
        $news = $this->newsModel->findByIdWithCategory($id);
        
        if (!$news) {
            $this->redirect('/admin/news-list');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $release_date = $_POST['release_date'] ?? '';
            
            // Validation
            if (empty($title) || empty($content) || empty($category_id) || empty($release_date)) {
                $error = "All fields are required.";
            } else {
                $data = [
                    'title' => $title,
                    'content' => $content,
                    'category_id' => $category_id,
                    'release_date' => $release_date
                    // NOTE: created_by tidak diubah saat edit
                ];
                
                // Handle file upload if new image is provided
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    // FIXED: Correct upload directory
                    $upload_dir = dirname(APP_PATH) . '/public/assets/news/';
                    
                    // Create uploads directory if it doesn't exist
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    
                    $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if (in_array($file_extension, $allowed_extensions)) {
                        $new_filename = uniqid() . '.' . $file_extension;
                        $target_path = $upload_dir . $new_filename;
                        
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                            // FIXED: Delete old image with correct path
                            if (!empty($news['image']) && file_exists(dirname(APP_PATH) . '/' . $news['image'])) {
                                unlink(dirname(APP_PATH) . '/' . $news['image']);
                            }
                            
                            // FIXED: Store relative path for database
                            $data['image'] = 'assets/news/' . $new_filename;
                        } else {
                            $error = "Failed to upload image.";
                        }
                    } else {
                        $error = "Invalid image format. Please use JPG, JPEG, PNG, or GIF.";
                    }
                }
                
                // Save to database if no errors
                if (!isset($error)) {
                    if ($this->newsModel->update($id, $data)) {
                        $_SESSION['success_message'] = "News article updated successfully!";
                        $this->redirect('/admin/news-list');
                    } else {
                        $error = "Failed to update news article.";
                    }
                }
            }
        }
        
        // Show form (GET request or error in POST)
        $categoriesFromDB = $this->categoryModel->findAll();
        $this->view('admin/edit_news', [
            'news' => $news,
            'categoriesFromDB' => $categoriesFromDB,
            'error' => $error ?? null
        ]);
    }
    
    public function deleteNews() {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['delete_id'] ?? null;
            if ($id && is_numeric($id)) {
                // Get news info before deleting for image cleanup
                $news = $this->newsModel->findById($id);
                
                if ($this->newsModel->delete($id)) {
                    // FIXED: Delete associated image file with correct path
                    if ($news && !empty($news['image']) && file_exists(dirname(APP_PATH) . '/' . $news['image'])) {
                        unlink(dirname(APP_PATH) . '/' . $news['image']);
                    }
                    
                    $_SESSION['success_message'] = 'News article deleted successfully!';
                } else {
                    $_SESSION['error_message'] = 'Failed to delete news article.';
                }
            }
        }
        
        $this->redirect('/admin/news-list');
    }
}