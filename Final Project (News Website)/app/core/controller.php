<?php
abstract class Controller {
    protected function view($view, $data = []) {
        extract($data);
        
        $viewFile = APP_PATH . "/views/{$view}.php";
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            throw new Exception("View {$view} not found");
        }
    }
    
    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }
    
    protected function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/auth/login');
        }
    }
    
    protected function requireAdmin() {
        $this->requireAuth();
        if ($_SESSION['role'] !== 'admin') {
            $this->redirect('/');
        }
    }
    
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}