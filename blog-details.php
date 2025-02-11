<?php
require_once 'config.php';

try {
    if (!isset($_GET['slug'])) {
        throw new Exception('Blog post not found');
    }

    $slug = mysqli_real_escape_string($conn, $_GET['slug']);
    $sql = "SELECT b.*, c.name as category_name, c.slug as category_slug 
            FROM blog b 
            LEFT JOIN blog_categories c ON b.category_id = c.id 
            WHERE b.slug = '$slug'";
    
    $result = mysqli_query($conn, $sql);
    
    if (!$result || mysqli_num_rows($result) === 0) {
        throw new Exception('Blog post not found');
    }

    $post = mysqli_fetch_assoc($result);
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title'] ?? 'Blog Post Not Found'); ?> - WeBase LLC</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/blog.css">
    <link rel="stylesheet" href="css/blog-details.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header>
        <div class="top-navbar">
            <div class="top-navbar-left">
                <span>📍 Address: 2234 N federal  HWY 1421 Boca Raton Fl 33431</span>
                <span>📞 Contact: +1-315-465-1248</span>
            </div>
            <div class="top-navbar-right">
                <a href="https://www.facebook.com/profile.php?id=61573127546160" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <nav class="navbar">
            <div class="nav-left">
                <button class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="logo">
                    <a href="index.html">
                        <img src="/src/images/logo-light.png" alt="WebaseLLC  Logo">
                    </a>
                </div>
                  <!-- Update the nav-links section in the header -->
            <div class="nav-links">
                <ul>
                    <li>
                        <a href="services.html">SERVICES</a>

                    </li>

                    <li>
                        <a href="products.html">PRODUCTS</a>
                    </li>
                    <li><a href="portfolio.html">PORTFOLIO</a></li>
                    <li><a href="blog.html">BLOG</a></li>
                    <li><a href="about-us.html">ABOUT US</a></li>
                    <li><a href="contact-us.html">CONTACT US</a></li>
                </ul>
            </div>

            </div>
           

          
            <div class="contact-buttons">
                
                <a href="#" class="callback-btn">GET A CALL BACK</a>
            </div>
        </nav>
    </header>

    
    <div class="sidebar">
        <button class="sidebar-close">
            <i class="fas fa-times"></i>
        </button>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="portfolio.html">Portfolio</a></li>
            <li><a href="blog.html">Blog</a></li>
            <li><a href="about-us.html">ABOUT US</a></li>
            <li><a href="contact-us.html">Contact Us</a></li>
        </ul>
    </div>
    <div class="overlay"></div>

    <?php if (isset($error)): ?>
        <div class="error-container">
            <div class="container">
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <p><?php echo htmlspecialchars($error); ?></p>
                    <a href="blog.html" class="back-to-blog">Back to Blog</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <article class="blog-detail">
            <div class="blog-hero" style="background-image: linear-gradient(rgba(30, 55, 153, 0.9), rgba(30, 55, 153, 0.9)), url('<?php echo htmlspecialchars($post['image_path']); ?>')">
                <div class="container">
                    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
                    <div class="blog-meta">
                        <span><i class="far fa-user"></i> <?php echo htmlspecialchars($post['author']); ?></span>
                        <span><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                        <span><i class="far fa-folder"></i> <?php echo htmlspecialchars($post['category_name']); ?></span>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="blog-content">
                    <?php if (!empty($post['image_path'])): ?>
                        <div class="featured-image">
                            <img src="<?php echo htmlspecialchars($post['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($post['title']); ?>"
                                 onerror="this.src='src/images/blog/default-blog.jpg'">
                        </div>
                    <?php endif; ?>

                    <div class="content-wrapper">
                        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                    </div>

                    <div class="blog-footer">
                        <div class="share-buttons">
                            <span>Share this post:</span>
                            <a href="https://twitter.com/share?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($post['title']); ?>" 
                               target="_blank" class="twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                               target="_blank" class="facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&title=<?php echo urlencode($post['title']); ?>" 
                               target="_blank" class="linkedin">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    <?php endif; ?>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <img src="/src/images/logo-dark.png" alt="WebaseLLC Logo" class="footer-logo">
                    <p>We are a top website development and design company in Canada & the USA, offering expert web development, mobile app solutions, and digital marketing with over 20 years of experience.</p>

                    <div class="social-icons">
                        <a href="https://www.facebook.com/profile.php?id=61573127546160" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="footer-column">
              <h3>Quick Links</h3>
              <ul>
                <li><a href="/">Home</a></li>
                <li><a href="portfolio.html"></a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="/portfolio.html">Portfolio</a></li>
                <li><a href="/blog.html">Blog</a></li>
                <li><a href="/contact-us.html">Contact Us</a></li>
              </ul>
            </div>

                <div class="footer-column">
                    <h3>Our Services</h3>
                    <ul>
                        <li><a href="/services/web-design">Web Design</a></li>
                        <li><a href="/services/web-development">Web Development</a></li>
                        <li><a href="/services/mobile-app-development">Mobile App Development</a></li>
                        <li><a href="/services/ecommerce">E-commerce Solutions</a></li>
                        <li><a href="/services/digital-marketing">Digital Marketing</a></li>
                        <li><a href="/services/seo">SEO Services</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <p>📍 2234 N federal  HWY 1421 Boca Raton Fl 33431</p>
                    <p>📞 +1-315-465-1248</p>
                    <p>✉️ info@webasellc.com</p>
                    <a href="/contact" class="cta-button">Get a Free Quote</a>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <span id="current-year"></span> WebaseLLC. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="js/main.js"></script>
</body>
</html> 