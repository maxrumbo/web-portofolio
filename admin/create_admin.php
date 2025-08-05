<?php
// Jalankan file ini sekali saja, lalu copy hasil hash ke database
$hash = password_hash('maxrumbo', PASSWORD_DEFAULT);

// Koneksi ke database
$host = 'localhost';
$user = 'root'; // ganti jika user MySQL Anda berbeda
$pass = '';
$db = 'MAXRUMBO'; // ganti dengan nama database Anda
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die('Koneksi gagal: ' . $conn->connect_error);

// Cek apakah sudah ada user maxrumbo
$res = $conn->query("SELECT * FROM admin WHERE username='maxrumbo'");
if ($res->num_rows == 0) {
    $stmt = $conn->prepare('INSERT INTO admin (username, password) VALUES (?, ?)');
    $stmt->bind_param('ss', $uname, $pw);
    $uname = 'maxrumbo';
    $pw = $hash;
    $stmt->execute();
    echo 'User admin maxrumbo berhasil dibuat!';
} else {
    echo 'User maxrumbo sudah ada.';
}
?>
