<?php
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Style dashboard dipindahkan ke admin-style.css -->
</head>
<body class="dashboard-admin">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="admin-profile">
                <div class="admin-avatar">
                    <img src="../assets/images/profile 2.jpg" alt="Admin Profile">
                </div>
                <div class="admin-info">
                    <span class="admin-name">Maxwell Rumahorbo</span>
                    <span class="admin-role">Administrator</span>
                </div>
            </div>
        <a href="/web-portofolio/index.html" class="view-portfolio-btn" target="_blank"><i class="fas fa-eye"></i> View Portfolio</a>
        </div>
        <div class="admin-menu">
            <a href="edit_hero.php"><i class="fas fa-user-astronaut"></i> Edit Hero</a>
            <a href="edit_about.php"><i class="fas fa-user"></i> Edit About</a>
            <a href="edit_skills.php"><i class="fas fa-code"></i> Edit Skills</a>
            <a href="edit_projects.php"><i class="fas fa-briefcase"></i> Edit Projects</a>
            <a href="edit_experience.php"><i class="fas fa-history"></i> Edit Experience</a>
            <a href="edit_certificates.php"><i class="fas fa-certificate"></i> Edit Certificates</a>
            <a href="edit_contact.php"><i class="fas fa-envelope"></i> Edit Contact</a>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="section-content">
            <p>Selamat datang di <b>Dashboard Admin</b>! Silakan pilih menu di atas untuk mengelola konten portofolio Anda.<br>Gunakan tombol <b>View Portfolio</b> untuk melihat hasil perubahan secara langsung.</p>
        </div>
    </div>
