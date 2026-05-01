<?php
require_once 'config.php';

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
}

/**
 * Validate email address
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Generate a random string
 */
function generateRandomString($length = 10) {
    return bin2hex(random_bytes($length));
}

/**
 * Get file extension
 */
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Check if file is an image
 */
function isImageFile($filename) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    return in_array(getFileExtension($filename), $allowedExtensions);
}

/**
 * Upload file securely
 */
function uploadFile($file, $destinationDir, $allowedTypes = null, $maxSize = 2097152) { // 2MB default
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Upload error'];
    }

    if ($file['size'] > $maxSize) {
        return ['success' => false, 'error' => 'File too large'];
    }

    $filename = basename($file['name']);
    $extension = getFileExtension($filename);

    if ($allowedTypes && !in_array($extension, $allowedTypes)) {
        return ['success' => false, 'error' => 'Invalid file type'];
    }

    $newFilename = generateRandomString(16) . '.' . $extension;
    $destination = $destinationDir . $newFilename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => true, 'filename' => $newFilename, 'path' => $destination];
    }

    return ['success' => false, 'error' => 'Failed to move file'];
}

/**
 * Delete file
 */
function deleteFile($filepath) {
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    return false;
}

/**
 * Format date for display
 */
function formatDate($date) {
    return date('M Y', strtotime($date));
}

/**
 * Validate CV data
 */
function validateCVData($data) {
    $required = ['personal_info', 'work_experience', 'education'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            return false;
        }
    }
    return true;
}

/**
 * Get blog post by slug
 */
function getBlogPostBySlug($slug) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare('SELECT * FROM blog_posts WHERE slug = ? AND published_at <= NOW()');
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

/**
 * Get all published blog posts
 */
function getPublishedBlogPosts() {
    $pdo = getDBConnection();
    $stmt = $pdo->query('SELECT id, title, slug, meta_description, published_at FROM blog_posts WHERE published_at <= NOW() ORDER BY published_at DESC');
    return $stmt->fetchAll();
}

/**
 * Get resume by ID (with permission check)
 */
function getResume($id, $userId = null) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare('SELECT * FROM resumes WHERE id = ? AND (user_id = ? OR user_id IS NULL)');
    $stmt->execute([$id, $userId]);
    return $stmt->fetch();
}

/**
 * Save resume data
 */
function saveResume($data, $templateId, $userId = null, $sessionId = null) {
    $pdo = getDBConnection();

    if ($userId) {
        // For logged-in users
        $stmt = $pdo->prepare('INSERT INTO resumes (user_id, data, template_id) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE data = VALUES(data), template_id = VALUES(template_id), updated_at = NOW()');
        $stmt->execute([$userId, json_encode($data), $templateId]);
        return $pdo->lastInsertId();
    } else {
        // For guest users
        $stmt = $pdo->prepare('INSERT INTO resumes (session_id, data, template_id) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE data = VALUES(data), template_id = VALUES(template_id), updated_at = NOW()');
        $stmt->execute([$sessionId, json_encode($data), $templateId]);
        return $pdo->lastInsertId();
    }
}

/**
 * Get user's resumes
 */
function getUserResumes($userId = null, $sessionId = null) {
    $pdo = getDBConnection();

    if ($userId) {
        $stmt = $pdo->prepare('SELECT id, data, template_id, created_at, updated_at FROM resumes WHERE user_id = ? ORDER BY updated_at DESC');
        $stmt->execute([$userId]);
    } else {
        $stmt = $pdo->prepare('SELECT id, data, template_id, created_at, updated_at FROM resumes WHERE session_id = ? ORDER BY updated_at DESC');
        $stmt->execute([$sessionId]);
    }

    return $stmt->fetchAll();
}

/**
 * Check if user has premium access
 */
function hasPremiumAccess($userId, $featureType = 'pdf_export') {
    if (!$userId) return false;

    $pdo = getDBConnection();
    $stmt = $pdo->prepare('SELECT id FROM premium_access WHERE user_id = ? AND feature_type = ? AND (expires_at IS NULL OR expires_at > NOW())');
    $stmt->execute([$userId, $featureType]);
    return $stmt->fetch() !== false;
}

/**
 * Grant premium access to user
 */
function grantPremiumAccess($userId, $featureType = 'pdf_export', $expiresAt = null) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare('INSERT INTO premium_access (user_id, feature_type, granted_at, expires_at) VALUES (?, ?, NOW(), ?) ON DUPLICATE KEY UPDATE granted_at = NOW(), expires_at = VALUES(expires_at)');
    $stmt->execute([$userId, $featureType, $expiresAt]);
}

/**
 * Record payment
 */
function recordPayment($userId, $paymentProviderId, $amount, $currency = 'USD', $status = 'completed') {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare('INSERT INTO payments (user_id, stripe_payment_id, amount, currency, status) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$userId, $paymentProviderId, $amount, $currency, $status]);
}

/**
 * Get a PayPal access token
 */
function getPayPalAccessToken() {
    $ch = curl_init(PAYPAL_BASE_URL . '/v1/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ':' . PAYPAL_SECRET);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Accept-Language: en_US'
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $statusCode !== 200) {
        return null;
    }

    $data = json_decode($response, true);
    return $data['access_token'] ?? null;
}

/**
 * Make a PayPal API request
 */
function paypalApiRequest($endpoint, $method = 'GET', $body = null, $accessToken = null) {
    $ch = curl_init(PAYPAL_BASE_URL . $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    $headers = [
        'Accept: application/json',
        'Content-Type: application/json'
    ];

    if ($accessToken !== null) {
        $headers[] = 'Authorization: Bearer ' . $accessToken;
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    if ($body !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }

    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false) {
        return null;
    }

    $data = json_decode($response, true);
    if (!is_array($data)) {
        return null;
    }

    return $data;
}

/**
 * Create a PayPal order
 */
function createPayPalOrder($amount, $currency = 'USD') {
    $accessToken = getPayPalAccessToken();
    if (!$accessToken) {
        return null;
    }

    $body = [
        'intent' => 'CAPTURE',
        'purchase_units' => [
            [
                'amount' => [
                    'currency_code' => $currency,
                    'value' => number_format($amount, 2, '.', '')
                ]
            ]
        ],
        'application_context' => [
            'brand_name' => APP_NAME,
            'shipping_preference' => 'NO_SHIPPING',
            'user_action' => 'PAY_NOW'
        ]
    ];

    return paypalApiRequest('/v2/checkout/orders', 'POST', $body, $accessToken);
}

/**
 * Capture a PayPal order
 */
function capturePayPalOrder($orderId) {
    $accessToken = getPayPalAccessToken();
    if (!$accessToken) {
        return null;
    }

    return paypalApiRequest('/v2/checkout/orders/' . urlencode($orderId) . '/capture', 'POST', null, $accessToken);
}

/**
 * Get template name by ID (updated for 12 templates)
 */
function getTemplateName($id) {
    $templates = [
        1 => 'Professional Classic',
        2 => 'Modern Minimal',
        3 => 'Creative Design',
        4 => 'Executive Suite',
        5 => 'Tech Innovator',
        6 => 'Creative Artist',
        7 => 'Business Professional',
        8 => 'Academic Scholar',
        9 => 'Startup Founder',
        10 => 'Design Expert',
        11 => 'Marketing Pro',
        12 => 'Engineering Elite'
    ];
    return $templates[$id] ?? 'Unknown';
}

/**
 * Check if template is premium (templates 4-12 are premium)
 */
function isPremiumTemplate($templateId) {
    return $templateId >= 4;
}

/**
 * Convert skill level to percentage for progress bars
 */
function getSkillPercentage($level) {
    $levels = [
        'beginner' => 25,
        'intermediate' => 50,
        'advanced' => 75,
        'expert' => 100
    ];
    return $levels[strtolower($level)] ?? 50;
}

/**
 * Convert language proficiency to percentage
 */
function getProficiencyPercentage($proficiency) {
    $levels = [
        'basic' => 25,
        'conversational' => 50,
        'fluent' => 75,
        'native' => 100
    ];
    return $levels[strtolower($proficiency)] ?? 50;
}

/**
 * Convert skill level to rating (1-5 stars)
 */
function getSkillRating($level) {
    $levels = [
        'beginner' => 2,
        'intermediate' => 3,
        'advanced' => 4,
        'expert' => 5
    ];
    return $levels[strtolower($level)] ?? 3;
}
?>