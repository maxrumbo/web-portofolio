<?php
session_start();
require_once 'check_login.php';
require_once 'config.php';

// Ambil data hero
$query = $conn->query('SELECT * FROM hero LIMIT 1');
$hero = $query->fetch_assoc();

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $role = $_POST['role'];
    $university = $_POST['university'];
    $student_id = $_POST['student_id'];
    $department = $_POST['department'];
    $graduation_year = $_POST['graduation_year'];
    $profile_image = $hero['profile_image'];

    // Upload gambar jika ada
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . time() . '.' . $ext;
        $target = '../assets/images/' . $filename;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
            $profile_image = $filename;
        }
    }

    $stmt = $conn->prepare('UPDATE hero SET full_name=?, role=?, university=?, student_id=?, department=?, graduation_year=?, profile_image=? WHERE id=?');
    $stmt->bind_param('sssssisi', $full_name, $role, $university, $student_id, $department, $graduation_year, $profile_image, $hero['id']);
    $stmt->execute();
    header('Location: edit_hero.php?success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hero - Admin</title>
    <link rel="stylesheet" href="admin-style.css">
    <style>
        body {background: #232946; color: #fff; font-family: Arial, sans-serif;}
        .form-container {max-width: 500px; margin: 40px auto; background: #2a2d3e; border-radius: 12px; padding: 32px 28px; box-shadow: 0 4px 24px #0002;}
        .form-container h2 {margin-bottom: 24px; text-align: center;}
        .form-group {margin-bottom: 18px;}
        .form-group label {display: block; margin-bottom: 6px;}
        .form-group input, .form-group select {width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #232946; color: #fff;}
        .form-group img {max-width: 120px; margin-top: 8px; border-radius: 8px;}
        .btn {width: 100%; padding: 12px; background: #9ece6a; color: #232946; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;}
        .success {color: #9ece6a; text-align: center; margin-bottom: 12px;}
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Hero</h2>
        <?php if (isset($_GET['success'])) echo '<div class="success">Data berhasil disimpan!</div>'; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($hero['full_name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Role/Profesi</label>
                <input type="text" name="role" value="<?= htmlspecialchars($hero['role']) ?>" required>
            </div>
            <div class="form-group">
                <label>Universitas/Perusahaan</label>
                <input type="text" name="university" value="<?= htmlspecialchars($hero['university']) ?>">
            </div>
            <div class="form-group">
                <label>ID Mahasiswa/Karyawan</label>
                <input type="text" name="student_id" value="<?= htmlspecialchars($hero['student_id']) ?>">
            </div>
            <div class="form-group">
                <label>Departemen</label>
                <input type="text" name="department" value="<?= htmlspecialchars($hero['department']) ?>">
            </div>
            <div class="form-group">
                <label>Tahun Lulus</label>
                <input type="number" name="graduation_year" value="<?= htmlspecialchars($hero['graduation_year']) ?>">
            </div>
            <div class="form-group">
                <label>Foto Profil</label>
                <input type="file" name="profile_image" accept="image/*">
                <?php if ($hero['profile_image']) echo '<img src="../assets/images/'.htmlspecialchars($hero['profile_image']).'" alt="Profile">'; ?>
            </div>
            <button type="submit" class="btn">Simpan</button>
        </form>
    </div>
</body>
</html>
