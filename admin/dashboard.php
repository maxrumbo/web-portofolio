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
            gap: 40px;
            flex-wrap: wrap;
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
            gap: 12px;
            align-items: center;
            justify-content: flex-end;
            flex-shrink: 0;
            flex-wrap: nowrap;
            min-width: 350px;
        }
        
        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
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
        
        .btn-accent {
            background: linear-gradient(135deg, #9ece6a, #73daca);
            color: #1a1b26;
            font-weight: 600;
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
            margin-bottom: 30px;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .dashboard-card {
            background: rgba(26, 27, 38, 0.8);
            border: 1px solid rgba(125, 207, 255, 0.2);
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            border-color: rgba(125, 207, 255, 0.5);
            box-shadow: 0 10px 30px rgba(125, 207, 255, 0.2);
        }
        
        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #7dcfff, #bb9af7, #9ece6a);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .dashboard-card:hover::before {
            opacity: 1;
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #7dcfff, #bb9af7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .card-icon i {
            font-size: 1.5rem;
            color: #1a1b26;
        }
        
        .dashboard-card h3 {
            color: #c0caf5;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }
        
        .dashboard-card p {
            color: #a9b1d6;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        
        .card-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #9ece6a, #73daca);
            color: #1a1b26;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .card-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(158, 206, 106, 0.3);
        }
        
        .card-btn.disabled {
            background: rgba(169, 177, 214, 0.2);
            color: #a9b1d6;
            cursor: not-allowed;
        }
        
        .card-btn.disabled:hover {
            transform: none;
            box-shadow: none;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="welcome-text">
                <h1>Welcome Back Ketua!</h1>
                <p>Selain Admin Dilarang Login</p>
            </div>
            <div class="header-actions">
                <a href="../index.html" class="btn btn-secondary">
                    <i class="fas fa-eye"></i>
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
            
            <!-- TOMBOL EDIT PORTFOLIO HIJAU BESAR -->
            <div style="text-align: center; margin: 40px 0; padding: 30px; background: rgba(158, 206, 106, 0.1); border: 2px solid #9ece6a; border-radius: 15px; box-shadow: 0 10px 30px rgba(158, 206, 106, 0.2);">
                <h3 style="color: #9ece6a; margin-bottom: 20px; font-size: 1.5rem; text-transform: uppercase; letter-spacing: 1px;">Edit Your Portfolio</h3>
                <p style="color: #a9b1d6; margin-bottom: 25px;">Click the button below to start editing your portfolio content.</p>
                <a href="edit-portfolio-simple.php" style="
                    background: linear-gradient(135deg, #9ece6a, #73daca);
                    color: #1a1b26; 
                    padding: 15px 35px; 
                    font-size: 1.1rem; 
                    font-weight: bold; 
                    text-decoration: none; 
                    border-radius: 10px; 
                    display: inline-block;
                    transition: all 0.3s ease;
                    box-shadow: 0 5px 20px rgba(158, 206, 106, 0.4);
                ">
                    <i class="fas fa-edit"></i> EDIT PORTFOLIO SEKARANG
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('editor-modal');
            if (event.target === modal) {
                closeEditor();
            }
        });
    </script>
</body>
</html>
