<?php
session_start();
require_once 'check_login.php';
require_once 'config.php';

// Ambil data about
$query = $conn->query('SELECT * FROM about LIMIT 1');
$about = $query->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desc = $_POST['description'];
    $stmt = $conn->prepare('UPDATE about SET description=? WHERE id=?');
    $stmt->bind_param('si', $desc, $about['id']);
    $stmt->execute();
    header('Location: edit_about.php?success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About - Admin</title>
    <link rel="stylesheet" href="admin-style.css">
    <style>body {background: #232946; color: #fff; font-family: Arial, sans-serif;} .form-container {max-width: 500px; margin: 40px auto; background: #2a2d3e; border-radius: 12px; padding: 32px 28px; box-shadow: 0 4px 24px #0002;} .form-container h2 {margin-bottom: 24px; text-align: center;} .form-group {margin-bottom: 18px;} .form-group label {display: block; margin-bottom: 6px;} .form-group textarea {width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #232946; color: #fff; min-height: 120px;} .btn {width: 100%; padding: 12px; background: #9ece6a; color: #232946; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;} .success {color: #9ece6a; text-align: center; margin-bottom: 12px;} </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit About</h2>
        <?php if (isset($_GET['success'])) echo '<div class="success">Data berhasil disimpan!</div>'; ?>
        <form method="post">
            <div class="form-group">
                <label>Deskripsi Tentang Saya</label>
                <textarea name="description" required><?= htmlspecialchars($about['description']) ?></textarea>
            </div>
            <button type="submit" class="btn">Simpan</button>
        </form>
    </div>
</body>
</html>
