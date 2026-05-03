<?php
require_once 'php/config.php';
require_once 'php/auth.php';
require_once 'php/functions.php';
require_once 'php/cv.php';

if (!isLoggedIn()) {
    header('Location: ' . APP_URL . '/login');
    exit;
}

$userId = getCurrentUserId();
$userResumes = getResumesForUser($userId);

$pageTitle = 'Dashboard - ' . APP_NAME;
$metaDescription = 'Manage your CVs and account settings.';

if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    $message = "CV deleted successfully.";
}

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
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <h1><a href="<?php echo APP_URL; ?>/"><?php echo htmlspecialchars(APP_NAME); ?></a></h1>
                </div>
                <ul class="nav-menu">
                     <li><a href="<?php echo APP_URL; ?>/">Home</a></li>
                    <li><a href="<?php echo APP_URL; ?>/create-cv">Create CV</a></li>
                    <li><a href="<?php echo APP_URL; ?>/blog">Blog</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="<?php echo APP_URL; ?>/dashboard" class="active">Dashboard</a></li>
                        <li><a href="<?php echo APP_URL; ?>/login?logout=1">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo APP_URL; ?>/login">Login</a></li>
                        <li><a href="<?php echo APP_URL; ?>/register">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1 class="main-title">Dashboard</h1>
            
            <?php if (isset($message)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <div class="dashboard-section">
                <h2 class="section-title">Your Resumes</h2>
                <?php if (empty($userResumes)): ?>
                    <p>You haven't created any resumes yet. <a href="<?php echo APP_URL; ?>/create-cv">Create one now!</a></p>
                <?php else: ?>
                    <ul class="resume-list">
                        <?php foreach ($userResumes as $resume): ?>
                            <li>
                                <div class="resume-info">
                                    <span class="resume-title">CV created on <?php echo date("F j, Y", strtotime($resume['updated_at'])); ?></span>
                                    <span class="resume-template">Template ID: <?php echo htmlspecialchars($resume['template_id']); ?></span>
                                </div>
                                <div class="resume-actions">
                                    <a href="<?php echo APP_URL; ?>/create-cv?id=<?php echo $resume['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="<?php echo APP_URL; ?>/export-pdf?id=<?php echo $resume['id']; ?>" class="btn btn-sm btn-success" target="_blank"><i class="fas fa-file-pdf"></i> PDF</a>
                                    <a href="<?php echo APP_URL; ?>/delete-cv?id=<?php echo $resume['id']; ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Account Settings Section could be added here -->

        </div>
    </main>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(APP_NAME); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>