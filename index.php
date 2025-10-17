<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotesNest - Organize Your Knowledge, Effortlessly</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  
    <link rel="stylesheet" href="./assets/landing.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="nav">
            <a href="#" class="logo">
                <i class="fas fa-feather"></i>
                NotesNest
            </a>
            <div class="nav-links">
                <a href="login.php">Login</a>
                <a href="#choice">Features</a>
                <a href="#features">Why NotesNest?</a>
                <a href="#works">How It Works?</a>
                <a href="#footer">contact us</a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id = "hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title"><span class = "span">NotesNest </span>: Where Learning Meets Collaboration</h1>
                <p class="hero-subtitle">
                Share, Request, and Access Notes Anytime, Anywhere – Your Ultimate Study Hub
                </p>
                <a href="signup.php" class="cta-button">
                    Get Started Free
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="hero-image">
                <img src="./assets/web.avif" alt="NotesNest Dashboard" class="dashboard-mockup">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="choice" id="choice">
        <h2 class="section-title">Features</h2>
        <div class="choice-grid">
            <div class="choice-card">
                <i class="fas fa-upload choice-icon"></i>
                <h3 class="choice-title">Secure uploads</h3>
                <p class="choice-description">Files are reviewed before approval.</p>
            </div>
            <div class="choice-card">
                <i class="fas fa-hand-paper choice-icon"></i>
                <h3 class="choice-title">Easy Requests</h3>
                <p class="choice-description">See what notes others need and contribute.</p>
            </div>
            <div class="choice-card">
                <i class="fas fa-filter choice-icon"></i>
                <h3 class="choice-title">
                Search Filters</h3>
                <p class="choice-description">Quickly find relevant notes.</p>
            </div>
          </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2 class="feature-title_1">Why Choose NotesNest?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-gift feature-icon"></i>
                <h3 class="feature-title">Free & easy file sharing.</h3>
                <p class="feature-description">Upload and share notes effortlessly </p>
            </div>
            <div class="feature-card">
                <i class="fas fa-award feature-icon"></i>
                <h3 class="feature-title">Request feature for missing notes.</h3>
                <p class="feature-description"> Ask for study materials you need</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-check-circle feature-icon"></i>
                <h3 class="feature-title">Admin-approved, quality content.</h3>
                <p class="feature-description">Access high-quality, verified notes</p>
            </div>
        </div>
    </section>

        <!-- how it works -->
        <section class="works" id="works">
        <h2 class="section-title">How It Works?</h2>
        <div class="works-grid">
            <div class="works-card">
                <i class="fas fa-user works-icon"></i>
                <h3 class="works-title">Signup/Login</h3>
                <p class="works-description">Access your personalized dashboard</p>
            </div>
            <div class="works-card">
                <i class="fas fa-upload works-icon"></i>
                <h3 class="works-title">Upload/Request</h3>
                <p class="works-description">Share notes or request missing ones</p>
            </div>
            <div class="works-card">
                <i class="fas fa-download works-icon"></i>
                <h3 class="works-title">Download</h3>
                <p class="works-description">Get approved study materials easily</p>
            </div>
        </div>
    </section>


    <!-- footer -->
    <footer class="site-footer" id="footer">
    <div class="container">
        <div class="footer-content">
            <!-- About Section -->
            <div class="footer-section">
                <h3>About NotesNest</h3>
                <p>NotesNest is a platform designed to make sharing and requesting study materials easy for students. Our mission is to create an organized and accessible learning environment.</p>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#choice">Features</a></li>
                    <li><a href="#features">Why NotesNest</a></li>
                    <li><a href="#contact">Contact us</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-section">
                <h3>Contact Us</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Andhra Polytechnic,Kakinada</li>
                    <li><i class="fas fa-phone"></i> +91 8309802458 , +91 9032408968</li>
                    <li><i class="fas fa-envelope"></i>notesnest3064@gmail.com </li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-links">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2025 NotesNest. All rights reserved.</p>
            <p>Designed with <i class="fas fa-heart"></i> by Quantum hero & Darklord</p>
        </div>
    </div>
</footer>

    <!-- JavaScript for Interactivity -->
    <script src = "./assets/landing.js">
     
    </script>
</body>
</html>