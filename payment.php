<?php
require_once 'php/config.php';
require_once 'php/functions.php';

$userId = getCurrentUserId();
if (!$userId) {
    header('Location: login.php');
    exit;
}

$feature = $_GET['feature'] ?? 'pdf_export';
$resumeId = $_GET['resume_id'] ?? null;

// Check if user already has access
if (hasPremiumAccess($userId, $feature)) {
    if ($feature === 'pdf_export' && $resumeId) {
        header('Location: export-pdf.php?id=' . $resumeId);
    } else {
        header('Location: dashboard.php');
    }
    exit;
}

// Handle payment success
if (isset($_GET['success']) && isset($_GET['session_id'])) {
    // In a real implementation, you'd verify the payment with Stripe
    // For demo purposes, we'll just grant access
    grantPremiumAccess($userId, $feature);

    if ($feature === 'pdf_export' && $resumeId) {
        header('Location: export-pdf.php?id=' . $resumeId);
    } else {
        header('Location: dashboard.php?payment=success');
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Upgrade - CV Creator</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .payment-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .payment-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .payment-header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .payment-header p {
            color: #7f8c8d;
            font-size: 1.1em;
        }
        .pricing-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
        }
        .price {
            font-size: 3em;
            font-weight: bold;
            margin: 20px 0;
        }
        .price sup {
            font-size: 0.5em;
            vertical-align: super;
        }
        .features-list {
            list-style: none;
            padding: 0;
            margin: 30px 0;
        }
        .features-list li {
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .features-list li:last-child {
            border-bottom: none;
        }
        .features-list i {
            color: #ffd700;
        }
        .payment-button {
            background: #27ae60;
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.2em;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }
        .payment-button:hover {
            background: #219a52;
        }
        .payment-button i {
            margin-right: 10px;
        }
        .demo-notice {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }
        .demo-notice strong {
            color: #533f00;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="payment-container">
            <div class="payment-header">
                <h1><i class="fas fa-crown"></i> Unlock Premium Features</h1>
                <p>Get access to professional PDF exports and premium templates</p>
            </div>

            <div class="pricing-card">
                <h2>PDF Export Access</h2>
                <div class="price">$2<sup>00</sup></div>
                <p>One-time payment for lifetime access</p>

                <ul class="features-list">
                    <li><i class="fas fa-check"></i> High-quality PDF export</li>
                    <li><i class="fas fa-check"></i> Vector-based graphics</li>
                    <li><i class="fas fa-check"></i> ATS-friendly formatting</li>
                    <li><i class="fas fa-check"></i> Instant download</li>
                    <li><i class="fas fa-check"></i> Lifetime access</li>
                </ul>
            </div>

            <div id="paypal-button-container"></div>

            <div class="demo-notice">
                <strong>Sandbox Mode:</strong> Using PayPal sandbox for secure test payments. Complete the purchase to unlock premium PDF export.
            </div>
        </div>
    </div>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo urlencode(PAYPAL_CLIENT_ID); ?>&currency=USD&intent=capture"></script>
    <script>
        const premiumFeature = "<?php echo htmlspecialchars($feature); ?>";
        const resumeId = "<?php echo htmlspecialchars($resumeId); ?>";

        paypal.Buttons({
            createOrder: function(data, actions) {
                return fetch('paypal-create-order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        feature: premiumFeature,
                        resume_id: resumeId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.id) {
                        return data.id;
                    }
                    throw new Error(data.error || 'Unable to create PayPal order.');
                });
            },
            onApprove: function(data, actions) {
                return fetch('paypal-capture-order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        orderID: data.orderID,
                        feature: premiumFeature,
                        resume_id: resumeId
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success' && result.redirect) {
                        window.location.href = result.redirect;
                        return;
                    }
                    throw new Error(result.error || 'Payment could not be completed.');
                });
            },
            onCancel: function() {
                alert('Payment cancelled. You can retry to unlock premium PDF export.');
            },
            onError: function(err) {
                console.error('PayPal error:', err);
                alert('An error occurred while processing payment. Please try again.');
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>