<?php
// Test database connection
$passwords = ['pp7J7xpzz', '', 'root'];

foreach ($passwords as $pass) {
    try {
        $pdo = new PDO('mysql:host=localhost', 'root', $pass);
        echo "MySQL connection successful with password: '$pass'\n";

        // Try to create database
        $pdo->exec('CREATE DATABASE IF NOT EXISTS cv_creator');
        echo "Database created successfully.\n";

        // Select database
        $pdo->exec('USE cv_creator');

        // Create a simple table to test
        $pdo->exec('CREATE TABLE IF NOT EXISTS test (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(50))');
        echo "Test table created successfully.\n";

        echo "Database setup is working!\n";
        exit(0);

    } catch (PDOException $e) {
        echo "Failed with password '$pass': " . $e->getMessage() . "\n";
    }
}

echo "Could not connect with any of the tested passwords.\n";
echo "Please check your MySQL root password.\n";
?>