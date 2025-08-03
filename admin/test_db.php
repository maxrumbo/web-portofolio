<?php
// Test database connection
echo "<h2>Testing Database Connection...</h2>";

$host = 'localhost';
$dbname = 'portfolio_admin';
$username = 'root';
$password = '';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // Test query
    $stmt = $pdo->query("SELECT COUNT(*) as user_count FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p style='color: blue;'>📊 Users in database: " . $result['user_count'] . "</p>";
    
    // Show all users
    $stmt = $pdo->query("SELECT username, email, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Users in database:</h3>";
    echo "<ul>";
    foreach ($users as $user) {
        echo "<li>{$user['username']} ({$user['role']}) - {$user['email']}</li>";
    }
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Connection failed: " . $e->getMessage() . "</p>";
}
?>
