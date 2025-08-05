<?php
session_start();
require_once 'config.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare('SELECT * FROM admin WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $row['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Username tidak ditemukan!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Portfolio</title>
    <link rel="stylesheet" href="admin-style.css">
    <style>
        body {background: #232946; color: #fff; font-family: Arial, sans-serif;}
        .login-container {max-width: 350px; margin: 80px auto; background: #2a2d3e; border-radius: 10px; padding: 32px 28px; box-shadow: 0 4px 24px #0002;}
        .login-container h2 {margin-bottom: 24px; text-align: center;}
        .form-group {margin-bottom: 18px;}
        .form-group label {display: block; margin-bottom: 6px;}
        .form-group input {width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #232946; color: #fff;}
        .btn {width: 100%; padding: 12px; background: #9ece6a; color: #232946; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;}
        .error {color: #ff5c57; margin-bottom: 12px; text-align: center;}
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <?php if ($error) echo '<div class="error">'.$error.'</div>'; ?>
        <form method="post" autocomplete="off">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
