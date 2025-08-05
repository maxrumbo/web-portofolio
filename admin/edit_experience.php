<?php
session_start();
require_once 'check_login.php';
require_once 'config.php';

// Tambah pengalaman
if (isset($_POST['add'])) {
    $year = $_POST['year'];
    $title = $_POST['title'];
    $company = $_POST['company'];
    $desc = $_POST['description'];
    $skills = $_POST['skills'];
    $stmt = $conn->prepare('INSERT INTO experience (year, title, company, description, skills) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $year, $title, $company, $desc, $skills);
    $stmt->execute();
}
// Hapus pengalaman
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query('DELETE FROM experience WHERE id='.$id);
}
// Ambil data experience
$exp = $conn->query('SELECT * FROM experience ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Experience - Admin</title>
    <link rel="stylesheet" href="admin-style.css">
    <style>body {background: #232946; color: #fff; font-family: Arial, sans-serif;} .form-container {max-width: 700px; margin: 40px auto; background: #2a2d3e; border-radius: 12px; padding: 32px 28px; box-shadow: 0 4px 24px #0002;} .form-container h2 {margin-bottom: 24px; text-align: center;} .form-group {margin-bottom: 18px;} .form-group label {display: block; margin-bottom: 6px;} .form-group input, .form-group textarea {width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #232946; color: #fff;} .form-group textarea {min-height: 60px;} .btn {padding: 10px 18px; background: #9ece6a; color: #232946; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;} table {width: 100%; margin-top: 24px; border-collapse: collapse;} th, td {padding: 8px 10px; border-bottom: 1px solid #444;} th {background: #232946;} .delete-btn {background: #ff5c57; color: #fff; border: none; border-radius: 4px; padding: 6px 12px; cursor: pointer;} </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Experience</h2>
        <form method="post" style="margin-bottom:24px;">
            <div class="form-group">
                <label>Tahun</label>
                <input type="text" name="year" required>
            </div>
            <div class="form-group">
                <label>Posisi/Jabatan</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label>Perusahaan/Instansi</label>
                <input type="text" name="company" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label>Skill (pisahkan dengan koma)</label>
                <input type="text" name="skills" required>
            </div>
            <button type="submit" name="add" class="btn">Tambah Pengalaman</button>
        </form>
        <table>
            <tr><th>Tahun</th><th>Posisi</th><th>Perusahaan</th><th>Skill</th><th>Aksi</th></tr>
            <?php while($row = $exp->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['year']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['company']) ?></td>
                <td><?= htmlspecialchars($row['skills']) ?></td>
                <td><a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Hapus pengalaman ini?')">Hapus</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
