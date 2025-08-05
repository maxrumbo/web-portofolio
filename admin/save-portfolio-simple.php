<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $hero_name = $_POST['hero_name'] ?? '';
    $hero_role = $_POST['hero_role'] ?? '';
    $hero_university = $_POST['hero_university'] ?? '';
    $hero_id = $_POST['hero_id'] ?? '';
    $hero_department = $_POST['hero_department'] ?? '';
    $hero_year = $_POST['hero_year'] ?? '';
    
    $about_description = $_POST['about_description'] ?? '';
    $about_passion = $_POST['about_passion'] ?? '';
    $about_goal = $_POST['about_goal'] ?? '';
    
    $contact_email = $_POST['contact_email'] ?? '';
    $contact_whatsapp = $_POST['contact_whatsapp'] ?? '';
    $contact_github = $_POST['contact_github'] ?? '';
    $contact_instagram = $_POST['contact_instagram'] ?? '';
    
    // Read current index.html
    $indexPath = '../index.html';
    if (file_exists($indexPath)) {
        $html = file_get_contents($indexPath);
        
        // Update Hero Section
        $html = preg_replace(
            '/(<span class="name-layer">)[^<]+(.*?<\/span>\s*<span class="name-layer">)[^<]+(.*?<\/span>)/s',
            '$1' . explode(' ', $hero_name)[0] . '$2' . (explode(' ', $hero_name)[1] ?? '') . '$3',
            $html
        );
        
        $html = preg_replace(
            '/(<div class="employee-id">ID: )[^<]+(<\/div>)/s',
            '$1' . $hero_id . '$2',
            $html
        );
        
        $html = preg_replace(
            '/(<div class="department">)[^<]+(<\/div>)/s',
            '$1' . $hero_department . '$2',
            $html
        );
        
        // Update About Section
        $html = preg_replace(
            '/(<span class="string">"Information Systems Student"<\/span>)/s',
            '<span class="string">"' . $hero_role . '"</span>',
            $html
        );
        
        $html = preg_replace(
            '/(<span class="string">"Institut Teknologi Del"<\/span>)/s',
            '<span class="string">"' . $hero_university . '"</span>',
            $html
        );
        
        $html = preg_replace(
            '/(<span class="number">)2024(<\/span>)/s',
            '$1' . $hero_year . '$2',
            $html
        );
        
        // Update Contact Section
        $html = preg_replace(
            '/(href="mailto:)[^"]+(">)/s',
            '$1' . $contact_email . '$2',
            $html
        );
        
        $html = preg_replace(
            '/(href="https:\/\/wa\.me\/)[^"]+(">)/s',
            '$1' . $contact_whatsapp . '$2',
            $html
        );
        
        $html = preg_replace(
            '/(href="https:\/\/github\.com\/)[^"]+(">)/s',
            '$1' . $contact_github . '$2',
            $html
        );
        
        $html = preg_replace(
            '/(href="https:\/\/instagram\.com\/)[^"]+(">)/s',
            '$1' . $contact_instagram . '$2',
            $html
        );
        
        // Save updated HTML
        if (file_put_contents($indexPath, $html)) {
            // Log the change
            $logEntry = date('Y-m-d H:i:s') . " - Portfolio updated by admin\n";
            file_put_contents('../logs/edit_log.txt', $logEntry, FILE_APPEND);
            
            // Redirect with success message
            header('Location: edit-portfolio-simple.php?success=1');
            exit();
        } else {
            $error = "Failed to save changes!";
        }
    } else {
        $error = "Portfolio file not found!";
    }
}

// If there was an error, redirect back with error
if (isset($error)) {
    header('Location: edit-portfolio-simple.php?error=' . urlencode($error));
    exit();
}
?>
