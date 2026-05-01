<?php
require_once 'php/config.php';
require_once 'php/auth.php';
require_once 'php/functions.php';

if (!isLoggedIn()) {
    redirect('/login');
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request';
    } else {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_new_password'] ?? '';

        if ($newPassword !== $confirmPassword) {
            $error = 'New passwords do not match';
        } else {
            $result = updateUserPassword($currentPassword, $newPassword);
            if ($result['success']) {
                $message = 'Password updated successfully';
            } else {
                $error = $result['error'];
            }
        }
    }
}

$user = getCurrentUser();
$resumes = getUserResumes($user['id']);

$pageTitle = 'Dashboard - ' . APP_NAME;
$metaDescription = 'Manage your CVs and account settings.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
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
                    <li><a href="<?php echo APP_URL; ?>/dashboard" class="active">Dashboard</a></li>
                    <li><a href="<?php echo APP_URL; ?>/login?logout=1">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="dashboard">
                <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>

                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($message): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>

                <div class="dashboard-section">
                    <h2>Your CVs</h2>
                    <a href="<?php echo APP_URL; ?>/create-cv" class="btn btn-primary">Create New CV</a>

                    <?php if (empty($resumes)): ?>
                        <p>You haven't created any CVs yet. <a href="/create-cv">Create your first CV</a>.</p>
                    <?php else: ?>
                        <div class="resumes-list">
                            <?php foreach ($resumes as $resume): ?>
                                <div class="resume-card">
                                    <div class="resume-info">
                                        <h3><?php echo htmlspecialchars(json_decode($resume['data'], true)['personal_info']['full_name'] ?? 'Untitled CV'); ?></h3>
                                        <p>Template: <?php echo htmlspecialchars(getTemplateName($resume['template_id'])); ?></p>
                                        <p>Last updated: <?php echo date('M j, Y', strtotime($resume['updated_at'])); ?></p>
                                    </div>
                                    <div class="resume-actions">
                                        <a href="<?php echo APP_URL; ?>/create-cv?id=<?php echo $resume['id']; ?>" class="btn btn-secondary">Edit</a>
                                        <?php if (hasPremiumAccess($user['id'], 'pdf_export')): ?>
                                            <a href="<?php echo APP_URL; ?>/export-pdf?id=<?php echo $resume['id']; ?>" class="btn btn-primary" target="_blank">Download PDF</a>
                                        <?php else: ?>
                                            <a href="<?php echo APP_URL; ?>/payment.php?feature=pdf_export&resume_id=<?php echo $resume['id']; ?>" class="btn btn-premium">
                                                <i class="fas fa-crown"></i> Unlock PDF ($2)
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="dashboard-section">
                    <h2>Account Settings</h2>
                    <div class="account-info">
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Member since:</strong> <?php echo date('M j, Y', strtotime($user['created_at'])); ?></p>
                    </div>
                    <button class="btn btn-secondary" onclick="togglePasswordForm()">Change Password</button>

                    <div id="password-form" style="display: none;">
                        <form method="post" action="<?php echo APP_URL; ?>/dashboard" style="margin-top: 1rem;">
                            <?php echo csrfTokenInput(); ?>
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" id="current_password" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" id="new_password" name="new_password" required minlength="8">
                            </div>
                            <div class="form-group">
                                <label for="confirm_new_password">Confirm New Password</label>
                                <input type="password" id="confirm_new_password" name="confirm_new_password" required minlength="8">
                            </div>
                            <button type="submit" name="change_password" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(APP_NAME); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/app.js"></script>
    <script>
        function togglePasswordForm() {
            const form = document.getElementById('password-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>