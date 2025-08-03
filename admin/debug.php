<?php
echo "<h2>Debug Login System</h2>";

// Check if config.php exists and show its content
$configPath = __DIR__ . '/config.php';
if (file_exists($configPath)) {
    echo "<p style='color: green;'>✅ config.php found</p>";
    
    // Include config and test
    try {
        require_once 'config.php';
        echo "<p style='color: blue;'>✅ config.php loaded successfully</p>";
        
        // Test database connection
        $pdo = getConnection();
        echo "<p style='color: green;'>✅ Database connection works!</p>";
        
        // Test authentication function
        echo "<h3>Testing authentication...</h3>";
        $user = authenticateUser('admin', 'password123');
        if ($user) {
            echo "<p style='color: green;'>✅ Authentication SUCCESS for admin</p>";
            echo "<pre>" . print_r($user, true) . "</pre>";
        } else {
            echo "<p style='color: red;'>❌ Authentication FAILED for admin</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ config.php NOT found at: $configPath</p>";
}

// Check what files exist in admin folder
echo "<h3>Files in admin folder:</h3>";
$files = scandir(__DIR__);
echo "<ul>";
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "<li>$file</li>";
    }
}
echo "</ul>";
?>
