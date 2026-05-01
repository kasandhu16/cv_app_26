<?php
require_once 'php/config.php';
require_once 'php/functions.php';

// Handle routing
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
// Dynamically remove the app base path from the request URI
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);
$appPath = ($scriptPath === '\\' || $scriptPath === '/') ? '' : $scriptPath;
if (!empty($appPath)) {
    $path = str_replace($appPath, '', $path);
}

// Clean path
$path = trim($path, '/');

// Route handling
switch ($path) {
    case '':
    case 'index':
        require 'home.php';
        break;
    case 'login':
        require 'login.php';
        break;
    case 'register':
        require 'register.php';
        break;
    case 'dashboard':
        require 'dashboard.php';
        break;
    case 'create-cv':
        require 'create-cv.php';
        break;
    case 'preview':
        require 'preview.php';
        break;
    case 'export-pdf':
        require 'export-pdf.php';
        break;
    case 'blog':
        require 'blog.php';
        break;
    default:
        // Check if it's a blog post
        if (strpos($path, 'blog/') === 0) {
            $_GET['slug'] = str_replace('blog/', '', $path);
            require 'blog-post.php';
        } else {
            http_response_code(404);
            echo 'Page not found';
        }
        break;
}
?>