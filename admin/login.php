<?php
session_start();
if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true) {
    header('Location: dashboard.php');
    exit();
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    // Ganti username dan password sesuai kebutuhan
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['isAdmin'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body { background: #232946; color: #fff; font-family: Arial, sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-box { background: #16161a; padding: 32px 28px; border-radius: 10px; box-shadow: 0 2px 16px #0002; min-width: 320px; }
        .login-box h2 { margin-bottom: 18px; }
        .login-box input { width: 100%; padding: 10px; margin-bottom: 14px; border-radius: 6px; border: 1px solid #7dcfff; background: #232946; color: #fff; }
        .login-box button { width: 100%; padding: 10px; background: #7dcfff; color: #232946; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
        .error { color: #ff5c57; margin-bottom: 10px; }
    </style>
</head>
<body>
    <form class="login-box" method="post">
        <h2>Login Admin</h2>
        <?php if ($error) echo '<div class="error">'.$error.'</div>'; ?>
        <input type="text" name="username" placeholder="Username" required autofocus>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
