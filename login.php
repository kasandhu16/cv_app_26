<?php
require_once 'php/config.php';
require_once 'php/auth.php';

$pageTitle = 'Login - ' . APP_NAME;
$metaDescription = 'Login to your account to save and manage your CVs.';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request';
    } else {
        $email = sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $result = loginUser($email, $password);
        if ($result['success']) {
            redirect('/dashboard');
        } else {
            $error = $result['error'];
        }
    }
}

if (isset($_GET['logout'])) {
    logoutUser();
    redirect('/');
}
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
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="auth-form">
                <h1>Login</h1>

                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($message): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>

                <form method="post" action="<?php echo APP_URL; ?>/login">
                    <?php echo csrfTokenInput(); ?>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

                <p class="auth-links">
                    Don't have an account? <a href="<?php echo APP_URL; ?>/register">Register here</a><br>
                    Or <a href="<?php echo APP_URL; ?>/create-cv">continue as guest</a>
                </p>
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
</body>
</html>