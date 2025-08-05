<?php
session_start();
require_once 'check_login.php';
require_once 'config.php';

// Tambah sertifikat
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $issuer = $_POST['issuer'];
    $desc = $_POST['description'];
    $date = $_POST['date'];
    $badge = $_POST['badge'];
    $icon = $_POST['icon'];
    $stmt = $conn->prepare('INSERT INTO certificates (title, issuer, description, date, badge, icon) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $title, $issuer, $desc, $date, $badge, $icon);
    $stmt->execute();
}
// Hapus sertifikat
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query('DELETE FROM certificates WHERE id='.$id);
}
// Ambil data certificates
$certs = $conn->query('SELECT * FROM certificates ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Certificates - Admin</title>
    <link rel="stylesheet" href="admin-style.css">
    <style>body {background: #232946; color: #fff; font-family: Arial, sans-serif;} .form-container {max-width: 700px; margin: 40px auto; background: #2a2d3e; border-radius: 12px; padding: 32px 28px; box-shadow: 0 4px 24px #0002;} .form-container h2 {margin-bottom: 24px; text-align: center;} .form-group {margin-bottom: 18px;} .form-group label {display: block; margin-bottom: 6px;} .form-group input, .form-group textarea {width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #232946; color: #fff;} .form-group textarea {min-height: 60px;} .btn {padding: 10px 18px; background: #9ece6a; color: #232946; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;} table {width: 100%; margin-top: 24px; border-collapse: collapse;} th, td {padding: 8px 10px; border-bottom: 1px solid #444;} th {background: #232946;} .delete-btn {background: #ff5c57; color: #fff; border: none; border-radius: 4px; padding: 6px 12px; cursor: pointer;} </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Certificates</h2>
        <form method="post" style="margin-bottom:24px;">
            <div class="form-group">
                <label>Judul Sertifikat</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label>Penerbit</label>
                <input type="text" name="issuer" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" name="date" required>
            </div>
            <div class="form-group">
                <label>Lencana/Badge</label>
                <input type="text" name="badge">
            </div>
            <div class="form-group">
                <label>Icon (FontAwesome class)</label>
                <input type="text" name="icon" required>
            </div>
            <button type="submit" name="add" class="btn">Tambah Sertifikat</button>
        </form>
        <table>
            <tr><th>Judul</th><th>Penerbit</th><th>Tanggal</th><th>Icon</th><th>Aksi</th></tr>
            <?php while($row = $certs->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['issuer']) ?></td>
                <td><?= htmlspecialchars($row['date']) ?></td>
                <td><i class="<?= htmlspecialchars($row['icon']) ?>"></i> <?= htmlspecialchars($row['icon']) ?></td>
                <td><a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Hapus sertifikat ini?')">Hapus</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
