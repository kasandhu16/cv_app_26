<?php
require_once 'php/config.php';
require_once 'php/functions.php';

$pageTitle = 'ATS-Friendly CV Creator - Create Professional Resumes';
$metaDescription = 'Create ATS-friendly resumes with our free online CV creator. Multiple templates, live preview, and PDF export. Beat applicant tracking systems.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <meta name="keywords" content="CV creator, resume builder, ATS-friendly, job application, PDF export">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <h1><?php echo htmlspecialchars(APP_NAME); ?></h1>
                </div>
                <ul class="nav-menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/create-cv">Create CV</a></li>
                    <li><a href="/blog">Blog</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="/dashboard">Dashboard</a></li>
                        <li><a href="/login?logout=1">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/login">Login</a></li>
                        <li><a href="/register">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h1>Create ATS-Friendly Resumes</h1>
                <p>Build professional CVs that pass Applicant Tracking Systems. Multiple templates, live preview, and high-quality PDF export.</p>
                <div class="hero-buttons">
                    <a href="/create-cv" class="btn btn-primary">Create Your CV</a>
                    <a href="/blog" class="btn btn-secondary">Learn More</a>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <h2>Why Choose Our CV Creator?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <h3>ATS-Friendly</h3>
                        <p>Our templates are designed to work with Applicant Tracking Systems, ensuring your resume gets seen by recruiters.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Multiple Templates</h3>
                        <p>Choose from professional, modern, and creative templates. More templates coming soon!</p>
                    </div>
                    <div class="feature-card">
                        <h3>Live Preview</h3>
                        <p>See your CV update in real-time as you fill in your information.</p>
                    </div>
                    <div class="feature-card">
                        <h3>PDF Export</h3>
                        <p>Export your CV as a high-quality, vector-based PDF that's perfect for job applications.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Free to Use</h3>
                        <p>No hidden fees or premium subscriptions. Create unlimited CVs for free.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Mobile Friendly</h3>
                        <p>Responsive design works perfectly on all devices, from desktop to mobile.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="templates-preview">
            <div class="container">
                <h2>Professional Templates</h2>
                <div class="templates-grid">
                    <div class="template-card">
                        <div class="template-preview">
                            <!-- Template 1 preview would go here -->
                            <div class="template-placeholder">Professional Template</div>
                        </div>
                        <h3>Professional</h3>
                        <p>Clean and traditional design perfect for corporate positions.</p>
                    </div>
                    <div class="template-card">
                        <div class="template-preview">
                            <div class="template-placeholder">Modern Template</div>
                        </div>
                        <h3>Modern</h3>
                        <p>Contemporary design with a fresh look for tech and creative industries.</p>
                    </div>
                    <div class="template-card">
                        <div class="template-preview">
                            <div class="template-placeholder">Creative Template</div>
                        </div>
                        <h3>Creative</h3>
                        <p>Eye-catching design for artistic and design-related positions.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta">
            <div class="container">
                <h2>Ready to Create Your Perfect CV?</h2>
                <p>Join thousands of job seekers who have successfully landed their dream jobs with our ATS-friendly CV creator.</p>
                <a href="/create-cv" class="btn btn-primary btn-large">Get Started Now</a>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php echo htmlspecialchars(APP_NAME); ?></h3>
                    <p>Create professional, ATS-friendly resumes with our free online tool.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="/create-cv">Create CV</a></li>
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="/login">Login</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="/blog/ats-resume-tips">ATS Resume Tips</a></li>
                        <li><a href="/blog/keyword-optimization">Keyword Optimization</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(APP_NAME); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/app.js"></script>
</body>
</html>