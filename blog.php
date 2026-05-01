<?php
require_once 'php/config.php';
require_once 'php/functions.php';

$pageTitle = 'Blog - ATS-Friendly CV Creator';
$metaDescription = 'Learn about ATS resume tips, keyword optimization, and best practices for creating resumes that pass Applicant Tracking Systems.';

$posts = getPublishedBlogPosts();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <meta name="keywords" content="ATS, resume tips, job search, Applicant Tracking System, CV optimization">
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
                    <li><a href="/blog" class="active">Blog</a></li>
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
        <div class="container">
            <section class="blog-header">
                <h1>ATS Resume Blog</h1>
                <p>Tips, tricks, and best practices for creating resumes that beat Applicant Tracking Systems</p>
            </section>

            <div class="blog-posts">
                <?php if (empty($posts)): ?>
                    <p>No blog posts available yet. Check back soon!</p>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <article class="blog-post-card">
                            <h2><a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>"><?php echo htmlspecialchars($post['title']); ?></a></h2>
                            <div class="meta">
                                <time datetime="<?php echo htmlspecialchars($post['published_at']); ?>">
                                    <?php echo date('F j, Y', strtotime($post['published_at'])); ?>
                                </time>
                            </div>
                            <p><?php echo htmlspecialchars($post['meta_description']); ?></p>
                            <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" class="btn btn-primary">Read More</a>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
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