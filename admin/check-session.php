<?php
session_start();

// Set content type to JSON
header('Content-Type: application/json');

// Check if admin is logged in
$isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Return JSON response
echo json_encode([
    'isAdmin' => $isAdmin,
    'username' => $isAdmin ? ($_SESSION['admin_username'] ?? 'admin') : null
]);
?>
