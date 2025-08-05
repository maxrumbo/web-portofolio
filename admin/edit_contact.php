<?php
session_start();
require_once 'check_login.php';
require_once 'config.php';

// Ambil data kontak
$query = $conn->query('SELECT * FROM contact LIMIT 1');
$contact = $query->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email'];
    $github = $_POST['github'];
    $stackoverflow = $_POST['stackoverflow'];
    $codepen = $_POST['codepen'];
    $instagram = $_POST['instagram'];
    $stmt = $conn->prepare('UPDATE contact SET whatsapp=?, email=?, github=?, stackoverflow=?, codepen=?, instagram=? WHERE id=?');
    $stmt->bind_param('ssssssi', $whatsapp, $email, $github, $stackoverflow, $codepen, $instagram, $contact['id']);
    $stmt->execute();
    header('Location: edit_contact.php?success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact - Admin</title>
    <link rel="stylesheet" href="admin-style.css">
    <style>body {background: #232946; color: #fff; font-family: Arial, sans-serif;} .form-container {max-width: 500px; margin: 40px auto; background: #2a2d3e; border-radius: 12px; padding: 32px 28px; box-shadow: 0 4px 24px #0002;} .form-container h2 {margin-bottom: 24px; text-align: center;} .form-group {margin-bottom: 18px;} .form-group label {display: block; margin-bottom: 6px;} .form-group input {width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #232946; color: #fff;} .btn {width: 100%; padding: 12px; background: #9ece6a; color: #232946; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;} .success {color: #9ece6a; text-align: center; margin-bottom: 12px;} </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Kontak</h2>
        <?php if (isset($_GET['success'])) echo '<div class="success">Data berhasil disimpan!</div>'; ?>
        <form method="post">
            <div class="form-group">
                <label>WhatsApp</label>
                <input type="text" name="whatsapp" value="<?= htmlspecialchars($contact['whatsapp']) ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($contact['email']) ?>">
            </div>
            <div class="form-group">
                <label>GitHub</label>
                <input type="text" name="github" value="<?= htmlspecialchars($contact['github']) ?>">
            </div>
            <div class="form-group">
                <label>Stack Overflow</label>
                <input type="text" name="stackoverflow" value="<?= htmlspecialchars($contact['stackoverflow']) ?>">
            </div>
            <div class="form-group">
                <label>Codepen</label>
                <input type="text" name="codepen" value="<?= htmlspecialchars($contact['codepen']) ?>">
            </div>
            <div class="form-group">
                <label>Instagram</label>
                <input type="text" name="instagram" value="<?= htmlspecialchars($contact['instagram']) ?>">
            </div>
            <button type="submit" class="btn">Simpan</button>
        </form>
    </div>
</body>
</html>
