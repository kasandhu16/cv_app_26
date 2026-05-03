<?php
require_once 'php/config.php';
require_once 'php/auth.php';
require_once 'php/functions.php';
require_once 'php/cv.php';

// Must be logged in
if (!isLoggedIn()) {
    header('Location: ' . APP_URL . '/login');
    exit;
}

$userId = getCurrentUserId();
$error = '';
$message = '';

// Get resume ID from query string
$resumeId = $_GET['id'] ?? null;

if (!$resumeId) {
    header('Location: ' . APP_URL . '/dashboard');
    exit;
}

// Handle deletion on POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (validateCSRFToken($_POST['csrf_token'])) {
        if (deleteResume($resumeId, $userId)) {
            // Redirect to dashboard with success message
            header('Location: ' . APP_URL . '/dashboard?deleted=1');
            exit;
        } else {
            $error = 'Failed to delete the CV. It may have already been deleted or you may not have permission.';
        }
    } else {
        $error = 'Invalid request. Please try again.';
    }
}

// Get resume data for confirmation message
$resume = getResume($resumeId, $userId);
if (!$resume) {
    // If resume doesn't exist or doesn't belong to user, redirect
    header('Location: ' . APP_URL . '/dashboard');
    exit;
}

$pageTitle = 'Delete CV - ' . APP_NAME;
$metaDescription = 'Confirm the deletion of your CV.';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <!-- Navbar -->
    </header>

    <main>
        <div class="container">
            <div class="delete-confirmation-box">
                <h1>Delete CV</h1>
                <p>Are you sure you want to permanently delete this CV? This action cannot be undone.</p>

                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="<?php echo APP_URL; ?>/delete-cv?id=<?php echo htmlspecialchars($resumeId); ?>">
                    <?php echo csrfTokenInput(); ?>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Yes, Delete</button>
                        <a href="<?php echo APP_URL; ?>/dashboard" class="btn">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="main-footer">
       <!-- Footer -->
    </footer>
</body>
</html>