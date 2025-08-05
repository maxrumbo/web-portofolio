<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Maxwell Portfolio</title>
    <link rel="stylesheet" href="admin-style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="welcome-message">
                <h1>Welcome Back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p>This is your control center.</p>
            </div>
            <div class="user-actions">
                <a href="../index.php" target="_blank" class="btn btn-secondary"><i class="fas fa-eye"></i> View Portfolio</a>
                <a href="logout.php" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>

        <main class="dashboard-main">
            <div class="main-title">
                <h2>Admin Dashboard</h2>
                <p>You have successfully logged in to the admin panel!</p>
            </div>

            <div class="dashboard-grid">
                <div class="grid-item">
                    <div class="card-content">
                        <h3><i class="fas fa-edit"></i> Manage Portfolio</h3>
                        <p>Click the button below to edit your portfolio content.</p>
                        <a href="edit-portfolio-simple.php" class="btn btn-primary btn-full-width">
                            <i class="fas fa-pencil-alt"></i> EDIT PORTFOLIO NOW
                        </a>
                    </div>
                </div>
                <div class="grid-item">
                    <div class="card-content">
                        <h3><i class="fas fa-info-circle"></i> System Info</h3>
                        <ul class="system-info-list">
                            <li><strong>PHP Version:</strong> <?php echo phpversion(); ?></li>
                            <li><strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
                            <li><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>

        <footer class="dashboard-footer">
            <p>&copy; <?php echo date("Y"); ?> Maxwell Rumahorbo. Admin Panel.</p>
        </footer>
    </div>
</body>
</html>