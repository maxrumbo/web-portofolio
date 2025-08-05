<?php
session_start();
require_once 'check_login.php';
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Portfolio</title>
    <link rel="stylesheet" href="admin-style.css">
    <style>
        body {background: #232946; color: #fff; font-family: Arial, sans-serif;}
        .dashboard-container {max-width: 900px; margin: 40px auto; background: #2a2d3e; border-radius: 12px; padding: 32px 28px; box-shadow: 0 4px 24px #0002;}
        .dashboard-container h2 {margin-bottom: 24px; text-align: center;}
        .admin-menu {display: flex; flex-wrap: wrap; gap: 16px; justify-content: center; margin-bottom: 32px;}
        .admin-menu a {background: #9ece6a; color: #232946; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: background 0.2s;}
        .admin-menu a:hover {background: #73daca;}
        .logout-btn {background: #ff5c57 !important; color: #fff !important;}
        .section-content {margin-top: 32px;}
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Dashboard Admin</h2>
        <div class="admin-menu">
            <a href="edit_hero.php">Edit Hero</a>
            <a href="edit_about.php">Edit About</a>
            <a href="edit_skills.php">Edit Skills</a>
            <a href="edit_projects.php">Edit Projects</a>
            <a href="edit_experience.php">Edit Experience</a>
            <a href="edit_certificates.php">Edit Certificates</a>
            <a href="edit_contact.php">Edit Contact</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        <div class="section-content">
            <p>Silakan pilih menu di atas untuk mengedit konten portofolio Anda.</p>
        </div>
    </div>
</body>
</html>
