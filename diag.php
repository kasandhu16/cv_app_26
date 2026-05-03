<?php
// diag.php - A script to diagnose the isPremiumUser function issue.
echo "<h1>CV Maker Diagnostics</h1>";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Section 1: Environment Info ---
echo "<h2>Environment</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current Working Directory: " . getcwd() . "<br>";
echo "<hr>";

// --- Section 2: File Checks ---
echo "<h2>File System Checks</h2>";
$auth_file_path = 'php/auth.php';
echo "Checking for: <strong>{$auth_file_path}</strong><br>";

if (file_exists($auth_file_path)) {
    echo "<span style='color:green; font-weight:bold;'>SUCCESS: File '{$auth_file_path}' exists.</span><br>";
    if (is_readable($auth_file_path)) {
        echo "<span style='color:green; font-weight:bold;'>SUCCESS: File is readable.</span><br>";
    } else {
        echo "<span style='color:red; font-weight:bold;'>ERROR: File is NOT readable. Check file permissions.</span><br>";
    }
} else {
    echo "<span style='color:red; font-weight:bold;'>FATAL ERROR: File '{$auth_file_path}' does not exist. This is the root of the problem.</span><br>";
}
echo "<hr>";


// --- Section 3: Function Check ---
echo "<h2>Function Availability Check</h2>";

if (function_exists('isPremiumUser')) {
    echo "<span style='color:orange;'>UNEXPECTED: 'isPremiumUser' function exists BEFORE including the file.</span><br>";
} else {
    echo "<span style='color:blue;'>INFO: 'isPremiumUser' function does not exist yet, as expected.</span><br>";
}

echo "Attempting to include '{$auth_file_path}'...<br>";
if (file_exists($auth_file_path) && is_readable($auth_file_path)) {
    require_once $auth_file_path;
    echo "<span style='color:green;'>SUCCESS: Included '{$auth_file_path}'.</span><br>";

    if (function_exists('isPremiumUser')) {
        echo "<p style='font-size: 1.5em; background-color: lightgreen; padding: 15px;'><strong>ULTIMATE SUCCESS:</strong> The 'isPremiumUser' function is now defined and available!</p>";
    } else {
        echo "<p style='font-size: 1.5em; background-color: #ffcccb; padding: 15px;'><strong>ULTIMATE FAILURE:</strong> Included the file, but the 'isPremiumUser' function is STILL not defined. This proves the `php/auth.php` file on your server is an old version and is missing the function.</p>";
    }

} else {
     echo "<span style='color:red;'>ERROR: Cannot include file because it does not exist or is not readable.</span><br>";
}
echo "<hr>";

echo "<h2>Conclusion</h2>";
echo "<p>If you see 'ULTIMATE FAILURE' or 'FATAL ERROR', it proves your server is running old code. The only solution is to get the latest code onto the server. The `git reset --hard origin/main` command is the most direct way to do this.</p>";
?>