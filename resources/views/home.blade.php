<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ARIC Inventory System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>


    @include('layouts.header')


    <div class="hero-section">
        <div class="welcome-message">
            <h1>Welcome to ARICC</h1>
            <p>
                The Advanced Robotics and Intelligent Control Center (ARICC) at Bulacan State University leads in automation, robotics, and smart inventory solutions. Explore a future where technology meets innovation.
            </p>
            <a href="{{ url('/register') }}" class="register-btn">Register Now</a>
        </div>

        <div class="carousel-container">
            <div id="aricCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/carousel1.jpg') }}" class="d-block" alt="Slide 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/carousel2.jpg') }}" class="d-block" alt="Slide 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/carousel3.jpg') }}" class="d-block" alt="Slide 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#aricCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#aricCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="features-section section">
        <h2>Featured Services</h2>
        <div class="row justify-content-center">
            <div class="col-md-3 feature-card">
                <div class="feature-icon"><i class="fas fa-robot"></i></div>
                <h5>Robotics Training</h5>
                <p>Hands-on learning in robotics and automation technologies.</p>
            </div>
            <div class="col-md-3 feature-card">
                <div class="feature-icon"><i class="fas fa-microchip"></i></div>
                <h5>PCB Fabrication</h5>
                <p>Prototyping and circuit board production for projects.</p>
            </div>
            <div class="col-md-3 feature-card">
                <div class="feature-icon"><i class="fas fa-industry"></i></div>
                <h5>Automation Solutions</h5>
                <p>Custom automation systems designed for industrial needs.</p>
            </div>
        </div>
    </div>

    <div class="section cta-section">
        <h2>How the ARIC Inventory System Works</h2>
        <p style="max-width: 800px; margin: 0 auto; color: #d6e4f0;">
            Our system is built to simplify inventory management at ARICC — from tracking robotics kits to borrowing tools and logging activity. It’s your smart assistant in managing resources efficiently.
        </p>

        <div class="row justify-content-center mt-5">
            <div class="col-md-3 feature-card">
                <div class="feature-icon"><i class="fas fa-boxes-stacked"></i></div>
                <h5>Real-Time Inventory</h5>
                <p>Monitor available stocks and low-item warnings instantly.</p>
            </div>
            <div class="col-md-3 feature-card">
                <div class="feature-icon"><i class="fas fa-hand-holding"></i></div>
                <h5>Borrow & Return System</h5>
                <p>Organized item requests, tracking, and return approval.</p>
            </div>
            <div class="col-md-3 feature-card">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h5>Activity Logs</h5>
                <p>Secure logs and reports for transparency and accountability.</p>
            </div>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} ARIC Inventory System — Bulacan State University
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
