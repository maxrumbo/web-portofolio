<?php
session_start();
header('Content-Type: application/json');

// Allow requests without session check for testing
// Uncomment the lines below to enable session checking
/*
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}
*/

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Get data from either JSON or FormData
$section = null;
$data = [];

// Try to get from FormData first
if (isset($_POST['section'])) {
    $section = $_POST['section'];
    $data = $_POST;
} else {
    // Fallback to JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input && isset($input['section']) && isset($input['data'])) {
        $section = $input['section'];
        $data = $input['data'];
    }
}

if (!$section) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing section parameter']);
    exit();
}

try {
    // Create backup of current index.html
    $indexPath = '../index.html';
    if (!file_exists($indexPath)) {
        throw new Exception('Portfolio file not found');
    }

    $htmlContent = file_get_contents($indexPath);
    if ($htmlContent === false) {
        throw new Exception('Failed to read portfolio file');
    }

    // Create backup
    $backupPath = '../backups/backup_' . date('Y-m-d_H-i-s') . '.html';
    $backupDir = dirname($backupPath);
    if (!file_exists($backupDir)) {
        mkdir($backupDir, 0755, true);
    }
    file_put_contents($backupPath, $htmlContent);

    // Process based on section
    switch ($section) {
        case 'hero':
            $htmlContent = updateHeroSection($htmlContent, $data);
            break;
        case 'about':
            $htmlContent = updateAboutSection($htmlContent, $data);
            break;
        case 'contact':
            $htmlContent = updateContactSection($htmlContent, $data);
            break;
        case 'skills':
            $htmlContent = updateSkillsSection($htmlContent, $data);
            break;
        case 'projects':
            $htmlContent = updateProjectsSection($htmlContent, $data);
            break;
        case 'add_skill':
            $htmlContent = addNewSkill($htmlContent, $data);
            break;
        case 'add_project':
            $htmlContent = addNewProject($htmlContent, $data);
            break;
        default:
            throw new Exception('Unknown section: ' . $section);
    }

    // Create backup before saving
    $backupPath = '../backups/index_' . date('Y-m-d_H-i-s') . '.html';
    $backupDir = dirname($backupPath);
    
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0755, true);
    }
    
    copy($indexPath, $backupPath);

    // Save the updated content
    if (file_put_contents($indexPath, $htmlContent) === false) {
        throw new Exception('Failed to save portfolio file');
    }

    // Log the change
    $logEntry = date('Y-m-d H:i:s') . " - Admin (" . $_SESSION['admin_username'] . ") updated " . $section . " section\n";
    file_put_contents('../logs/edit_log.txt', $logEntry, FILE_APPEND | LOCK_EX);

    echo json_encode([
        'success' => true, 
        'message' => 'Portfolio updated successfully',
        'section' => $section,
        'timestamp' => date('Y-m-d H:i:s')
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

function updateHeroSection($html, $data) {
    // Update name (support both old and new field names)
    $name = $data['name'] ?? null;
    if ($name) {
        $nameParts = explode(' ', $name, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';
        
        // Update first name layer
        $html = preg_replace(
            '/(<span class="name-layer">)[^<]+(</span>)/i',
            '${1}' . htmlspecialchars($firstName) . '${2}',
            $html,
            1
        );
        
        // Update second name layer if exists
        if (!empty($lastName)) {
            $pattern = '/(<span class="name-layer">)[^<]+(</span>)/i';
            if (preg_match_all($pattern, $html, $matches, PREG_OFFSET_CAPTURE)) {
                if (count($matches[0]) > 1) {
                    $secondMatch = $matches[0][1];
                    $beforeSecond = substr($html, 0, $secondMatch[1]);
                    $afterSecond = substr($html, $secondMatch[1] + strlen($secondMatch[0]));
                    $replacement = '${1}' . htmlspecialchars($lastName) . '${2}';
                    $newSecond = preg_replace($pattern, $replacement, $secondMatch[0]);
                    $html = $beforeSecond . $newSecond . $afterSecond;
                }
            }
        }
    }

    // Update role
    $role = $data['role'] ?? null;
    if ($role) {
        $html = preg_replace(
            '/(<span class="typing-text"[^>]*>)[^<]+(</span>)/i',
            '${1}' . htmlspecialchars($role) . '${2}',
            $html
        );
    }

    // Update department
    $department = $data['department'] ?? null;
    if ($department) {
        $html = preg_replace(
            '/(<div class="department">)[^<]+(</div>)/i',
            '${1}' . htmlspecialchars($department) . '${2}',
            $html
        );
    }

    // Update employee ID
    $employeeId = $data['employee_id'] ?? $data['employeeId'] ?? null;
    if ($employeeId) {
        $html = preg_replace(
            '/(<div class="employee-id">ID: )[^<]+(</div>)/i',
            '${1}' . htmlspecialchars($employeeId) . '${2}',
            $html
        );
    }

    // Update university
    $university = $data['university'] ?? null;
    if ($university) {
        $html = preg_replace(
            '/(<span class="keyword">this<\/span><span class="punctuation">\.<\/span><span class="property">university<\/span>\s*<span class="operator">=<\/span>\s*<span class="string">")[^"]+(")<\/span>/i',
            '${1}' . htmlspecialchars($university) . '${2}</span>',
            $html
        );
    }

    // Update graduation year
    $graduationYear = $data['graduate_year'] ?? $data['graduationYear'] ?? null;
    if ($graduationYear) {
        $html = preg_replace(
            '/(<span class="keyword">this<\/span><span class="punctuation">\.<\/span><span class="property">graduateYear<\/span>\s*<span class="operator">=<\/span>\s*<span class="number">)[^<]+(<\/span>)/i',
            '${1}' . htmlspecialchars($graduationYear) . '${2}',
            $html
        );
    }

    return $html;
}

function updateAboutSection($html, $data) {
    // Update about description
    $aboutDesc = $data['about_description'] ?? null;
    if ($aboutDesc) {
        // This would be more complex to implement as it involves updating multiple code lines
        // For now, just log that this section needs implementation
        error_log("About description update requested: " . $aboutDesc);
    }

    // Update passion
    $passion = $data['passion'] ?? null;
    if ($passion) {
        $html = preg_replace(
            '/(<span class="keyword">return<\/span>\s*<span class="string">")[^"]+("\s*<span class="operator">\+<\/span>)/i',
            '${1}' . htmlspecialchars($passion) . '${2}',
            $html
        );
    }

    // Update goal
    $goal = $data['goal'] ?? null;
    if ($goal) {
        $html = preg_replace(
            '/(<span class="method">getGoal<\/span>.*?<span class="keyword">return<\/span>\s*<span class="string">")[^"]+(")/s',
            '${1}' . htmlspecialchars($goal) . '${2}',
            $html
        );
    }

    return $html;
}

function updateContactSection($html, $data) {
    // Update email
    $email = $data['email'] ?? null;
    if ($email) {
        $html = preg_replace(
            '/(href="mailto:)[^"]+(")/i',
            '${1}' . htmlspecialchars($email) . '${2}',
            $html
        );
    }

    // Update phone/WhatsApp
    $phone = $data['phone'] ?? null;
    if ($phone) {
        $html = preg_replace(
            '/(href="https:\/\/wa\.me\/)[^"]+(")/i',
            '${1}' . htmlspecialchars($phone) . '${2}',
            $html
        );
    }

    // Update GitHub
    $github = $data['github'] ?? null;
    if ($github) {
        $html = preg_replace(
            '/(href="https:\/\/github\.com\/)[^"]+(")/i',
            '${1}' . htmlspecialchars($github) . '${2}',
            $html
        );
    }

    // Update Instagram
    $instagram = $data['instagram'] ?? null;
    if ($instagram) {
        $html = preg_replace(
            '/(href="https:\/\/instagram\.com\/)[^"]+(")/i',
            '${1}' . htmlspecialchars($instagram) . '${2}',
            $html
        );
    }

    return $html;
}

    // Update WhatsApp
    if (isset($data['phone'])) {
        $html = preg_replace(
            '/(href="https:\/\/wa\.me\/)[^"]+(")/i',
            '${1}' . htmlspecialchars($data['phone']) . '${2}',
            $html
        );
    }

    // Update GitHub
    if (isset($data['github'])) {
        $html = preg_replace(
            '/(href="https:\/\/github\.com\/)[^"]+(")/i',
            '${1}' . htmlspecialchars($data['github']) . '${2}',
            $html
        );
    }

    // Update Instagram
    if (isset($data['instagram'])) {
        $html = preg_replace(
            '/(href="https:\/\/instagram\.com\/)[^"]+(")/i',
            '${1}' . htmlspecialchars($data['instagram']) . '${2}',
            $html
        );
    }

    return $html;
}

function updateSkillsSection($html, $data) {
    if (!isset($data['skills']) || !is_array($data['skills'])) {
        return $html;
    }

    $skillsHtml = '';
    foreach ($data['skills'] as $skill) {
        if (empty($skill['name'])) continue;
        
        $skillsHtml .= '
                <div class="skill-item stagger-item">
                    <div class="skill-icon">
                        <i class="' . htmlspecialchars($skill['icon']) . '"></i>
                    </div>
                    <h3>' . htmlspecialchars($skill['name']) . '</h3>
                    <div class="progress-bar">
                        <div class="progress" data-width="' . htmlspecialchars($skill['level']) . '%"></div>
                    </div>
                </div>';
    }

    // Replace the skills grid content
    $pattern = '/(<div class="skills-grid">)(.*?)(<\/div>\s*<\/div>\s*<\/section>)/s';
    $replacement = '${1}' . $skillsHtml . '\n            ${3}';
    
    return preg_replace($pattern, $replacement, $html);
}

function updateProjectsSection($html, $data) {
    if (!isset($data['projects']) || !is_array($data['projects'])) {
        return $html;
    }

    $projectsHtml = '';
    foreach ($data['projects'] as $project) {
        if (empty($project['title'])) continue;
        
        $techTags = '';
        if (!empty($project['technologies'])) {
            $techs = is_array($project['technologies']) ? 
                $project['technologies'] : 
                explode(',', $project['technologies']);
            
            foreach ($techs as $tech) {
                $tech = trim($tech);
                if (!empty($tech)) {
                    $techTags .= '<span>' . htmlspecialchars($tech) . '</span>';
                }
            }
        }

        $projectsHtml .= '
                <div class="project-card stagger-item">
                    <div class="project-image">
                        <i class="' . htmlspecialchars($project['icon']) . '"></i>
                    </div>
                    <div class="project-content">
                        <h3>' . htmlspecialchars($project['title']) . '</h3>
                        <p>' . htmlspecialchars($project['description']) . '</p>
                        <div class="project-tech">
                            ' . $techTags . '
                        </div>
                        <div class="project-links">
                            <a href="#" class="btn btn-sm">Live Demo</a>
                            <a href="#" class="btn btn-sm btn-outline">GitHub</a>
                        </div>
                    </div>
                </div>';
    }

    // Replace the projects grid content
    $pattern = '/(<div class="projects-grid">)(.*?)(<\/div>\s*<\/div>\s*<\/section>)/s';
    $replacement = '${1}' . $projectsHtml . '\n            ${3}';
    
    return preg_replace($pattern, $replacement, $html);
}

function addNewSkill($html, $data) {
    if (!isset($data['skill_name']) || !isset($data['skill_icon']) || !isset($data['skill_level'])) {
        throw new Exception('Missing required skill data');
    }
    
    $skillName = htmlspecialchars($data['skill_name']);
    $skillIcon = htmlspecialchars($data['skill_icon']);
    $skillLevel = intval($data['skill_level']);
    
    // Create new skill HTML
    $newSkillHtml = '
                <div class="skill-item stagger-item">
                    <div class="skill-icon">
                        <i class="' . $skillIcon . '"></i>
                    </div>
                    <h3>' . $skillName . '</h3>
                    <div class="progress-bar">
                        <div class="progress" data-width="' . $skillLevel . '%"></div>
                    </div>
                </div>';
    
    // Find the skills grid and add the new skill before the closing </div>
    $pattern = '/(<div class="skills-grid">.*?)(                <\/div>\s*<\/div>\s*<\/section>)/s';
    $replacement = '${1}' . $newSkillHtml . '\n${2}';
    
    return preg_replace($pattern, $replacement, $html);
}

function addNewProject($html, $data) {
    if (!isset($data['project_title']) || !isset($data['project_description'])) {
        throw new Exception('Missing required project data');
    }
    
    $title = htmlspecialchars($data['project_title']);
    $description = htmlspecialchars($data['project_description']);
    $icon = isset($data['project_icon']) ? htmlspecialchars($data['project_icon']) : 'fas fa-code';
    $technologies = isset($data['project_technologies']) ? $data['project_technologies'] : '';
    
    // Process technologies
    $techTags = '';
    if (!empty($technologies)) {
        $techs = explode(',', $technologies);
        foreach ($techs as $tech) {
            $tech = trim($tech);
            if (!empty($tech)) {
                $techTags .= '<span>' . htmlspecialchars($tech) . '</span>';
            }
        }
    }
    
    // Create new project HTML
    $newProjectHtml = '
                <div class="project-card stagger-item">
                    <div class="project-image">
                        <i class="' . $icon . '"></i>
                    </div>
                    <div class="project-content">
                        <h3>' . $title . '</h3>
                        <p>' . $description . '</p>
                        <div class="project-tech">
                            ' . $techTags . '
                        </div>
                        <div class="project-links">
                            <a href="#" class="btn btn-sm">Live Demo</a>
                            <a href="#" class="btn btn-sm btn-outline">GitHub</a>
                        </div>
                    </div>
                </div>';
    
    // Find the projects grid and add the new project before the closing </div>
    $pattern = '/(<div class="projects-grid">.*?)(            <\/div>\s*<\/div>\s*<\/section>)/s';
    $replacement = '${1}' . $newProjectHtml . '\n${2}';
    
    return preg_replace($pattern, $replacement, $html);
}
?>
