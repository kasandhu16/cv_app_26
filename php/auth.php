<?php
require_once 'functions.php';

/**
 * Register a new user
 */
function registerUser($username, $email, $password) {
    $pdo = getDBConnection();

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        return ['success' => false, 'error' => 'All fields are required'];
    }

    if (!validateEmail($email)) {
        return ['success' => false, 'error' => 'Invalid email address'];
    }

    if (strlen($password) < 8) {
        return ['success' => false, 'error' => 'Password must be at least 8 characters long'];
    }

    // Check if username or email already exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        return ['success' => false, 'error' => 'Username or email already exists'];
    }

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
    if ($stmt->execute([$username, $email, $passwordHash])) {
        $userId = $pdo->lastInsertId();
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        return ['success' => true, 'user_id' => $userId];
    }

    return ['success' => false, 'error' => 'Registration failed'];
}

/**
 * Login user
 */
function loginUser($email, $password) {
    $pdo = getDBConnection();

    // Validate input
    if (empty($email) || empty($password)) {
        return ['success' => false, 'error' => 'Email and password are required'];
    }

    // Get user
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return ['success' => false, 'error' => 'Invalid email or password'];
    }

    // Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    
    return ['success' => true, 'user_id' => $user['id']];
}

/**
 * Logout user
 */
function logoutUser() {
    session_destroy();
    session_start(); // Start new session for guest functionality
}

/**
 * Get current user info
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }

    $pdo = getDBConnection();
    $stmt = $pdo->prepare('SELECT id, username, email, created_at FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

/**
 * Check if the current user is a premium member.
 */
function isPremiumUser($userId = null) {
    // Since the is_premium feature is not fully implemented, we will return false for now.
    return false;
}

/**
 * Update user password
 */
function updateUserPassword($currentPassword, $newPassword) {
    if (!isLoggedIn()) {
        return ['success' => false, 'error' => 'Not logged in'];
    }

    $pdo = getDBConnection();

    // Get current password hash
    $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
        return ['success' => false, 'error' => 'Current password is incorrect'];
    }

    if (strlen($newPassword) < 8) {
        return ['success' => false, 'error' => 'New password must be at least 8 characters long'];
    }

    // Update password
    $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
    if ($stmt->execute([$newHash, $_SESSION['user_id']])) {
        return ['success' => true];
    }

    return ['success' => false, 'error' => 'Password update failed'];
}
?>