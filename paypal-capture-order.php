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

$orderId = $_POST['orderID'] ?? null;
$feature = $_POST['feature'] ?? 'pdf_export';
$resumeId = $_POST['resume_id'] ?? null;

if (!$orderId) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing PayPal order ID.']);
    exit;
}

$response = capturePayPalOrder($orderId);
if (!$response) {
    http_response_code(500);
    echo json_encode(['error' => 'Unable to verify PayPal payment.']);
    exit;
}

$completed = false;
if (isset($response['status']) && $response['status'] === 'COMPLETED') {
    $completed = true;
}

if (!$completed && isset($response['purchase_units'][0]['payments']['captures'][0]['status']) && $response['purchase_units'][0]['payments']['captures'][0]['status'] === 'COMPLETED') {
    $completed = true;
}

if (!$completed) {
    http_response_code(400);
    echo json_encode(['error' => 'Payment was not completed.']);
    exit;
}

grantPremiumAccess($userId, $feature);
recordPayment($userId, $orderId, 2.00, 'USD', 'completed');

$redirect = 'dashboard.php?payment=success';
if ($feature === 'pdf_export' && $resumeId) {
    $redirect = 'export-pdf.php?id=' . urlencode($resumeId);
}

echo json_encode([
    'status' => 'success',
    'redirect' => $redirect
]);
