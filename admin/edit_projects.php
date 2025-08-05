<?php
session_start();
require_once 'check_login.php';
require_once 'config.php';

// Tambah project
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $tech = $_POST['tech'];
    $icon = $_POST['icon'];
    $image = '';
    $link_demo = $_POST['link_demo'];
    $link_github = $_POST['link_github'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'project_' . time() . '.' . $ext;
        $target = '../assets/images/' . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image = $filename;
        }
    }
    $stmt = $conn->prepare('INSERT INTO projects (title, description, tech, icon, image, link_demo, link_github) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('sssssss', $title, $desc, $tech, $icon, $image, $link_demo, $link_github);
    $stmt->execute();
}
// Hapus project
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query('DELETE FROM projects WHERE id='.$id);
}
// Ambil data projects
$projects = $conn->query('SELECT * FROM projects ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Projects - Admin</title>
    <link rel="stylesheet" href="admin-style.css">
    <style>body {background: #232946; color: #fff; font-family: Arial, sans-serif;} .form-container {max-width: 700px; margin: 40px auto; background: #2a2d3e; border-radius: 12px; padding: 32px 28px; box-shadow: 0 4px 24px #0002;} .form-container h2 {margin-bottom: 24px; text-align: center;} .form-group {margin-bottom: 18px;} .form-group label {display: block; margin-bottom: 6px;} .form-group input, .form-group textarea {width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #232946; color: #fff;} .form-group textarea {min-height: 60px;} .btn {padding: 10px 18px; background: #9ece6a; color: #232946; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;} table {width: 100%; margin-top: 24px; border-collapse: collapse;} th, td {padding: 8px 10px; border-bottom: 1px solid #444;} th {background: #232946;} .delete-btn {background: #ff5c57; color: #fff; border: none; border-radius: 4px; padding: 6px 12px; cursor: pointer;} img {max-width: 80px; border-radius: 6px;} </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Projects</h2>
        <form method="post" enctype="multipart/form-data" style="margin-bottom:24px;">
            <div class="form-group">
                <label>Judul Project</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label>Teknologi (pisahkan dengan koma)</label>
                <input type="text" name="tech" required>
            </div>
            <div class="form-group">
                <label>Icon (FontAwesome class)</label>
                <input type="text" name="icon" placeholder="misal: fas fa-rocket" required>
            </div>
            <div class="form-group">
                <label>Gambar Project</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label>Link Demo</label>
                <input type="text" name="link_demo">
            </div>
            <div class="form-group">
                <label>Link GitHub</label>
                <input type="text" name="link_github">
            </div>
            <button type="submit" name="add" class="btn">Tambah Project</button>
        </form>
        <table>
            <tr><th>Judul</th><th>Icon</th><th>Teknologi</th><th>Gambar</th><th>Aksi</th></tr>
            <?php while($row = $projects->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><i class="<?= htmlspecialchars($row['icon']) ?>"></i> <?= htmlspecialchars($row['icon']) ?></td>
                <td><?= htmlspecialchars($row['tech']) ?></td>
                <td><?php if($row['image']) echo '<img src="../assets/images/'.htmlspecialchars($row['image']).'">'; ?></td>
                <td><a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Hapus project ini?')">Hapus</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
