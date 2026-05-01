<?php
require_once 'config.php';

try {
    // Connect to SQLite database
    $pdo = new PDO('sqlite:' . DB_FILE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read and execute the schema
    $schema = file_get_contents(__DIR__ . '/../database/schema_sqlite.sql');
    $pdo->exec($schema);

    echo "SQLite database setup completed successfully!\n";
    echo "Database file: " . DB_FILE . "\n";

} catch (PDOException $e) {
    echo "Database setup failed: " . $e->getMessage() . "\n";
}
?>