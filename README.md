# ATS-Friendly CV Creator

A complete, production-ready web application for creating ATS-friendly CVs with user registration, multiple templates, live preview, and PDF export.

## Features

- **User Authentication**: Optional registration/login with guest mode support
- **CV Creation Form**: Comprehensive form for personal info, work experience, education, skills, languages, and certifications
- **Multiple Templates**: 3 professional templates (Professional, Modern, Creative) with extensible architecture
- **Live Preview**: Real-time CV preview as users fill out the form
- **PDF Export**: Server-side PDF generation using Dompdf for vector-based, selectable text PDFs
- **SEO Blog**: 2 demo articles about ATS resume tips and keyword optimization
- **Responsive Design**: Mobile-first, clean modern UI
- **Security**: XSS prevention, SQL injection protection, CSRF tokens, secure sessions

## Tech Stack

- **Backend**: PHP 7.4+ (vanilla, no frameworks)
- **Frontend**: JavaScript (vanilla), HTML5, CSS3
- **Database**: MySQL 5.7+
- **PDF Generation**: Dompdf library
- **Server**: Apache with mod_rewrite

## Installation

### 1. Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite enabled
- Composer (for Dompdf installation)

### 2. Database Setup

1. Create a MySQL database named `cv_creator`
2. Import the database schema from `db_schema.sql`
3. Update database credentials in `php/config.php`

### 3. Install Dependencies

```bash
# Install Dompdf for PDF generation
composer require dompdf/dompdf
```

Or download Dompdf manually and place it in a `vendor` directory.

### 4. Web Server Configuration

1. Point your web server document root to the project directory
2. Ensure `.htaccess` is enabled (Apache)
3. Make sure the following directories are writable by the web server:
   - `uploads/`
   - `pdf-cache/`

### 5. Configuration

Update `php/config.php` with your settings:
- Database credentials
- Application URL
- Upload directories

## File Structure

```
/
├── index.php              # Main router
├── home.php               # Landing page
├── login.php              # Login page
├── register.php           # Registration page
├── dashboard.php          # User dashboard
├── create-cv.php          # CV creation form
├── preview.php            # Live preview handler
├── export-pdf.php         # PDF export handler
├── blog.php               # Blog listing
├── blog-post.php          # Individual blog posts
├── .htaccess              # URL rewriting
├── db_schema.sql          # Database schema
├── css/
│   ├── style.css          # Main styles
│   ├── templates.css      # CV template styles
│   └── responsive.css     # Responsive styles
├── js/
│   ├── app.js             # Main app logic
│   └── form.js            # Form handling
├── php/
│   ├── config.php         # Configuration
│   ├── functions.php      # Utility functions
│   ├── auth.php           # Authentication
│   ├── cv.php             # CV handling
│   └── blog.php           # Blog functions (placeholder)
├── templates/
│   ├── template1.php      # Professional template
│   ├── template2.php      # Modern template
│   └── template3.php      # Creative template
├── uploads/               # User file uploads
├── pdf-cache/             # Cached PDFs
└── blog-posts/            # Static blog content
```

## Security Features

- **SQL Injection Prevention**: All database queries use prepared statements
- **XSS Protection**: All output is escaped with `htmlspecialchars()`
- **CSRF Protection**: CSRF tokens on all forms
- **Session Security**: Secure session configuration
- **Input Validation**: Server-side validation for all user inputs
- **File Upload Security**: Restricted file types and secure upload handling

## Usage

1. **Landing Page**: Visit the root URL to see the homepage
2. **Create CV**: Click "Create Your CV" to start building a resume
3. **Guest Mode**: Users can create CVs without registering
4. **Registration**: Optional user accounts for saving multiple CVs
5. **Templates**: Choose from 3 different CV templates
6. **Live Preview**: See changes instantly in the preview pane
7. **PDF Export**: Download professional PDF versions
8. **Blog**: Read ATS tips and resume optimization advice

## Adding New Templates

1. Create a new template file in `templates/templateX.php`
2. Add template option to the form in `create-cv.php`
3. Add CSS styles in `css/templates.css`
4. Update the `getTemplateName()` function in `php/functions.php`

## Blog Management

Blog posts are stored in the database. To add new posts:

1. Insert into the `blog_posts` table
2. Use the slug for clean URLs
3. Content supports HTML formatting

## Performance Optimizations

- **CSS/JS Minification**: Ready for production minification
- **Image Optimization**: Use optimized images
- **Caching**: PDF caching system implemented
- **CDN Ready**: Static assets can be served from CDN
- **Database Indexing**: Optimized database queries

## Browser Support

- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+

## Contributing

1. Follow PHP PSR standards
2. Use meaningful variable names
3. Add comments for complex logic
4. Test on multiple browsers
5. Validate HTML/CSS

## License

This project is open source and free to use.

## Support

For issues or questions, please check the code comments and documentation within the files.