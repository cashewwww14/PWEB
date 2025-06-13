<?php 
$title = 'Login - News Portal';
require_once APP_PATH . '/views/layouts/header.php'; 
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0;
        padding: 0;
        color: #333;
        min-height: 100vh;
    }
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }
    .auth-card {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }
    .auth-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .auth-header h1 {
        color: #333;
        font-size: 2rem;
        margin-bottom: 10px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #555;
    }
    .form-group input {
        width: 100%;
        padding: 12px;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    .form-group input:focus {
        border-color: #667eea;
        outline: none;
    }
    .btn-primary {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
    }
    .back-link {
        position: absolute;
        top: 20px;
        left: 20px;
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        backdrop-filter: blur(10px);
    }
    .back-link:hover {
    background: rgba(255, 255, 255, 0.3);
    }
    .auth-footer {
        text-align: center;
        margin-top: 20px;
    }
    .auth-footer a {
        color: #667eea;
        text-decoration: none;
    }
    .error-message {
        background: #fee;
        border: 1px solid #fcc;
        color: #c33;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
</style>

<a href="/" class="back-link">&lt;&nbsp;&nbsp;Back to Homepage</a>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Welcome Back</h1>
            <p style="color: #666;">Sign in to your account</p>
        </div>

        <?php if (isset($_GET['registered'])): ?>
            <div style="background: #dfd; border: 1px solid #cfc; color: #363; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                Registration successful! Please login with your credentials.
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/auth/login" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="btn-primary">Sign In</button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="/auth/register">Sign up here</a></p>
        </div>
    </div>
</div>
