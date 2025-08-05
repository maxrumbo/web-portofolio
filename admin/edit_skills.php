<?php
session_start();
require_once 'check_login.php';
require_once 'config.php';

// Tambah skill
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $icon = $_POST['icon'];
    $level = $_POST['level'];
    $stmt = $conn->prepare('INSERT INTO skills (name, icon, level) VALUES (?, ?, ?)');
    $stmt->bind_param('ssi', $name, $icon, $level);
    $stmt->execute();
}
// Hapus skill
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query('DELETE FROM skills WHERE id='.$id);
}
// Ambil data skills
$skills = $conn->query('SELECT * FROM skills ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Skills - Admin</title>
    <link rel="stylesheet" href="admin-style.css">
    <style>body {background: #232946; color: #fff; font-family: Arial, sans-serif;} .form-container {max-width: 600px; margin: 40px auto; background: #2a2d3e; border-radius: 12px; padding: 32px 28px; box-shadow: 0 4px 24px #0002;} .form-container h2 {margin-bottom: 24px; text-align: center;} .form-group {margin-bottom: 18px;} .form-group label {display: block; margin-bottom: 6px;} .form-group input {width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #232946; color: #fff;} .btn {padding: 10px 18px; background: #9ece6a; color: #232946; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;} table {width: 100%; margin-top: 24px; border-collapse: collapse;} th, td {padding: 8px 10px; border-bottom: 1px solid #444;} th {background: #232946;} .delete-btn {background: #ff5c57; color: #fff; border: none; border-radius: 4px; padding: 6px 12px; cursor: pointer;} </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Skills</h2>
        <form method="post" style="margin-bottom:24px;">
            <div class="form-group">
                <label>Nama Skill</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Icon (FontAwesome class)</label>
                <input type="text" name="icon" placeholder="misal: fab fa-html5" required>
            </div>
            <div class="form-group">
                <label>Level (%)</label>
                <input type="number" name="level" min="0" max="100" required>
            </div>
            <button type="submit" name="add" class="btn">Tambah Skill</button>
        </form>
        <table>
            <tr><th>Nama</th><th>Icon</th><th>Level</th><th>Aksi</th></tr>
            <?php while($row = $skills->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><i class="<?= htmlspecialchars($row['icon']) ?>"></i> <?= htmlspecialchars($row['icon']) ?></td>
                <td><?= htmlspecialchars($row['level']) ?>%</td>
                <td><a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Hapus skill ini?')">Hapus</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
