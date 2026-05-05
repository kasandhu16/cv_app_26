<?php
// A simple deployment script

function deploy() {
    log_message('INFO: Starting deployment...');

    // 1. Pull latest code from Git
    log_message('INFO: Pulling latest code from main branch...');
    $git_output = shell_exec('git pull origin main 2>&1');
    log_message('GIT: ' . $git_output);

    // 2. Run database migrations
    log_message('INFO: Running database migrations...');
    $migration_output = shell_exec('php run_migrations.php 2>&1');
    log_message('MIGRATION: ' . $migration_output);

    log_message('SUCCESS: Deployment finished.');
}

function log_message($message) {
    $timestamp = date('Y-m-d H:i:s');
    echo "[$timestamp] $message\n";
}

deploy();
