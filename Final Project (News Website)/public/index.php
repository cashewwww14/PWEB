<?php
session_start();

// Define paths
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

// Error reporting (development only - should be disabled in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// TODO: Add environment-based error reporting
// if (getenv('ENV') === 'production') {
//     error_reporting(0);
//     ini_set('display_errors', 0);
// }

// Autoload core classes
require_once APP_PATH . '/config/database.php';
require_once APP_PATH . '/core/router.php';
require_once APP_PATH . '/core/controller.php';
require_once APP_PATH . '/core/model.php';

// Autoload models
require_once APP_PATH . '/models/news.php';
require_once APP_PATH . '/models/user.php';
require_once APP_PATH . '/models/category.php'; // MISSING - Needed for CategoryController
require_once APP_PATH . '/models/interaction.php';
require_once APP_PATH . '/models/comment.php';

// Autoload controllers
require_once APP_PATH . '/controllers/authcontroller.php';
require_once APP_PATH . '/controllers/newscontroller.php';
require_once APP_PATH . '/controllers/admincontroller.php';
require_once APP_PATH . '/controllers/usercontroller.php';
require_once APP_PATH . '/controllers/interactioncontroller.php';
require_once APP_PATH . '/controllers/categorycontroller.php';

// Initialize router
$router = new Router();

// ===== HOME ROUTES =====
$router->add('/', 'NewsController', 'index');
$router->add('/news/{id}', 'NewsController', 'detail');

// ===== AUTH ROUTES =====
$router->add('/auth/login', 'AuthController', 'login');
$router->add('/auth/login', 'AuthController', 'login', 'POST');
$router->add('/auth/register', 'AuthController', 'register');
$router->add('/auth/register', 'AuthController', 'register', 'POST');
$router->add('/auth/logout', 'AuthController', 'logout');

// ===== USER ROUTES =====
$router->add('/user/dashboard', 'UserController', 'dashboard');
$router->add('/user/dashboard', 'UserController', 'dashboard', 'POST');
// MISSING: User bookmark management
$router->add('/user/remove-bookmark', 'UserController', 'removeBookmark', 'POST');

// ===== ADMIN ROUTES =====
$router->add('/admin', 'AdminController', 'dashboard'); // Alias for admin dashboard
$router->add('/admin/dashboard', 'AdminController', 'dashboard');

// Admin News Management
$router->add('/admin/news-list', 'AdminController', 'newsList');
$router->add('/admin/add-news', 'AdminController', 'addNews');
$router->add('/admin/add-news', 'AdminController', 'addNews', 'POST');
$router->add('/admin/edit-news', 'AdminController', 'editNews');
$router->add('/admin/edit-news', 'AdminController', 'editNews', 'POST');
$router->add('/admin/delete-news', 'AdminController', 'deleteNews', 'POST');

// IMPROVED: More RESTful admin news routes
$router->add('/admin/news', 'AdminController', 'newsList'); // Alternative route
$router->add('/admin/news/add', 'AdminController', 'addNews');
$router->add('/admin/news/add', 'AdminController', 'addNews', 'POST');
$router->add('/admin/news/edit/{id}', 'AdminController', 'editNews');
$router->add('/admin/news/edit/{id}', 'AdminController', 'editNews', 'POST');
$router->add('/admin/news/delete/{id}', 'AdminController', 'deleteNews', 'POST');

// ===== CATEGORY MANAGEMENT ROUTES (Admin only) =====
$router->add('/admin/category/list', 'CategoryController', 'listCategories');
$router->add('/admin/category/add', 'CategoryController', 'addCategory', 'POST');
$router->add('/admin/category/edit', 'CategoryController', 'editCategory', 'POST');
$router->add('/admin/category/delete', 'CategoryController', 'deleteCategory', 'POST');

// ===== INTERACTION ROUTES =====
$router->add('/interactions/toggle-like', 'InteractionController', 'toggleLike', 'POST');
$router->add('/interactions/toggle-bookmark', 'InteractionController', 'toggleBookmark', 'POST');
$router->add('/interactions/add-comment', 'InteractionController', 'addComment', 'POST');
$router->add('/interactions/delete-comment', 'InteractionController', 'deleteComment', 'POST');

// ===== API ROUTES (Optional - for future AJAX endpoints) =====
// $router->add('/api/news', 'ApiController', 'getNews');
// $router->add('/api/categories', 'ApiController', 'getCategories');

// ===== ERROR HANDLING =====
try {
    // Dispatch request
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];
    $router->dispatch($url, $method);
} catch (Exception $e) {
    // Log error in production
    error_log("Router Error: " . $e->getMessage());
    
    // Show user-friendly error page
    http_response_code(500);
    if (file_exists(APP_PATH . '/views/errors/500.php')) {
        require_once APP_PATH . '/views/errors/500.php';
    } else {
        echo '<h1>500 - Internal Server Error</h1>';
        echo '<p>Something went wrong. Please try again later.</p>';
    }
}