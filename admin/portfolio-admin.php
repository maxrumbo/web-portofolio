<?php
session_start();

// Check if user is logged in (TEMPORARILY DISABLED FOR TESTING)
/*
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
*/

// Function to read portfolio data from index.html
function getPortfolioData() {
    $indexPath = '../index.html';
    if (file_exists($indexPath)) {
        return file_get_contents($indexPath);
    }
    return false;
}

// Function to extract specific content sections
function extractSection($html, $sectionId) {
    $pattern = '/<section[^>]*id="' . $sectionId . '"[^>]*>(.*?)<\/section>/s';
    preg_match($pattern, $html, $matches);
    return isset($matches[1]) ? $matches[1] : '';
}

$portfolioHtml = getPortfolioData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portfolio - Admin Panel</title>
    <link rel="stylesheet" href="admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1a1b26 0%, #24283b 50%, #16161e 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .edit-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .edit-sidebar {
            width: 300px;
            background: rgba(26, 27, 38, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(125, 207, 255, 0.2);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(125, 207, 255, 0.1);
        }

        .sidebar-header h2 {
            color: #c0caf5;
            margin: 0 0 10px 0;
            font-size: 1.2rem;
        }

        .sidebar-header p {
            color: #a9b1d6;
            margin: 0;
            font-size: 0.85rem;
        }

        .section-list {
            padding: 20px;
            flex: 1;
        }

        .section-item {
            background: rgba(36, 40, 59, 0.6);
            border: 1px solid rgba(125, 207, 255, 0.2);
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .section-item:hover, .section-item.active {
            background: rgba(125, 207, 255, 0.1);
            border-color: rgba(125, 207, 255, 0.5);
            transform: translateX(5px);
        }

        .section-button {
            width: 100%;
            background: none;
            border: none;
            padding: 15px;
            text-align: left;
            color: #c0caf5;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-button i {
            width: 16px;
            color: #7dcfff;
        }

        .section-button span {
            font-size: 0.9rem;
        }

        /* Main Editor Area */
        .edit-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .editor-toolbar {
            background: rgba(36, 40, 59, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(125, 207, 255, 0.2);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .toolbar-left h3 {
            color: #c0caf5;
            margin: 0;
            font-size: 1.1rem;
        }

        .edit-mode-toggle {
            display: flex;
            background: rgba(26, 27, 38, 0.8);
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid rgba(125, 207, 255, 0.2);
        }

        .mode-btn {
            padding: 8px 16px;
            background: none;
            border: none;
            color: #a9b1d6;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .mode-btn.active {
            background: linear-gradient(135deg, #7dcfff, #bb9af7);
            color: #1a1b26;
        }

        .toolbar-right {
            display: flex;
            gap: 10px;
        }

        .toolbar-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-save {
            background: linear-gradient(135deg, #9ece6a, #73daca);
            color: #1a1b26;
        }

        .btn-preview {
            background: rgba(125, 207, 255, 0.2);
            color: #7dcfff;
            border: 1px solid rgba(125, 207, 255, 0.3);
        }

        .btn-back {
            background: rgba(169, 177, 214, 0.2);
            color: #a9b1d6;
            border: 1px solid rgba(169, 177, 214, 0.3);
        }

        .toolbar-btn:hover {
            transform: translateY(-2px);
        }

        /* Editor Content */
        .editor-content {
            flex: 1;
            display: flex;
            overflow: hidden;
        }

        .content-editor {
            flex: 1;
            background: rgba(26, 27, 38, 0.8);
            padding: 20px;
            overflow-y: auto;
        }

        .editor-section {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .editor-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #c0caf5;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            background: rgba(36, 40, 59, 0.8);
            border: 1px solid rgba(125, 207, 255, 0.3);
            border-radius: 6px;
            color: #c0caf5;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #7dcfff;
            box-shadow: 0 0 0 3px rgba(125, 207, 255, 0.1);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
            font-family: 'Fira Code', monospace;
        }

        /* Live Preview */
        .live-preview {
            width: 50%;
            background: #fff;
            border-left: 1px solid rgba(125, 207, 255, 0.2);
            overflow-y: auto;
            display: none;
        }

        .live-preview.active {
            display: block;
        }

        .preview-frame {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Success Message */
        .success-message {
            background: rgba(158, 206, 106, 0.2);
            border: 1px solid rgba(158, 206, 106, 0.5);
            color: #9ece6a;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 8px;
        }

        .success-message.show {
            display: flex;
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(26, 27, 38, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .loading-overlay.show {
            display: flex;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(125, 207, 255, 0.3);
            border-top: 3px solid #7dcfff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .edit-container {
                flex-direction: column;
            }
            
            .edit-sidebar {
                width: 100%;
                height: auto;
                max-height: 200px;
            }
            
            .live-preview {
                width: 100%;
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <!-- Sidebar -->
        <div class="edit-sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-edit"></i> Portfolio Editor</h2>
                <p>Select a section to edit</p>
            </div>
            
            <div class="section-list">
                <div class="section-item active" data-section="hero">
                    <button class="section-button">
                        <i class="fas fa-home"></i>
                        <span>Hero Section</span>
                    </button>
                </div>
                
                <div class="section-item" data-section="about">
                    <button class="section-button">
                        <i class="fas fa-user"></i>
                        <span>About Me</span>
                    </button>
                </div>
                
                <div class="section-item" data-section="skills">
                    <button class="section-button">
                        <i class="fas fa-code"></i>
                        <span>Skills</span>
                    </button>
                </div>
                
                <div class="section-item" data-section="projects">
                    <button class="section-button">
                        <i class="fas fa-briefcase"></i>
                        <span>Projects</span>
                    </button>
                </div>
                
                <div class="section-item" data-section="experience">
                    <button class="section-button">
                        <i class="fas fa-building"></i>
                        <span>Experience</span>
                    </button>
                </div>
                
                <div class="section-item" data-section="certificates">
                    <button class="section-button">
                        <i class="fas fa-certificate"></i>
                        <span>Certificates</span>
                    </button>
                </div>
                
                <div class="section-item" data-section="contact">
                    <button class="section-button">
                        <i class="fas fa-envelope"></i>
                        <span>Contact</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Editor -->
        <div class="edit-main">
            <!-- Toolbar -->
            <div class="editor-toolbar">
                <div class="toolbar-left">
                    <h3 id="current-section-title">Hero Section</h3>
                    
                    <div class="edit-mode-toggle">
                        <button class="mode-btn active" data-mode="edit">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="mode-btn" data-mode="preview">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                    </div>
                </div>
                
                <div class="toolbar-right">
                    <button class="toolbar-btn btn-save" id="save-btn">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <button class="toolbar-btn btn-preview" id="preview-btn">
                        <i class="fas fa-external-link-alt"></i> View Live
                    </button>
                    <a href="dashboard.php" class="toolbar-btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Editor Content -->
            <div class="editor-content">
                <div class="content-editor">
                    <div class="success-message" id="success-message">
                        <i class="fas fa-check-circle"></i>
                        <span>Changes saved successfully!</span>
                    </div>

                    <!-- Hero Section Editor -->
                    <div class="editor-section active" id="hero-editor">
                        <div class="form-group">
                            <label for="hero-name">Full Name</label>
                            <input type="text" id="hero-name" class="form-control" value="Maxwell Rumahorbo" placeholder="Enter your full name">
                        </div>
                        
                        <div class="form-group">
                            <label for="hero-role">Professional Role</label>
                            <input type="text" id="hero-role" class="form-control" value="Information Systems Student" placeholder="Enter your professional role">
                        </div>
                        
                        <div class="form-group">
                            <label for="hero-department">Department/Field</label>
                            <input type="text" id="hero-department" class="form-control" value="Information Technology" placeholder="Enter your department or field">
                        </div>
                        
                        <div class="form-group">
                            <label for="hero-employee-id">Employee/Student ID</label>
                            <input type="text" id="hero-employee-id" class="form-control" value="2024.DEV.001" placeholder="Enter your ID">
                        </div>
                        
                        <div class="form-group">
                            <label for="hero-university">University/Company</label>
                            <input type="text" id="hero-university" class="form-control" value="Institut Teknologi Del" placeholder="Enter your university or company">
                        </div>
                        
                        <div class="form-group">
                            <label for="hero-graduation-year">Graduation/Start Year</label>
                            <input type="number" id="hero-graduation-year" class="form-control" value="2024" placeholder="Enter year">
                        </div>
                    </div>

                    <!-- About Section Editor -->
                    <div class="editor-section" id="about-editor">
                        <div class="form-group">
                            <label for="about-description">About Description</label>
                            <textarea id="about-description" class="form-control" rows="6" placeholder="Write about yourself...">Passionate Information Systems student at Institut Teknologi Del with a strong foundation in web development and software engineering. I enjoy creating innovative solutions and learning new technologies to build the future, one line of code at a time.</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="about-passion">Your Passion</label>
                            <textarea id="about-passion" class="form-control" rows="3" placeholder="What drives you...">Creating innovative web solutions and learning new technologies every day</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="about-goal">Career Goal</label>
                            <textarea id="about-goal" class="form-control" rows="3" placeholder="Your career aspirations...">Building the future, one line of code at a time</textarea>
                        </div>
                    </div>

                    <!-- Skills Section Editor -->
                    <div class="editor-section" id="skills-editor">
                        <p style="color: #a9b1d6; margin-bottom: 20px;">
                            <i class="fas fa-info-circle"></i> 
                            Manage your skills and proficiency levels. Skills are displayed with progress bars.
                        </p>
                        
                        <div id="skills-list">
                            <!-- Skills will be dynamically loaded here -->
                        </div>
                        
                        <button type="button" class="toolbar-btn btn-preview" id="add-skill-btn">
                            <i class="fas fa-plus"></i> Add New Skill
                        </button>
                    </div>

                    <!-- Projects Section Editor -->
                    <div class="editor-section" id="projects-editor">
                        <p style="color: #a9b1d6; margin-bottom: 20px;">
                            <i class="fas fa-info-circle"></i> 
                            Showcase your projects with descriptions and technologies used.
                        </p>
                        
                        <div id="projects-list">
                            <!-- Projects will be dynamically loaded here -->
                        </div>
                        
                        <button type="button" class="toolbar-btn btn-preview" id="add-project-btn">
                            <i class="fas fa-plus"></i> Add New Project
                        </button>
                    </div>

                    <!-- Contact Section Editor -->
                    <div class="editor-section" id="contact-editor">
                        <div class="form-group">
                            <label for="contact-email">Email Address</label>
                            <input type="email" id="contact-email" class="form-control" value="maxrumbo@gmail.com" placeholder="Enter your email">
                        </div>
                        
                        <div class="form-group">
                            <label for="contact-phone">Phone/WhatsApp</label>
                            <input type="text" id="contact-phone" class="form-control" value="6282183096287" placeholder="Enter your phone number">
                        </div>
                        
                        <div class="form-group">
                            <label for="contact-github">GitHub Username</label>
                            <input type="text" id="contact-github" class="form-control" value="maxrumbo" placeholder="GitHub username">
                        </div>
                        
                        <div class="form-group">
                            <label for="contact-instagram">Instagram Handle</label>
                            <input type="text" id="contact-instagram" class="form-control" value="maxwellrumbo_" placeholder="Instagram handle">
                        </div>
                    </div>

                    <!-- Placeholder for other sections -->
                    <div class="editor-section" id="experience-editor">
                        <p style="color: #a9b1d6; text-align: center; padding: 40px;">
                            <i class="fas fa-tools" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                            Experience editor coming soon!<br>
                            <small>This feature is under development.</small>
                        </p>
                    </div>

                    <div class="editor-section" id="certificates-editor">
                        <p style="color: #a9b1d6; text-align: center; padding: 40px;">
                            <i class="fas fa-tools" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                            Certificates editor coming soon!<br>
                            <small>This feature is under development.</small>
                        </p>
                    </div>
                </div>

                <!-- Live Preview -->
                <div class="live-preview" id="live-preview">
                    <iframe src="../index.html" class="preview-frame" id="preview-frame"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <script>
        // Editor functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Section switching
            const sectionItems = document.querySelectorAll('.section-item');
            const editorSections = document.querySelectorAll('.editor-section');
            const currentSectionTitle = document.getElementById('current-section-title');

            sectionItems.forEach(item => {
                item.addEventListener('click', function() {
                    const sectionId = this.dataset.section;
                    
                    // Update active states
                    sectionItems.forEach(s => s.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Switch editor sections
                    editorSections.forEach(s => s.classList.remove('active'));
                    document.getElementById(sectionId + '-editor').classList.add('active');
                    
                    // Update title
                    const sectionNames = {
                        'hero': 'Hero Section',
                        'about': 'About Me',
                        'skills': 'Skills',
                        'projects': 'Projects',
                        'experience': 'Experience',
                        'certificates': 'Certificates',
                        'contact': 'Contact'
                    };
                    currentSectionTitle.textContent = sectionNames[sectionId];
                });
            });

            // Mode toggle (Edit/Preview)
            const modeButtons = document.querySelectorAll('.mode-btn');
            const contentEditor = document.querySelector('.content-editor');
            const livePreview = document.querySelector('.live-preview');

            modeButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const mode = this.dataset.mode;
                    
                    modeButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    if (mode === 'preview') {
                        contentEditor.style.width = '50%';
                        livePreview.classList.add('active');
                    } else {
                        contentEditor.style.width = '100%';
                        livePreview.classList.remove('active');
                    }
                });
            });

            // Save functionality
            const saveBtn = document.getElementById('save-btn');
            const successMessage = document.getElementById('success-message');
            const loadingOverlay = document.getElementById('loading-overlay');

            saveBtn.addEventListener('click', function() {
                const activeSection = document.querySelector('.section-item.active').dataset.section;
                const sectionData = collectSectionData(activeSection);
                
                if (!sectionData) {
                    alert('Please fill in all required fields before saving.');
                    return;
                }

                loadingOverlay.classList.add('show');
                
                // Send data to backend
                fetch('save-portfolio.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        section: activeSection,
                        data: sectionData
                    })
                })
                .then(response => response.json())
                .then(data => {
                    loadingOverlay.classList.remove('show');
                    
                    if (data.success) {
                        successMessage.querySelector('span').textContent = data.message;
                        successMessage.classList.add('show');
                        
                        setTimeout(() => {
                            successMessage.classList.remove('show');
                        }, 4000);
                        
                        // Refresh preview
                        const previewFrame = document.getElementById('preview-frame');
                        if (previewFrame && previewFrame.style.display !== 'none') {
                            setTimeout(() => {
                                previewFrame.src = previewFrame.src + '?t=' + new Date().getTime();
                            }, 500);
                        }
                    } else {
                        alert('Error saving changes: ' + data.message);
                    }
                })
                .catch(error => {
                    loadingOverlay.classList.remove('show');
                    console.error('Error:', error);
                    alert('Network error. Please check your connection and try again.');
                });
            });

            // Preview button
            const previewBtn = document.getElementById('preview-btn');
            previewBtn.addEventListener('click', function() {
                window.open('../index.html', '_blank');
            });

            // Initialize skills editor
            initializeSkillsEditor();
            initializeProjectsEditor();
        });

        function initializeSkillsEditor() {
            const skillsList = document.getElementById('skills-list');
            const skills = [
                { name: 'HTML5', icon: 'fab fa-html5', level: 90 },
                { name: 'CSS3', icon: 'fab fa-css3-alt', level: 85 },
                { name: 'JavaScript', icon: 'fab fa-js', level: 80 },
                { name: 'React', icon: 'fab fa-react', level: 75 },
                { name: 'Bootstrap', icon: 'fab fa-bootstrap', level: 85 },
                { name: 'Git', icon: 'fab fa-git-alt', level: 70 }
            ];

            skills.forEach((skill, index) => {
                const skillElement = createSkillEditor(skill, index);
                skillsList.appendChild(skillElement);
            });

            // Add skill button
            document.getElementById('add-skill-btn').addEventListener('click', function() {
                const newSkill = { name: '', icon: 'fas fa-code', level: 50 };
                const skillElement = createSkillEditor(newSkill, skills.length);
                skillsList.appendChild(skillElement);
            });
        }

        function createSkillEditor(skill, index) {
            const div = document.createElement('div');
            div.className = 'form-group';
            div.style.background = 'rgba(36, 40, 59, 0.5)';
            div.style.padding = '15px';
            div.style.borderRadius = '8px';
            div.style.marginBottom = '15px';
            div.style.border = '1px solid rgba(125, 207, 255, 0.2)';

            div.innerHTML = `
                <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 10px;">
                    <label style="margin: 0; color: #7dcfff;">Skill ${index + 1}</label>
                    <button type="button" onclick="this.parentElement.parentElement.remove()" style="background: rgba(255, 92, 87, 0.2); border: 1px solid rgba(255, 92, 87, 0.5); color: #ff5c57; padding: 4px 8px; border-radius: 4px; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; align-items: end;">
                    <div>
                        <label style="font-size: 0.8rem; color: #a9b1d6;">Skill Name</label>
                        <input type="text" class="form-control" value="${skill.name}" placeholder="e.g., JavaScript" style="margin-bottom: 0;">
                    </div>
                    <div>
                        <label style="font-size: 0.8rem; color: #a9b1d6;">Icon Class</label>
                        <input type="text" class="form-control" value="${skill.icon}" placeholder="e.g., fab fa-js" style="margin-bottom: 0;">
                    </div>
                    <div style="width: 80px;">
                        <label style="font-size: 0.8rem; color: #a9b1d6;">Level %</label>
                        <input type="number" class="form-control" value="${skill.level}" min="0" max="100" style="margin-bottom: 0;">
                    </div>
                </div>
            `;

            return div;
        }

        function initializeProjectsEditor() {
            const projectsList = document.getElementById('projects-list');
            const projects = [
                {
                    title: 'E-Commerce Website',
                    description: 'A modern e-commerce website with shopping cart features, payment system, and admin dashboard.',
                    icon: 'fas fa-shopping-cart',
                    technologies: ['HTML', 'CSS', 'JavaScript', 'React']
                },
                {
                    title: 'Blog Platform',
                    description: 'A blog platform with CRUD features, comment system, and admin panel for content management.',
                    icon: 'fas fa-blog',
                    technologies: ['HTML', 'CSS', 'JavaScript', 'Node.js']
                },
                {
                    title: 'Calculator App',
                    description: 'An interactive calculator application with modern design and comprehensive mathematical computation features.',
                    icon: 'fas fa-calculator',
                    technologies: ['HTML', 'CSS', 'JavaScript']
                }
            ];

            projects.forEach((project, index) => {
                const projectElement = createProjectEditor(project, index);
                projectsList.appendChild(projectElement);
            });

            // Add project button
            document.getElementById('add-project-btn').addEventListener('click', function() {
                const newProject = {
                    title: '',
                    description: '',
                    icon: 'fas fa-project-diagram',
                    technologies: []
                };
                const projectElement = createProjectEditor(newProject, projects.length);
                projectsList.appendChild(projectElement);
            });
        }

        function createProjectEditor(project, index) {
            const div = document.createElement('div');
            div.className = 'form-group';
            div.style.background = 'rgba(36, 40, 59, 0.5)';
            div.style.padding = '20px';
            div.style.borderRadius = '8px';
            div.style.marginBottom = '20px';
            div.style.border = '1px solid rgba(125, 207, 255, 0.2)';

            div.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <label style="margin: 0; color: #7dcfff; font-size: 1rem;">Project ${index + 1}</label>
                    <button type="button" onclick="this.parentElement.parentElement.remove()" style="background: rgba(255, 92, 87, 0.2); border: 1px solid rgba(255, 92, 87, 0.5); color: #ff5c57; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <div style="display: grid; grid-template-columns: 1fr auto; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="font-size: 0.8rem; color: #a9b1d6;">Project Title</label>
                        <input type="text" class="form-control" value="${project.title}" placeholder="Enter project title">
                    </div>
                    <div style="width: 150px;">
                        <label style="font-size: 0.8rem; color: #a9b1d6;">Icon Class</label>
                        <input type="text" class="form-control" value="${project.icon}" placeholder="fas fa-code">
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 0.8rem; color: #a9b1d6;">Description</label>
                    <textarea class="form-control" rows="3" placeholder="Describe your project...">${project.description}</textarea>
                </div>
                <div>
                    <label style="font-size: 0.8rem; color: #a9b1d6;">Technologies (comma-separated)</label>
                    <input type="text" class="form-control" value="${project.technologies.join(', ')}" placeholder="HTML, CSS, JavaScript, React">
                </div>
            `;

            return div;
        }

        // Data collection functions
        function collectSectionData(section) {
            switch (section) {
                case 'hero':
                    return collectHeroData();
                case 'about':
                    return collectAboutData();
                case 'contact':
                    return collectContactData();
                case 'skills':
                    return collectSkillsData();
                case 'projects':
                    return collectProjectsData();
                default:
                    return null;
            }
        }

        function collectHeroData() {
            return {
                name: document.getElementById('hero-name').value.trim(),
                role: document.getElementById('hero-role').value.trim(),
                department: document.getElementById('hero-department').value.trim(),
                employeeId: document.getElementById('hero-employee-id').value.trim(),
                university: document.getElementById('hero-university').value.trim(),
                graduationYear: document.getElementById('hero-graduation-year').value.trim()
            };
        }

        function collectAboutData() {
            return {
                description: document.getElementById('about-description').value.trim(),
                passion: document.getElementById('about-passion').value.trim(),
                goal: document.getElementById('about-goal').value.trim()
            };
        }

        function collectContactData() {
            return {
                email: document.getElementById('contact-email').value.trim(),
                phone: document.getElementById('contact-phone').value.trim(),
                github: document.getElementById('contact-github').value.trim(),
                instagram: document.getElementById('contact-instagram').value.trim()
            };
        }

        function collectSkillsData() {
            const skillElements = document.querySelectorAll('#skills-list .form-group');
            const skills = [];

            skillElements.forEach(element => {
                const inputs = element.querySelectorAll('input');
                if (inputs.length >= 3) {
                    const name = inputs[0].value.trim();
                    const icon = inputs[1].value.trim();
                    const level = parseInt(inputs[2].value) || 0;

                    if (name && icon) {
                        skills.push({ name, icon, level });
                    }
                }
            });

            return { skills };
        }

        function collectProjectsData() {
            const projectElements = document.querySelectorAll('#projects-list .form-group');
            const projects = [];

            projectElements.forEach(element => {
                const titleInput = element.querySelector('input[placeholder*="title"]');
                const iconInput = element.querySelector('input[placeholder*="fas fa-code"]');
                const descriptionTextarea = element.querySelector('textarea');
                const techInput = element.querySelector('input[placeholder*="comma-separated"]');

                if (titleInput && iconInput && descriptionTextarea && techInput) {
                    const title = titleInput.value.trim();
                    const icon = iconInput.value.trim();
                    const description = descriptionTextarea.value.trim();
                    const technologies = techInput.value.split(',').map(t => t.trim()).filter(t => t);

                    if (title && description) {
                        projects.push({ title, icon, description, technologies });
                    }
                }
            });

            return { projects };
        }
    </script>
</body>
</html>
