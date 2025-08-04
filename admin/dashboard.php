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
            align-items: center;
            justify-content: flex-end;
            flex-shrink: 0;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-left: 2px;
            margin-right: 2px;
            white-space: nowrap;
        }
        
        .btn-secondary {
            margin-right: 8px;
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
                <a href="../index.html" class="btn btn-secondary" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    View Portfolio
                </a>
                <a href="edit-portfolio.php" class="btn btn-accent">
                    <i class="fas fa-edit"></i>
                    Edit Portfolio
                </a>
                <a href="logout.php" class="btn btn-primary">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>
        
        <div class="dashboard-content">
            <h2>Portfolio Management System</h2>
            <p>Manage your portfolio content with powerful editing tools!</p>
            
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3>Quick Edit</h3>
                    <p>Edit portfolio content directly from dashboard</p>
                    <button class="card-btn" onclick="toggleEditor()">
                        <i class="fas fa-edit"></i>
                        Start Editing
                    </button>
                </div>
                
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="fas fa-file-edit"></i>
                    </div>
                    <h3>Hero Section</h3>
                    <p>Edit your name, role, and personal information</p>
                    <button class="card-btn" onclick="showHeroEditor()">
                        <i class="fas fa-user-edit"></i>
                        Edit Hero
                    </button>
                </div>
                
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3>Skills & Projects</h3>
                    <p>Manage your skills and project portfolio</p>
                    <button class="card-btn" onclick="showSkillsEditor()">
                        <i class="fas fa-plus"></i>
                        Edit Content
                    </button>
                </div>
            </div>
            
            <!-- Inline Editor Modal -->
            <div id="editor-modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 1000; padding: 20px;">
                <div style="background: rgba(36, 40, 59, 0.95); border-radius: 15px; max-width: 800px; margin: 0 auto; padding: 30px; max-height: 90vh; overflow-y: auto;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="color: #c0caf5; margin: 0;">Portfolio Editor</h3>
                        <button onclick="closeEditor()" style="background: rgba(255, 92, 87, 0.2); border: 1px solid rgba(255, 92, 87, 0.5); color: #ff5c57; padding: 8px 12px; border-radius: 4px; cursor: pointer;">
                            <i class="fas fa-times"></i> Close
                        </button>
                    </div>
                    
                    <div id="editor-content">
                        <!-- Dynamic editor content will be loaded here -->
                    </div>
                    
                    <div style="margin-top: 20px; text-align: center;">
                        <button onclick="saveChanges()" style="background: linear-gradient(135deg, #9ece6a, #73daca); color: #1a1b26; padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                    
                    <div id="save-message" style="display: none; margin-top: 15px; padding: 12px; background: rgba(158, 206, 106, 0.2); border: 1px solid rgba(158, 206, 106, 0.5); color: #9ece6a; border-radius: 8px; text-align: center;">
                        Changes saved successfully!
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function toggleEditor() {
            document.getElementById('editor-modal').style.display = 'block';
            loadGeneralEditor();
        }
        
        function showHeroEditor() {
            document.getElementById('editor-modal').style.display = 'block';
            loadHeroEditor();
        }
        
        function showSkillsEditor() {
            document.getElementById('editor-modal').style.display = 'block';
            loadSkillsEditor();
        }
        
        function closeEditor() {
            document.getElementById('editor-modal').style.display = 'none';
        }
        
        function loadGeneralEditor() {
            const content = `
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #c0caf5; margin-bottom: 8px;">Portfolio Title</label>
                    <input type="text" id="portfolio-title" value="Maxwell Rumahorbo - Portfolio" style="width: 100%; padding: 12px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #c0caf5; margin-bottom: 8px;">Meta Description</label>
                    <textarea id="meta-description" rows="3" style="width: 100%; padding: 12px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">Maxwell Rumahorbo's professional portfolio showcasing web development projects and skills.</textarea>
                </div>
            `;
            document.getElementById('editor-content').innerHTML = content;
        }
        
        function loadHeroEditor() {
            const content = `
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #c0caf5; margin-bottom: 8px;">Full Name</label>
                    <input type="text" id="hero-name" value="Maxwell Rumahorbo" style="width: 100%; padding: 12px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #c0caf5; margin-bottom: 8px;">Professional Role</label>
                    <input type="text" id="hero-role" value="Information Systems Student" style="width: 100%; padding: 12px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #c0caf5; margin-bottom: 8px;">University/Company</label>
                    <input type="text" id="hero-university" value="Institut Teknologi Del" style="width: 100%; padding: 12px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #c0caf5; margin-bottom: 8px;">Graduation Year</label>
                    <input type="number" id="hero-year" value="2024" style="width: 100%; padding: 12px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                </div>
            `;
            document.getElementById('editor-content').innerHTML = content;
        }
        
        function loadSkillsEditor() {
            const content = `
                <div style="margin-bottom: 20px;">
                    <h4 style="color: #c0caf5; margin-bottom: 15px;">Add New Skill</h4>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; margin-bottom: 15px;">
                        <div>
                            <label style="display: block; color: #a9b1d6; font-size: 0.8rem; margin-bottom: 5px;">Skill Name</label>
                            <input type="text" id="new-skill-name" placeholder="e.g., Python" style="width: 100%; padding: 10px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; color: #a9b1d6; font-size: 0.8rem; margin-bottom: 5px;">Icon Class</label>
                            <input type="text" id="new-skill-icon" placeholder="fab fa-python" style="width: 100%; padding: 10px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                        </div>
                        <div style="width: 80px;">
                            <label style="display: block; color: #a9b1d6; font-size: 0.8rem; margin-bottom: 5px;">Level %</label>
                            <input type="number" id="new-skill-level" value="80" min="0" max="100" style="width: 100%; padding: 10px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                        </div>
                    </div>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <h4 style="color: #c0caf5; margin-bottom: 15px;">Add New Project</h4>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; color: #a9b1d6; font-size: 0.8rem; margin-bottom: 5px;">Project Title</label>
                        <input type="text" id="new-project-title" placeholder="My Awesome Project" style="width: 100%; padding: 10px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; color: #a9b1d6; font-size: 0.8rem; margin-bottom: 5px;">Description</label>
                        <textarea id="new-project-desc" rows="3" placeholder="Describe your project..." style="width: 100%; padding: 10px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;"></textarea>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 10px;">
                        <div>
                            <label style="display: block; color: #a9b1d6; font-size: 0.8rem; margin-bottom: 5px;">Technologies (comma-separated)</label>
                            <input type="text" id="new-project-tech" placeholder="HTML, CSS, JavaScript" style="width: 100%; padding: 10px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                        </div>
                        <div style="width: 150px;">
                            <label style="display: block; color: #a9b1d6; font-size: 0.8rem; margin-bottom: 5px;">Icon</label>
                            <input type="text" id="new-project-icon" placeholder="fas fa-code" style="width: 100%; padding: 10px; background: rgba(36, 40, 59, 0.8); border: 1px solid rgba(125, 207, 255, 0.3); border-radius: 6px; color: #c0caf5; box-sizing: border-box;">
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('editor-content').innerHTML = content;
        }
        
        function saveChanges() {
            // Show loading/saving state
            const saveBtn = event.target;
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            saveBtn.disabled = true;
            
            // Simulate save process
            setTimeout(() => {
                // Show success message
                document.getElementById('save-message').style.display = 'block';
                
                // Reset button
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
                
                // Hide success message after 3 seconds
                setTimeout(() => {
                    document.getElementById('save-message').style.display = 'none';
                }, 3000);
                
                // In real implementation, you would send data to save-portfolio.php here
                console.log('Changes would be saved to backend');
            }, 1500);
        }
        
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
