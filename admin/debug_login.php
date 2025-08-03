<?php
session_start();

$error = '';

// Process login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    echo "<h2>Debug Login Process</h2>";
    echo "<p>Username: $username</p>";
    echo "<p>Password: $password</p>";
    
    try {
        // Test direct database connection here
        $host = 'localhost';
        $dbname = 'portfolio_admin';
        $db_username = 'root';
        $db_password = '';
        
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $pdo = new PDO($dsn, $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "<p style='color: green;'>✅ Direct database connection OK</p>";
        
        // Test query
        $sql = "SELECT id, username, password, email, full_name, role, is_active FROM users WHERE username = ? AND is_active = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo "<p style='color: blue;'>✅ User found in database</p>";
            echo "<pre>" . print_r($user, true) . "</pre>";
            
            if ($user['password'] === $password) {
                echo "<p style='color: green;'>✅ Password matches!</p>";
                
                // Update last login
                $updateSql = "UPDATE users SET last_login = NOW() WHERE id = ?";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->execute([$user['id']]);
                
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_fullname'] = $user['full_name'];
                $_SESSION['admin_email'] = $user['email'];
                $_SESSION['admin_role'] = $user['role'];
                $_SESSION['admin_id'] = $user['id'];
                
                echo "<p style='color: green;'>✅ Session created, redirecting to dashboard...</p>";
                echo "<script>setTimeout(function() { window.location.href = 'dashboard.php'; }, 2000);</script>";
                exit();
            } else {
                echo "<p style='color: red;'>❌ Password does not match</p>";
                echo "<p>Expected: " . $user['password'] . "</p>";
                echo "<p>Provided: " . $password . "</p>";
                $error = 'Invalid password!';
            }
        } else {
            echo "<p style='color: red;'>❌ User not found in database</p>";
            $error = 'User not found!';
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
        $error = 'Database connection failed!';
    }
    
    echo "<br><a href='login.php'>← Back to login</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Login - Maxwell Portfolio</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-bug"></i>
                <h2>Debug Login</h2>
                <p>Test login dengan debug info</p>
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
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>

                <button type="submit" name="login" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    DEBUG LOGIN
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
