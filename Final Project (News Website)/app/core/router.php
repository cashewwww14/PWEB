<?php
class Router {
    private $routes = [];
    
    public function add($route, $controller, $action, $method = 'GET') {
        $this->routes[] = [
            'route' => $route,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ];
    }
    
    public function dispatch($url, $method) {
        // Remove query string from URL
        $url = strtok($url, '?');
        
        foreach ($this->routes as $route) {
            if ($this->match($route['route'], $url) && $route['method'] === $method) {
                $controllerName = $route['controller'];
                $actionName = $route['action'];
                
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $actionName)) {
                        return $controller->$actionName();
                    }
                }
            }
        }
        
        // 404 Not Found
        $this->show404();
    }
    
    private function match($route, $url) {
        // Convert route pattern to regex
        $route = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $route);
        $pattern = '#^' . $route . '$#';
        
        if (preg_match($pattern, $url, $matches)) {
            // Store parameters
            foreach ($matches as $key => $value) {
                if (!is_numeric($key)) {
                    $_GET[$key] = $value;
                }
            }
            return true;
        }
        
        return false;
    }
    
    private function show404() {
        http_response_code(404);
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>404 - Page Not Found</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
        <body class="bg-gray-100 flex items-center justify-center min-h-screen">
            <div class="text-center">
                <h1 class="text-6xl font-bold text-gray-800">404</h1>
                <p class="text-xl text-gray-600 mb-4">Page Not Found</p>
                <a href="/" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Go Home</a>
            </div>
        </body>
        </html>';
    }
}

// Setup Routes
$router = new Router();

// Home routes
$router->add('/', 'NewsController', 'index');
$router->add('/news/{id}', 'NewsController', 'detail');

// Auth routes
$router->add('/auth/login', 'AuthController', 'login');
$router->add('/auth/login', 'AuthController', 'login', 'POST');
$router->add('/auth/register', 'AuthController', 'register');
$router->add('/auth/register', 'AuthController', 'register', 'POST');
$router->add('/auth/logout', 'AuthController', 'logout');

// User routes
$router->add('/user/dashboard', 'UserController', 'dashboard');
$router->add('/user/dashboard', 'UserController', 'dashboard', 'POST');
$router->add('/user/remove-bookmark', 'UserController', 'removeBookmark', 'POST');

// Admin routes
$router->add('/admin', 'AdminController', 'dashboard');
$router->add('/admin/dashboard', 'AdminController', 'dashboard');
$router->add('/admin/news', 'AdminController', 'listNews');
$router->add('/admin/news/add', 'AdminController', 'addNews');
$router->add('/admin/news/add', 'AdminController', 'addNews', 'POST');
$router->add('/admin/news/edit/{id}', 'AdminController', 'editNews');
$router->add('/admin/news/edit/{id}', 'AdminController', 'editNews', 'POST');
$router->add('/admin/news/delete/{id}', 'AdminController', 'deleteNews', 'POST');

// Interaction routes
$router->add('/interactions/toggle-like', 'InteractionController', 'toggleLike', 'POST');
$router->add('/interactions/toggle-bookmark', 'InteractionController', 'toggleBookmark', 'POST');
$router->add('/interactions/add-comment', 'InteractionController', 'addComment', 'POST');
$router->add('/interactions/delete-comment', 'InteractionController', 'deleteComment', 'POST');