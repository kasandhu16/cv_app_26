<?php
// Database configuration
// Use SQLite for local testing or MySQL for production hosting
define('DB_TYPE', 'sqlite');
define('DB_FILE', __DIR__ . '/../database/cv_creator.db');

// define('DB_TYPE', 'mysql');
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'u998578075_cvApp26');
// define('DB_USER', 'u998578075_cvApp26');
// define('DB_PASS', 'pp7J7xpzz');

// For SQLite local testing, uncomment the two lines above and comment out the MySQL settings.

// Application configuration
define('APP_NAME', 'ATS-Friendly CV Creator');
// Dynamically determine the app path from the URL
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);
$appPath = ($scriptPath === '\\' || $scriptPath === '/') ? '' : $scriptPath;
define('APP_URL', 'http://' . $_SERVER['HTTP_HOST'] . $appPath); // Automatically uses current domain and path
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('PDF_CACHE_DIR', __DIR__ . '/../pdf-cache/');

define('PAYPAL_CLIENT_ID', 'AcBWw8jE-AUSKAi5lN9emMVqk6RoyDtAnVG6PtVlMIDDKqil2iUmjAEGQ193Ojg4xoNp0HPp8vIzhccvF1VSkyfTU');
define('PAYPAL_SECRET', 'EDL7bXUH6zSRE18MO8Sox1osrKMN6xdCSlvtJggocHKWElibBRTJzom2FOmI55KH9GQ1wZGm_wQt3IrrEDL7bXUH6zSRE18MO8Sox1osrKMN6xdCSlvtJggocHKWElibBRTJzom2FOmI55KH9GQ1wZGm_wQt3Irr');
define('PAYPAL_BASE_URL', 'https://api-m.sandbox.paypal.com');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
ini_set('session.cookie_samesite', 'Lax');
session_start();

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('UTC');

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Database connection function
function getDBConnection() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            if (DB_TYPE === 'sqlite') {
                $pdo = new PDO('sqlite:' . DB_FILE);
            } else {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
                $pdo = new PDO($dsn, DB_USER, DB_PASS);
            }
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    return $pdo;
}

// Utility function to get current user ID
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

// Utility function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Utility function to redirect
function redirect($url) {
    if (strpos($url, '/') === 0 && strpos($url, '//') !== 0) {
        $url = rtrim(APP_URL, '/') . $url;
    }
    header('Location: ' . $url);
    exit;
}

// Utility function to validate CSRF token
function validateCSRFToken($token) {
    return hash_equals($_SESSION['csrf_token'], $token);
}

// Utility function to generate CSRF token input
function csrfTokenInput() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token']) . '">';
}
?>