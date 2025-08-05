<?php
// Script ini untuk mengecek apakah user sudah login
// Contoh sederhana:
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>
