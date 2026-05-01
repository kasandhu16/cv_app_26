<?php
// Manual schema import script
require_once 'php/config.php';

try {
    echo "Importing database schema...\n";

    if (DB_TYPE === 'mysql') {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
        echo "✓ Connected to MySQL database: " . DB_NAME . "\n";
    } else {
        $pdo = new PDO('sqlite:' . DB_FILE);
        echo "✓ Connected to SQLite database\n";
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read and execute schema
    $schema = file_get_contents('db_schema.sql');
    $statements = array_filter(array_map('trim', explode(';', $schema)));

    $successCount = 0;
    $errorCount = 0;

    foreach ($statements as $statement) {
        if (!empty($statement) && !preg_match('/^--/', $statement)) {
            try {
                $pdo->exec($statement);
                $successCount++;
            } catch (PDOException $e) {
                echo "✗ Error executing: " . substr($statement, 0, 50) . "...\n";
                echo "   " . $e->getMessage() . "\n";
                $errorCount++;
            }
        }
    }

    echo "\nImport completed:\n";
    echo "✓ $successCount statements executed successfully\n";
    if ($errorCount > 0) {
        echo "✗ $errorCount statements failed\n";
    }

} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
}
?>