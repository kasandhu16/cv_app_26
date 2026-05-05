<?php
require_once 'php/functions.php';

$pdo = getDBConnection();

$sql = "ALTER TABLE users ADD COLUMN is_premium BOOLEAN NOT NULL DEFAULT FALSE";

try {
    $pdo->exec($sql);
    echo "Table 'users' altered successfully to add 'is_premium' column.";
} catch (PDOException $e) {
    die("Error altering table: " . $e->getMessage());
}
