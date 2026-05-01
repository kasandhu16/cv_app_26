<?php
require_once 'php/config.php';
require_once 'php/functions.php';

header('Content-Type: application/json');

$userId = getCurrentUserId();
if (!$userId) {
    http_response_code(401);
    echo json_encode(['error' => 'You must be logged in to complete the payment.']);
    exit;
}

$feature = $_POST['feature'] ?? 'pdf_export';
$resumeId = $_POST['resume_id'] ?? null;

if (hasPremiumAccess($userId, $feature)) {
    echo json_encode(['error' => 'Premium access already granted.']);
    exit;
}

$order = createPayPalOrder(2.00);
if (!$order || empty($order['id'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Unable to create PayPal order.']);
    exit;
}

echo json_encode(['id' => $order['id']]);
