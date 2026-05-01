<?php
require_once 'php/config.php';
require_once 'php/auth.php';

$pageTitle = 'Register - ' . APP_NAME;
$metaDescription = 'Create a free account to save and manage your CVs.';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request';
    } else {
        $username = sanitizeInput($_POST['username'] ?? '');
        $email = sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($password !== $confirmPassword) {
            $error = 'Passwords do not match';
        } else {
            $result = registerUser($username, $email, $password);
            if ($result['success']) {
                redirect('/dashboard');
            } else {
                $error = $result['error'];
            }
        }
    }
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
                    <h1><a href="/"><?php echo htmlspecialchars(APP_NAME); ?></a></h1>
                </div>
                <ul class="nav-menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/create-cv">Create CV</a></li>
                    <li><a href="/blog">Blog</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="auth-form">
                <h1>Register</h1>

                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($message): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>

                <form method="post" action="/register">
                    <?php echo csrfTokenInput(); ?>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required minlength="3" maxlength="50">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required minlength="8">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>

                <p class="auth-links">
                    Already have an account? <a href="/login">Login here</a><br>
                    Or <a href="/create-cv">continue as guest</a>
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