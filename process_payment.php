<?php
require_once 'php/config.php';
require_once 'php/functions.php';

$userId = getCurrentUserId();
if (!$userId) {
    header('Location: login.php');
    exit;
}

$feature = $_POST['feature'] ?? 'pdf_export';
$resumeId = $_POST['resume_id'] ?? null;

// Simulate payment processing
// In a real application, you would:
// 1. Create a Stripe payment intent
// 2. Process the payment
// 3. Verify payment success
// 4. Record the payment in database

// For demo purposes, we'll simulate a successful payment
grantPremiumAccess($userId, $feature);

// Record the payment (even though it's fake)
recordPayment($userId, 'demo_payment_' . time(), 2.00, 'completed');

// Redirect based on feature
if ($feature === 'pdf_export' && $resumeId) {
    header('Location: export-pdf.php?id=' . $resumeId);
} else {
    header('Location: dashboard.php?payment=success');
}
exit;
?>