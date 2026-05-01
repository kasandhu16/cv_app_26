-- Database Schema for ATS-Friendly CV Creator
-- MySQL Database

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Resumes table (supports both registered users and guests)
CREATE TABLE resumes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,  -- NULL for guest users
    session_id VARCHAR(255) NULL,  -- For tracking guest sessions
    data JSON NOT NULL,  -- CV data stored as JSON (use TEXT if JSON not supported)
    template_id INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Payments table for premium features
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    stripe_payment_id VARCHAR(255) UNIQUE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'USD',
    status VARCHAR(20) NOT NULL, -- 'pending', 'completed', 'failed', 'refunded'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Premium features access
CREATE TABLE premium_access (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    feature_type VARCHAR(50) NOT NULL, -- 'pdf_export', 'premium_templates', etc.
    granted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_feature (user_id, feature_type)
);

-- Blog posts table
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    meta_description TEXT,
    keywords VARCHAR(255),
    published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert demo blog posts
INSERT INTO blog_posts (title, slug, content, meta_description, keywords) VALUES
('ATS Resume Tips: How to Beat Applicant Tracking Systems', 'ats-resume-tips',
'<h2>Understanding ATS Systems</h2>
<p>Applicant Tracking Systems (ATS) are software applications used by employers to filter and rank job applications. These systems scan resumes for keywords, skills, and qualifications that match the job description.</p>

<h2>Key Tips for ATS-Friendly Resumes</h2>
<ul>
<li>Use standard fonts and formatting</li>
<li>Include relevant keywords from the job posting</li>
<li>Use simple section headers</li>
<li>Avoid tables, graphics, and complex layouts</li>
<li>Use full forms instead of abbreviations initially</li>
</ul>

<h2>Common ATS Pitfalls</h2>
<p>Many resumes get rejected because they use fancy formatting that ATS can\'t read. Stick to clean, text-based layouts.</p>',
'Learn how to optimize your resume for Applicant Tracking Systems with these essential tips.',
'ATS, resume, job application, keywords, applicant tracking system'),

('Keyword Optimization: Making Your Resume Stand Out', 'keyword-optimization',
'<h2>Why Keywords Matter</h2>
<p>Keywords are the terms employers use to describe the skills, experience, and qualifications they\'re looking for. ATS systems search for these exact terms in your resume.</p>

<h2>How to Find the Right Keywords</h2>
<ul>
<li>Read the job description carefully</li>
<li>Note repeated terms and phrases</li>
<li>Research industry-specific terminology</li>
<li>Use tools like job posting analysis</li>
</ul>

<h2>Strategic Keyword Placement</h2>
<p>Place important keywords in your summary, skills section, and work experience descriptions. Don\'t overstuff - use them naturally.</p>

<h2>Balancing Keywords and Readability</h2>
<p>While keywords are crucial for ATS, your resume must still be readable for human recruiters. Find the right balance.</p>',
'Master keyword optimization techniques to ensure your resume passes ATS filters and reaches hiring managers.',
'keywords, resume optimization, ATS, job search, skills');

-- Create indexes for better performance
CREATE INDEX idx_resumes_user_id ON resumes(user_id);
CREATE INDEX idx_resumes_session_id ON resumes(session_id);
CREATE INDEX idx_blog_posts_slug ON blog_posts(slug);
CREATE INDEX idx_payments_user_id ON payments(user_id);
CREATE INDEX idx_payments_status ON payments(status);
CREATE INDEX idx_premium_access_user_id ON premium_access(user_id);
CREATE INDEX idx_premium_access_feature ON premium_access(feature_type);