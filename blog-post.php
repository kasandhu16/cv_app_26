<?php
require_once 'php/config.php';
require_once 'php/functions.php';

$slug = $_GET['slug'] ?? '';
$post = getBlogPostBySlug($slug);

if (!$post) {
    http_response_code(404);
    echo 'Blog post not found';
    exit;
}

$pageTitle = htmlspecialchars($post['title']) . ' - ' . APP_NAME;
$metaDescription = htmlspecialchars($post['meta_description']);
$keywords = htmlspecialchars($post['keywords']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $metaDescription; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Open Graph meta tags for social sharing -->
    <meta property="og:title" content="<?php echo $pageTitle; ?>">
    <meta property="og:description" content="<?php echo $metaDescription; ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo APP_URL; ?>/blog/<?php echo htmlspecialchars($post['slug']); ?>">
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
            <article class="blog-post-content">
                <header class="post-header">
                    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
                    <div class="post-meta">
                        <time datetime="<?php echo htmlspecialchars($post['published_at']); ?>">
                            Published on <?php echo date('F j, Y', strtotime($post['published_at'])); ?>
                        </time>
                    </div>
                </header>

                <div class="post-content">
                    <?php echo $post['content']; ?>
                </div>

                <footer class="post-footer">
                    <div class="post-tags">
                        <?php if (!empty($post['keywords'])): ?>
                            <strong>Tags:</strong>
                            <?php
                            $tags = explode(',', $post['keywords']);
                            foreach ($tags as $tag):
                            ?>
                                <span class="tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="post-navigation">
                        <a href="/blog" class="btn btn-secondary">&larr; Back to Blog</a>
                        <a href="/create-cv" class="btn btn-primary">Create Your CV</a>
                    </div>
                </footer>
            </article>
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