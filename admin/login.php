<?php
session_start();
require_once 'config.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

// Process login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Authenticate user with database
    $user = authenticateUser($username, $password);
    
    if ($user) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_fullname'] = $user['full_name'];
        $_SESSION['admin_email'] = $user['email'];
        $_SESSION['admin_role'] = $user['role'];
        $_SESSION['admin_id'] = $user['id'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Maxwell Portfolio</title>
    <link rel="stylesheet" href="admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-lock"></i>
                <h2>Admin Login</h2>
                <p>Maxwell Portfolio Dashboard</p>
            </div>
            
            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i>
                        Username
                    </label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-key"></i>
                        Password
                    </label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" name="login" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
            </form>
            
            <div class="login-footer">
                <a href="../index.html" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to Portfolio
                </a>
            </div>
        </div>
    </div>
</body>
</html>
