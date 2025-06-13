<?php
require_once APP_PATH . '/core/controller.php';
require_once APP_PATH . '/models/user.php';

class AuthController extends Controller {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function login() {
        // Redirect if already logged in
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');  // Semua role ke homepage
        }
        
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = "Email and password are required!";
            } else {
                $user = $this->userModel->authenticate($email, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    
                    $this->redirect('/');  // Semua role ke homepage
                } else {
                    $error = "Invalid email or password!";
                }
            }
        }
        
        $this->view('auth/login', ['error' => $error]);
    }
    
    public function register() {
        // Redirect if already logged in
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'birth_date' => $_POST['birth_date'] ?? '',
                'gender' => $_POST['gender'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? ''
            ];
            
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Validation
            if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
                $error = "Name, email, and password are required!";
            } elseif ($data['password'] !== $confirm_password) {
                $error = "Passwords do not match!";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format!";
            } else {
                // Check if email ends with @nextc.id to assign admin role
                if (str_ends_with(strtolower($data['email']), '@nextc.id')) {
                    $data['role'] = 'admin';
                } else {
                    $data['role'] = 'user'; // Default role for other emails
                }
                
                if ($this->userModel->register($data)) {
                    $this->redirect('/auth/login?registered=1');
                } else {
                    $error = "Email already exists or registration failed!";
                }
            }
        }
        
        $this->view('auth/register', ['error' => $error]);
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/');
    }
}