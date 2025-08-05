<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portfolio - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1b26 0%, #24283b 50%, #16161e 100%);
            color: #c0caf5;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(36, 40, 59, 0.95);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid rgba(125, 207, 255, 0.3);
        }
        
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #9ece6a;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #c0caf5;
        }
        
        input, textarea {
            width: 100%;
            padding: 12px;
            background: rgba(26, 27, 38, 0.8);
            border: 1px solid rgba(125, 207, 255, 0.3);
            border-radius: 6px;
            color: #c0caf5;
            font-size: 14px;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: rgba(125, 207, 255, 0.6);
            box-shadow: 0 0 10px rgba(125, 207, 255, 0.2);
        }
        
        .btn {
            background: linear-gradient(135deg, #9ece6a, #73daca);
            color: #1a1b26;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            margin: 10px 5px;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(158, 206, 106, 0.4);
        }
        
        .btn-secondary {
            background: rgba(125, 207, 255, 0.2);
            color: #7dcfff;
            border: 1px solid rgba(125, 207, 255, 0.3);
        }
        
        .success-message {
            background: rgba(158, 206, 106, 0.2);
            border: 1px solid rgba(158, 206, 106, 0.5);
            color: #9ece6a;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        
        .section {
            background: rgba(26, 27, 38, 0.5);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid rgba(125, 207, 255, 0.2);
        }
        
        .section h3 {
            color: #7dcfff;
            margin-bottom: 15px;
        }
        
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-edit"></i> Edit Portfolio</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> Portfolio updated successfully!
            </div>
        <?php endif; ?>
        
        <form method="POST" action="save-portfolio-simple.php">
            <!-- Hero Section -->
            <div class="section">
                <h3><i class="fas fa-home"></i> Hero Section</h3>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="hero_name" value="Maxwell Rumahorbo" required>
                    </div>
                    <div class="form-group">
                        <label>Professional Role</label>
                        <input type="text" name="hero_role" value="Information Systems Student" required>
                    </div>
                    <div class="form-group">
                        <label>University/Company</label>
                        <input type="text" name="hero_university" value="Institut Teknologi Del" required>
                    </div>
                    <div class="form-group">
                        <label>Employee/Student ID</label>
                        <input type="text" name="hero_id" value="2024.DEV.001" required>
                    </div>
                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" name="hero_department" value="Information Technology" required>
                    </div>
                    <div class="form-group">
                        <label>Graduation Year</label>
                        <input type="number" name="hero_year" value="2024" required>
                    </div>
                </div>
            </div>
            
            <!-- About Section -->
            <div class="section">
                <h3><i class="fas fa-user"></i> About Section</h3>
                <div class="form-group">
                    <label>About Description</label>
                    <textarea name="about_description" rows="4" required>Passionate Information Systems student at Institut Teknologi Del with a strong foundation in web development and software engineering. I enjoy creating innovative solutions and learning new technologies to build the future, one line of code at a time.</textarea>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Your Passion</label>
                        <textarea name="about_passion" rows="3" required>Creating innovative web solutions and learning new technologies every day</textarea>
                    </div>
                    <div class="form-group">
                        <label>Career Goal</label>
                        <textarea name="about_goal" rows="3" required>Building the future, one line of code at a time</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Contact Section -->
            <div class="section">
                <h3><i class="fas fa-envelope"></i> Contact Section</h3>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="contact_email" value="maxrumbo@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label>WhatsApp Number</label>
                        <input type="text" name="contact_whatsapp" value="6282183096287" required>
                    </div>
                    <div class="form-group">
                        <label>GitHub Username</label>
                        <input type="text" name="contact_github" value="maxrumbo" required>
                    </div>
                    <div class="form-group">
                        <label>Instagram Username</label>
                        <input type="text" name="contact_instagram" value="maxwellrumbo_" required>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </form>
    </div>
</body>
</html>
