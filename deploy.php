<?php
// Simple, secure webhook deployment script

// 1. SET YOUR SECRET TOKEN
// *************************************************************************
// THIS MUST MATCH THE "SECRET" IN YOUR GITHUB WEBHOOK SETTINGS
$secret = 'REPLACE_THIS_WITH_A_LONG_RANDOM_STRING';
// *************************************************************************

// 2. CONFIGURE YOUR DEPLOYMENT
// *************************************************************************
$repo_path = __DIR__; // Path to your repository, __DIR__ is usually correct
$branch = 'refs/heads/main'; // The branch to deploy
$log_file = __DIR__ . '/deploy_log.txt'; // Log file for debugging
// *************************************************************************

// --- SCRIPT LOGIC (No need to edit below this line) ---

function log_message($message) {
    global $log_file;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] " . $message . "\n", FILE_APPEND);
}

// Verify the request is from GitHub
if (!isset($_SERVER['HTTP_X_HUB_SIGNATURE_256'])) {
    log_message('ERROR: Request is missing X-Hub-Signature-256 header.');
    http_response_code(403);
    die('Forbidden');
}

$hub_signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'];
$payload = file_get_contents('php://input');
$local_signature = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($local_signature, $hub_signature)) {
    log_message('ERROR: GitHub webhook signature does not match.');
    http_response_code(403);
    die('Forbidden: Signature mismatch');
}

// Verify it's a push to the correct branch
$data = json_decode($payload, true);
if (!isset($data['ref']) || $data['ref'] !== $branch) {
    log_message('INFO: Payload received, but not for the specified branch. Ignoring.');
    die('Payload received, but not for the ' . $branch . ' branch. Nothing to do.');
}

// If we get this far, the request is valid. Time to deploy.
log_message('INFO: Valid webhook received. Starting deployment...');

// Deployment commands
$commands = [
    'git -C ' . escapeshellarg($repo_path) . ' fetch origin main', // Fetch the latest changes
    'git -C ' . escapeshellarg($repo_path) . ' reset --hard origin/main', // Force update to match the remote
    'git -C ' . escapeshellarg($repo_path) . ' pull origin main', // Pull the changes
    'composer install --no-interaction --no-dev --optimize-autoloader' // Install/update Composer dependencies
];

// Execute commands
foreach ($commands as $command) {
    $output = shell_exec($command . ' 2>&1');
    log_message("COMMAND: $command\nOUTPUT:\n" . ($output ?: 'No output'));
}

log_message('SUCCESS: Deployment finished.');

header('Content-Type: text/plain');
echo "Deployment successful. See log for details.";

?>