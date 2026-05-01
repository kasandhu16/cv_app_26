<?php
// Database connection test script
require_once 'php/config.php';

try {
    echo "Testing database connection...\n";

    if (DB_TYPE === 'mysql') {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
        echo "✓ Connected to MySQL database: " . DB_NAME . "\n";

        // Check if tables exist
        $tables = ['users', 'resumes', 'blog_posts', 'payments', 'premium_access'];
        foreach ($tables as $table) {
            $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() > 0) {
                echo "✓ Table '$table' exists\n";
            } else {
                echo "✗ Table '$table' missing\n";
            }
        }

    } else {
        $pdo = new PDO('sqlite:' . DB_FILE);
        echo "✓ Connected to SQLite database\n";
    }

    echo "\nDatabase connection successful!\n";

} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    echo "\nTroubleshooting:\n";
    echo "1. Check DB_HOST, DB_NAME, DB_USER, DB_PASS in php/config.php\n";
    echo "2. Make sure the database user has access to the database\n";
    echo "3. For MySQL, ensure the database exists\n";
}
?>