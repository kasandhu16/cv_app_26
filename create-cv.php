<?php
require_once 'php/config.php';
require_once 'php/functions.php';
require_once 'php/cv.php';

// Initialize session for guests
if (!isset($_SESSION['guest_session'])) {
    $_SESSION['guest_session'] = generateRandomString(32);
}

$userId = getCurrentUserId();
$sessionId = $_SESSION['guest_session'];

$cvData = getCVDataStructure();
$templateId = 1;
$resumeId = null;

// Load existing resume if editing
if (isset($_GET['id'])) {
    $resume = getResume($_GET['id'], $userId);
    if ($resume) {
        $cvData = json_decode($resume['data'], true);
        $templateId = $resume['template_id'];
        $resumeId = $resume['id'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request';
    } else {
        $cvData = processCVData($_POST);
        $templateId = (int)($_POST['template_id'] ?? 1);

        if (validateCVData($cvData)) {
            $savedId = saveResume($cvData, $templateId, $userId, $sessionId);
            if ($savedId) {
                $message = 'CV saved successfully!';
                $resumeId = $savedId;
                // Redirect to the same page with the ID to avoid form resubmission
                header("Location: " . APP_URL . "/create-cv?id=" . $savedId . "&save_success=1");
                exit;
            }
             else {
                $error = 'Failed to save CV';
            }
        } else {
            $error = 'Please fill in all required fields';
        }
    }
}

if (isset($_GET['save_success'])){
    $message = 'CV saved successfully!';
}


$pageTitle = 'Create CV - ' . APP_NAME;
$metaDescription = 'Create a professional, ATS-friendly CV with our easy-to-use form and live preview.';
$isPremium = isPremiumUser($userId);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <h1><a href="<?php echo APP_URL; ?>/"> <?php echo htmlspecialchars(APP_NAME); ?></a></h1>
                </div>
                <ul class="nav-menu">
                    <li><a href="<?php echo APP_URL; ?>/">Home</a></li>
                    <li><a href="<?php echo APP_URL; ?>/create-cv" class="active">Create CV</a></li>
                    <li><a href="<?php echo APP_URL; ?>/blog">Blog</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="<?php echo APP_URL; ?>/dashboard">Dashboard</a></li>
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
            <div class="cv-creator">
                <div class="cv-form-section">
                    <h1 class="main-title">Create Your CV</h1>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <?php if (isset($message)): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                    <?php endif; ?>

                    <form id="cv-form" method="post" action="<?php echo APP_URL; ?>/create-cv<?php echo $resumeId ? '?id=' . $resumeId : ''; ?>">
                        <?php echo csrfTokenInput(); ?>

                        <div class="form-section">
                            <h2 class="section-title">Template Selection</h2>
                            <div class="template-selector">
                                <div class="template-category">
                                    <h3>Free Templates</h3>
                                    <div class="template-list">
                                        <label>
                                            <input type="radio" name="template_id" value="1" <?php echo $templateId == 1 ? 'checked' : ''; ?>> 
                                            Professional Classic
                                            <img src="<?php echo APP_URL; ?>/assets/template1_thumb.png" alt="Professional Classic Thumbnail">
                                        </label>
                                        <label>
                                            <input type="radio" name="template_id" value="2" <?php echo $templateId == 2 ? 'checked' : ''; ?>> 
                                            Modern Minimal
                                            <img src="<?php echo APP_URL; ?>/assets/template2_thumb.png" alt="Modern Minimal Thumbnail">
                                        </label>
                                        <label>
                                            <input type="radio" name="template_id" value="3" <?php echo $templateId == 3 ? 'checked' : ''; ?>> 
                                            Creative Design
                                            <img src="<?php echo APP_URL; ?>/assets/template3_thumb.png" alt="Creative Design Thumbnail">
                                        </label>
                                    </div>
                                </div>

                                <div class="template-category premium">
                                    <h3><i class="fas fa-crown"></i> Premium Templates</h3>
                                    <div class="template-list">
                                        <?php for ($i = 4; $i <= 12; $i++): ?>
                                            <label class="premium-template <?php if (!$isPremium) echo 'locked'; ?>">
                                                <input type="radio" name="template_id" value="<?php echo $i; ?>" <?php echo $templateId == $i ? 'checked' : ''; ?> <?php if (!$isPremium) echo 'disabled'; ?>>
                                                Template Name <?php echo $i; ?>
                                                <img src="<?php echo APP_URL; ?>/assets/template<?php echo $i; ?>_thumb.png" alt="Template <?php echo $i; ?> Thumbnail">
                                                <?php if (!$isPremium): ?>
                                                    <div class="lock-overlay">
                                                        <i class="fas fa-lock"></i>
                                                        <a href="<?php echo APP_URL; ?>/payment?feature=premium_templates" class="btn btn-premium-unlock">Unlock</a>
                                                    </div>
                                                <?php endif; ?>
                                            </label>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ... other form sections ... -->

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save CV</button>
                            <?php if ($resumeId):
                                $isFreeTemplate = in_array($templateId, [1, 2, 3]);
                                $canExport = $isFreeTemplate || $isPremium;
                            ?>
                                <?php if ($canExport): ?>
                                    <a href="<?php echo APP_URL; ?>/export-pdf?id=<?php echo $resumeId; ?>" class="btn btn-success" target="_blank"><i class="fas fa-file-pdf"></i> Export PDF</a>
                                <?php else: ?>
                                    <a href="<?php echo APP_URL; ?>/payment.php?feature=pdf_export&resume_id=<?php echo $resumeId; ?>" class="btn btn-premium">
                                        <i class="fas fa-crown"></i> Unlock PDF Export
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="cv-preview-section">
                    <h2 class="section-title">Live Preview</h2>
                    <div id="cv-preview">
                        <!-- Preview will be loaded here -->
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

    <script>
        const APP_URL = '<?php echo APP_URL; ?>';
        const isUserPremium = <?php echo json_encode($isPremium); ?>;
    </script>
    <script src="<?php echo APP_URL; ?>/js/app.js"></script>
    <script src="<?php echo APP_URL; ?>/js/form.js"></script>
</body>
</html>