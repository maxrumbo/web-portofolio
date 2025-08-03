<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$admin_username = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Maxwell Portfolio</title>
    <link rel="stylesheet" href="admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1b26 0%, #24283b 50%, #16161e 100%);
            padding: 20px;
        }
        
        .dashboard-header {
            background: rgba(36, 40, 59, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid rgba(187, 154, 247, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .welcome-text h1 {
            color: #c0caf5;
            font-size: 1.8rem;
            margin-bottom: 5px;
        }
        
        .welcome-text p {
            color: #a9b1d6;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #7dcfff, #bb9af7);
            color: #1a1b26;
        }
        
        .btn-secondary {
            background: rgba(125, 207, 255, 0.1);
            color: #7dcfff;
            border: 1px solid rgba(125, 207, 255, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(125, 207, 255, 0.3);
        }
        
        .dashboard-content {
            background: rgba(36, 40, 59, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid rgba(187, 154, 247, 0.2);
            text-align: center;
        }
        
        .dashboard-content h2 {
            color: #c0caf5;
            margin-bottom: 15px;
        }
        
        .dashboard-content p {
            color: #a9b1d6;
            line-height: 1.6;
        }
        
        .coming-soon {
            background: rgba(125, 207, 255, 0.1);
            border: 1px solid rgba(125, 207, 255, 0.3);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .coming-soon i {
            font-size: 2rem;
            color: #7dcfff;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="welcome-text">
                <h1>Welcome back, <?php echo htmlspecialchars($admin_username); ?>!</h1>
                <p>Maxwell Portfolio Admin Dashboard</p>
            </div>
            <div class="header-actions">
                <a href="../index.html" class="btn btn-secondary" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    View Portfolio
                </a>
                <a href="logout.php" class="btn btn-primary">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>
        
        <div class="dashboard-content">
            <h2>Admin Dashboard</h2>
            <p>You have successfully logged in to the admin panel!</p>
            
            <div class="coming-soon">
                <i class="fas fa-tools"></i>
                <h3>Coming Soon</h3>
                <p>Content management features will be added here.<br>
                For now, you can view your portfolio and logout when done.</p>
            </div>
        </div>
    </div>
</body>
</html>
