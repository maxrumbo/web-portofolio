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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #7dcfff;
            --accent: #9ece6a;
            --danger: #ff5c57;
            --bg: #232946;
            --card: #16161aee;
            --input: #232946;
            --radius: 16px;
        }
        body {
            background: var(--bg);
            color: #fff;
            font-family: 'Fira Code', 'Arial', monospace;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: var(--card);
            box-shadow: 0 8px 32px #0005;
            border-radius: var(--radius);
            padding: 40px 32px 32px 32px;
            min-width: 340px;
            max-width: 95vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1.5px solid var(--primary);
        }
        .login-card .icon {
            font-size: 2.8rem;
            color: var(--primary);
            margin-bottom: 10px;
        }
        .login-card h2 {
            margin-bottom: 18px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .login-card input {
            width: 100%;
            padding: 13px 14px;
            margin-bottom: 16px;
            border-radius: 8px;
            border: 1.5px solid var(--primary);
            background: var(--input);
            color: #fff;
            font-size: 1rem;
            transition: border 0.2s;
        }
        .login-card input:focus {
            outline: none;
            border: 1.5px solid var(--accent);
        }
        .login-card button {
            width: 100%;
            padding: 13px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            color: #232946;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s, color 0.2s;
        }
        .login-card button:hover {
            background: linear-gradient(90deg, var(--accent), var(--primary));
            color: #fff;
        }
        .error {
            color: var(--danger);
            margin-bottom: 12px;
            text-align: center;
            font-weight: 500;
        }
        .login-footer {
            margin-top: 18px;
            color: #a9b1d6;
            font-size: 0.95rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <form class="login-card" method="post" autocomplete="off">
        <div class="icon"><i class="fas fa-user-shield"></i></div>
        <h2>Admin Login</h2>
        <?php if ($error) echo '<div class="error">'.$error.'</div>'; ?>
        <input type="text" name="username" placeholder="Username" required autofocus>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
        <button type="button" onclick="window.location.href='../index.html'" style="margin-top:10px;background:transparent;color:var(--primary);border:1.5px solid var(--primary);font-weight:600;">
            <i class="fas fa-arrow-left"></i> Back to Portfolio
        </button>
        <div class="login-footer">&copy; maxrumbo | Portfolio Admin</div>
    </form>
</body>
</html>
