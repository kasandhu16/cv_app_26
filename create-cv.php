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
            } else {
                $error = 'Failed to save CV';
            }
        } else {
            $error = 'Please fill in all required fields';
        }
    }
}

$pageTitle = 'Create CV - ' . APP_NAME;
$metaDescription = 'Create a professional, ATS-friendly CV with our easy-to-use form and live preview.';
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
                    <h1>Create Your CV</h1>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <?php if (isset($message)): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                    <?php endif; ?>

                    <form id="cv-form" method="post" action="<?php echo APP_URL; ?>/create-cv<?php echo $resumeId ? '?id=' . $resumeId : ''; ?>">
                        <?php echo csrfTokenInput(); ?>

                        <div class="form-section">
                            <h2>Template Selection</h2>
                            <div class="template-selector">
                                <!-- Free Templates -->
                                <div class="template-category">
                                    <h3>Free Templates</h3>
                                    <label><input type="radio" name="template_id" value="1" <?php echo $templateId == 1 ? 'checked' : ''; ?>> Professional Classic</label>
                                    <label><input type="radio" name="template_id" value="2" <?php echo $templateId == 2 ? 'checked' : ''; ?>> Modern Minimal</label>
                                    <label><input type="radio" name="template_id" value="3" <?php echo $templateId == 3 ? 'checked' : ''; ?>> Creative Design</label>
                                </div>

                                <!-- Premium Templates -->
                                <div class="template-category premium">
                                    <h3><i class="fas fa-crown"></i> Premium Templates</h3>
                                    <label class="premium-template">
                                        <input type="radio" name="template_id" value="4" <?php echo $templateId == 4 ? 'checked' : ''; ?>>
                                        Executive Suite
                                        <span class="premium-badge">Premium</span>
                                    </label>
                                    <label class="premium-template">
                                        <input type="radio" name="template_id" value="5" <?php echo $templateId == 5 ? 'checked' : ''; ?>>
                                        Tech Innovator
                                        <span class="premium-badge">Premium</span>
                                    </label>
                                    <label class="premium-template">
                                        <input type="radio" name="template_id" value="6" <?php echo $templateId == 6 ? 'checked' : ''; ?>>
                                        Creative Artist
                                        <span class="premium-badge">Premium</span>
                                    </label>
                                    <label class="premium-template">
                                        <input type="radio" name="template_id" value="7" <?php echo $templateId == 7 ? 'checked' : ''; ?>>
                                        Business Professional
                                        <span class="premium-badge">Premium</span>
                                    </label>
                                    <label class="premium-template">
                                        <input type="radio" name="template_id" value="8" <?php echo $templateId == 8 ? 'checked' : ''; ?>>
                                        Academic Scholar
                                        <span class="premium-badge">Premium</span>
                                    </label>
                                    <label class="premium-template">
                                        <input type="radio" name="template_id" value="9" <?php echo $templateId == 9 ? 'checked' : ''; ?>>
                                        Startup Founder
                                        <span class="premium-badge">Premium</span>
                                    </label>
                                    <label class="premium-template">
                                        <input type="radio" name="template_id" value="10" <?php echo $templateId == 10 ? 'checked' : ''; ?>>
                                        Design Expert
                                        <span class="premium-badge">Premium</span>
                                    </label>
                                    <label class="premium-template">
                                        <input type="radio" name="template_id" value="11" <?php echo $templateId == 11 ? 'checked' : ''; ?>>
                                        Marketing Pro
                                        <span class="premium-badge">Premium</span>
                                    </label>
                                    <label class="premium-template">
                                        <input type="radio" name="template_id" value="12" <?php echo $templateId == 12 ? 'checked' : ''; ?>>
                                        Engineering Elite
                                        <span class="premium-badge">Premium</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2>Personal Information</h2>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="full_name">Full Name *</label>
                                    <input type="text" id="full_name" name="personal_info[full_name]" value="<?php echo htmlspecialchars($cvData['personal_info']['full_name'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="personal_info[email]" value="<?php echo htmlspecialchars($cvData['personal_info']['email'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="tel" id="phone" name="personal_info[phone]" value="<?php echo htmlspecialchars($cvData['personal_info']['phone'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="url" id="website" name="personal_info[website]" value="<?php echo htmlspecialchars($cvData['personal_info']['website'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="linkedin">LinkedIn Profile</label>
                                    <input type="url" id="linkedin" name="personal_info[linkedin]" placeholder="https://linkedin.com/in/yourprofile" value="<?php echo htmlspecialchars($cvData['personal_info']['linkedin'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" name="personal_info[address]" rows="2"><?php echo htmlspecialchars($cvData['personal_info']['address'] ?? ''); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="summary">Professional Summary</label>
                                <textarea id="summary" name="personal_info[summary]" rows="4"><?php echo htmlspecialchars($cvData['personal_info']['summary'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2>Work Experience</h2>
                            <div id="work-experience-container">
                                <?php foreach ($cvData['work_experience'] as $index => $exp): ?>
                                    <div class="work-experience-item">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Job Title</label>
                                                <input type="text" name="work_experience[<?php echo $index; ?>][job_title]" value="<?php echo htmlspecialchars($exp['job_title']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Company</label>
                                                <input type="text" name="work_experience[<?php echo $index; ?>][company]" value="<?php echo htmlspecialchars($exp['company']); ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input type="text" name="work_experience[<?php echo $index; ?>][location]" value="<?php echo htmlspecialchars($exp['location']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="month" name="work_experience[<?php echo $index; ?>][start_date]" value="<?php echo htmlspecialchars($exp['start_date']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="month" name="work_experience[<?php echo $index; ?>][end_date]" value="<?php echo htmlspecialchars($exp['end_date']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label><input type="checkbox" name="work_experience[<?php echo $index; ?>][current]" <?php echo $exp['current'] ? 'checked' : ''; ?>> Current</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="work_experience[<?php echo $index; ?>][description]" rows="3"><?php echo htmlspecialchars($exp['description']); ?></textarea>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-work-experience" class="btn btn-secondary">Add Work Experience</button>
                        </div>

                        <div class="form-section">
                            <h2>Education</h2>
                            <div id="education-container">
                                <?php foreach ($cvData['education'] as $index => $edu): ?>
                                    <div class="education-item">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Degree</label>
                                                <input type="text" name="education[<?php echo $index; ?>][degree]" value="<?php echo htmlspecialchars($edu['degree']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>School</label>
                                                <input type="text" name="education[<?php echo $index; ?>][school]" value="<?php echo htmlspecialchars($edu['school']); ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input type="text" name="education[<?php echo $index; ?>][location]" value="<?php echo htmlspecialchars($edu['location']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Graduation Date</label>
                                                <input type="month" name="education[<?php echo $index; ?>][graduation_date]" value="<?php echo htmlspecialchars($edu['graduation_date']); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="education[<?php echo $index; ?>][description]" rows="2"><?php echo htmlspecialchars($edu['description']); ?></textarea>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-education" class="btn btn-secondary">Add Education</button>
                        </div>

                        <div class="form-section">
                            <h2>Skills</h2>
                            <div id="skills-container">
                                <?php foreach ($cvData['skills'] as $index => $skill): ?>
                                    <div class="skill-item">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Skill Name</label>
                                                <input type="text" name="skills[<?php echo $index; ?>][name]" value="<?php echo htmlspecialchars($skill['name']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Level</label>
                                                <select name="skills[<?php echo $index; ?>][level]">
                                                    <option value="Beginner" <?php echo $skill['level'] == 'Beginner' ? 'selected' : ''; ?>>Beginner</option>
                                                    <option value="Intermediate" <?php echo $skill['level'] == 'Intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                                                    <option value="Advanced" <?php echo $skill['level'] == 'Advanced' ? 'selected' : ''; ?>>Advanced</option>
                                                    <option value="Expert" <?php echo $skill['level'] == 'Expert' ? 'selected' : ''; ?>>Expert</option>
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-item">Remove</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="add-skill" class="btn btn-secondary">Add Skill</button>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save CV</button>
                            <?php if ($resumeId): ?>
                                <?php if (hasPremiumAccess($userId, 'pdf_export')): ?>
                                    <a href="<?php echo APP_URL; ?>/export-pdf?id=<?php echo $resumeId; ?>" class="btn btn-success" target="_blank">Export PDF</a>
                                <?php else: ?>
                                    <a href="<?php echo APP_URL; ?>/payment.php?feature=pdf_export&resume_id=<?php echo $resumeId; ?>" class="btn btn-premium">
                                        <i class="fas fa-crown"></i> Unlock PDF Export ($2)
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="cv-preview-section">
                    <h2>Live Preview</h2>
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

    <script src="js/app.js"></script>
    <script src="js/form.js"></script>
</body>
</html>