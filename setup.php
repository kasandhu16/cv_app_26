<?php
// Database setup script
require_once 'php/config.php';

try {
    if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
        // Connect to the existing MySQL database on the host
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } else {
        // SQLite local testing
        $pdo = new PDO('sqlite:' . DB_FILE);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "SQLite database ready.\n";
    }

    // Read and execute schema
    $schema = file_get_contents('db_schema.sql');
    $statements = array_filter(array_map('trim', explode(';', $schema)));

    foreach ($statements as $statement) {
        if (empty($statement) || preg_match('/^--/', $statement)) {
            continue;
        }

        try {
            $pdo->exec($statement);
        } catch (PDOException $e) {
            $code = $e->getCode();
            $message = $e->getMessage();

            // Ignore errors for objects that already exist when setup is re-run
            if (strpos($message, 'Duplicate key name') !== false ||
                strpos($message, 'Table') !== false && strpos($message, 'already exists') !== false ||
                strpos($message, 'Duplicate column name') !== false) {
                continue;
            }

            throw $e;
        }
    }

    echo "Database schema imported successfully.\n";
    echo "Setup complete! You can now run the application.\n";

} catch (PDOException $e) {
    die('Database setup failed: ' . $e->getMessage() . "\n");
}
?>