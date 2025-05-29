<?php
require_once __DIR__ . '/config/db.php';
date_default_timezone_set('Europe/Istanbul'); // veya sunucuna uygun bir timezone

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zera - Supplement Store Themes and Sections</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="nav container">
            <div class="logo">Zera</div>
             <ul class="nav-links">
                <li><a href="#themes">Themes</a></li>
                <li><a href="#sections">Sections</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Niches</a>
                    <ul class="dropdown-menu">
                        <li><a href="niches/supplement.php">Supplement</a></li>
                        <li><a href="niches/clothes.php">Clothes</a></li>
                        <li><a href="niches/cosmetic.php">Cosmetic</a></li>
                        <li><a href="niches/jewelry.php">Jewelry</a></li>
                    </ul>
                </li>
            </ul>
            <div class="nav-actions">
                <a href="auth.php" class="login-icon"><i class="fas fa-user"></i></a>
                <a href="auth.php#register" class="cta-button">Get Started</a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Supplement Store<br>Templates Made Easy</h1>
                <p class="subtitle">Launch your supplement store in minutes with niche-specific Shopify themes and custom sections. No designer or developer needed.</p>
                <div class="hero-features">
                    <div class="feature-item">
                        <div class="feature-icon"></div>
                        <span>Designed for Supplements</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"></div>
                        <span>Ready in Minutes</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"></div>
                        <span>No Coding Required</span>
                    </div>
                </div>
                <div class="hero-cta">
                    <a href="auth.php#register" class="cta-button-large">Build Your Store</a>
                    <p class="cta-subtitle">14-day free trial • No credit card required</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Problem Section -->
    <section class="problem-section">
        <div class="container">
            <h2 class="section-title">Building Supplement Stores Shouldn’t Be This Hard</h2>
            <p class="section-subtitle">Store owners waste weeks with generic themes that don’t convert or expensive agencies.</p>
            <div class="problem-grid">
                <div class="problem-card">
                    <div class="problem-icon">😤</div>
                    <h3>Generic Themes Don’t Convert</h3>
                    <p>Standard Shopify themes aren’t built for supplements. They lack trust elements, ingredient showcases, and health-focused layouts that supplement customers expect.</p>
                </div>
                <div class="problem-card">
                    <div class="problem-icon">💸</div>
                    <h3>Expensive Custom Development</h3>
                    <p>Hiring designers and developers costs $150-$450 and takes weeks. Most supplement store owners can’t afford this upfront expense.</p>
                </div>
                <div class="problem-card">
                    <div class="problem-icon">⏰</div>
                    <h3>Time-Consuming Setup</h3>
                    <p>Even with themes, setting up product pages, trust badges, ingredient sections, and compliance elements takes weeks of trial and error.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Solution Section -->
    <section class="solution-section">
        <div class="container">
            <h2 class="section-title">The Zera Solution</h2>
            <p class="section-subtitle">Niche-focused themes and sections designed exclusively for supplement stores</p>
            <div class="solution-grid">
                <div class="solution-card">
                    <div class="solution-icon">🎨</div>
                    <h3>Supplement-Specific Themes</h3>
                    <p>Pre-built themes with ingredient showcases, trust elements, subscription options, and conversion-driven health-focused layouts.</p>
                </div>
                <div class="solution-card">
                    <div class="solution-icon">🧩</div>
                    <h3>Custom Sections Library</h3>
                    <p>Drag-and-drop sections for ingredient highlights, before/after galleries, testimonials, compliance disclaimers, and subscription upsells.</p>
                </div>
                <div class="solution-card">
                    <div class="solution-icon">⚡</div>
                    <h3>Launch in Minutes</h3>
                    <p>Set up, customize colors and content, and launch. No coding, no designers, no weeks of setup. Your supplement store is ready to sell today.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Preview -->
    <section class="product-preview">
        <div class="container">
            <h2 class="section-title">Designed for Supplement Success</h2>
            <div class="preview-grid">
                <div class="preview-content">
                    <h3>Everything Supplement Stores Need</h3>
                    <p>Our themes include all the sections and features that make supplement stores successful.</p>
                    <ul class="feature-list">
                        <li>Ingredient highlight sections</li>
                        <li>Trust badges and certification displays</li>
                        <li>Before/after transformation galleries</li>
                        <li>Subscription and bundle options</li>
                        <li>FDA compliance disclaimer sections</li>
                        <li>Scientific study references</li>
                        <li>Customer reviews and testimonial layouts</li>
                        <li>Mobile-optimized supplement funnels</li>
                    </ul>
                    <a href="#themes" class="cta-button">Explore Themes</a>
                </div>
                <div class="preview-mockup">
                    <div class="mockup-content">
                        <div class="mockup-header">
                            <div class="mockup-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <div class="mockup-body">
                            <div class="mockup-text">
                                🧬 Supplement Theme Preview<br>
                                📱 Mobile Optimized<br>
                                ⚡ High Conversion<br>
                                🔒 FDA Compliant
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Teaser -->
    <section class="pricing-teaser">
        <div class="container">
            <h2 class="section-title">Simple, Transparent Pricing</h2>
            <div class="pricing-highlight">
                <div class="price-card">
                    <div class="price-badge">Launch Offer</div>
                    <div class="price">$49<span>/theme</span></div>
                    <p>Full supplement theme + all sections</p>
                    <a href="auth.php#register" class="cta-button">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Launch Your Supplement Store?</h2>
            <p>Join hundreds of supplement entrepreneurs choosing Zera to build their successful online stores</p>
            <a href="auth.php#register" class="cta-button-large">Start Your Store Today</a>
            <p class="cta-subtitle">14-day free trial • Cancel anytime</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <div class="logo">Zera</div>
                    <p>Niche-specific Shopify themes for supplement stores</p>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h4>Product</h4>
                        <ul>
                            <li><a href="#themes">Themes</a></li>
                            <li><a href="#sections">Sections</a></li>
                            <li><a href="#pricing">Pricing</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4>Support</h4>
                        <ul>
                            <li><a href="#docs">Documentation</a></li>
                            <li><a href="#help">Help Center</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4>Legal</h4>
                        <ul>
                            <li><a href="#privacy">Privacy</a></li>
                            <li><a href="#terms">Terms</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2025 Zera. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/landing.js"></script>
</body>
</html>