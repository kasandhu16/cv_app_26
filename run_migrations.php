<?php
require_once 'php/functions.php';

function run_migrations() {
    $pdo = getDBConnection();
    if (!$pdo) {
        log_message('ERROR: Failed to connect to the database for migrations.');
        return;
    }

    log_message('INFO: Running database migrations...');

    try {
        // Check if 'is_premium' column exists
        $stmt = $pdo->query("PRAGMA table_info(users)");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (!in_array('is_premium', $columns)) {
            log_message('INFO: Adding is_premium column to users table.');
            $pdo->exec('ALTER TABLE users ADD COLUMN is_premium BOOLEAN NOT NULL DEFAULT 0');
            log_message('SUCCESS: Added is_premium column.');
        } else {
            log_message('INFO: is_premium column already exists.');
        }

    } catch (PDOException $e) {
        log_message('ERROR: Migration failed: ' . $e->getMessage());
    }
}

run_migrations();
