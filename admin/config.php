<?php
// Database configuration for MySQL
$host = 'localhost';
$dbname = 'portfolio_admin';
$username = 'root';  // MySQL username (default for XAMPP)
$password = '';      // MySQL password (empty for XAMPP)

// Create connection using PDO
function getConnection() {
    global $host, $dbname, $username, $password;
    
    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Function to authenticate user
function authenticateUser($username, $password) {
    $pdo = getConnection();
    
    $sql = "SELECT id, username, password, email, full_name, role, is_active FROM users WHERE username = ? AND is_active = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && $user['password'] === $password) {
        // Update last login
        $updateSql = "UPDATE users SET last_login = NOW() WHERE id = ?";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([$user['id']]);
        
        return $user;
    }
    
    return false;
}

// Function to get all users (for admin panel)
function getAllUsers() {
    $pdo = getConnection();
    
    $sql = "SELECT id, username, email, full_name, role, created_at, last_login, is_active FROM users ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to add new user
function addUser($username, $password, $email, $full_name, $role = 'user') {
    $pdo = getConnection();
    
    $sql = "INSERT INTO users (username, password, email, full_name, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$username, $password, $email, $full_name, $role]);
}
?>
