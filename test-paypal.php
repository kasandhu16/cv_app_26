<?php
require_once 'php/config.php';
require_once 'php/functions.php';

echo "<h2>PayPal Configuration Test</h2>";
echo "<pre>";

// Test 1: Check constants
echo "1. PayPal Constants:\n";
echo "   Client ID: " . (defined('PAYPAL_CLIENT_ID') ? substr(PAYPAL_CLIENT_ID, 0, 20) . "..." : "NOT SET") . "\n";
echo "   Secret: " . (defined('PAYPAL_SECRET') ? "SET" : "NOT SET") . "\n";
echo "   Base URL: " . (defined('PAYPAL_BASE_URL') ? PAYPAL_BASE_URL : "NOT SET") . "\n\n";

// Test 2: Get Access Token
echo "2. Testing Access Token:\n";
$token = getPayPalAccessToken();
if ($token) {
    echo "   ✓ Access token obtained: " . substr($token, 0, 30) . "...\n\n";
} else {
    echo "   ✗ Failed to get access token. Check credentials.\n\n";
}

// Test 3: Create Order
if ($token) {
    echo "3. Creating Test Order:\n";
    $order = createPayPalOrder(2.00);
    if ($order && isset($order['id'])) {
        echo "   ✓ Order created successfully\n";
        echo "   Order ID: " . $order['id'] . "\n";
        echo "   Status: " . ($order['status'] ?? 'N/A') . "\n";
        echo "   Full Response:\n";
        echo "   " . json_encode($order, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
    } else {
        echo "   ✗ Failed to create order\n";
        echo "   Response: " . json_encode($order, JSON_PRETTY_PRINT) . "\n";
    }
}

echo "</pre>";
?>
