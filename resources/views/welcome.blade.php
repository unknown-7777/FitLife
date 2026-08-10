<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife – Personal Health & Fitness Manager</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Segoe UI', sans-serif; }


        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(0,212,170,0.15), transparent 70%);
            top: -100px; right: -100px;
            border-radius: 50%;
        }
        .hero::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(0,168,204,0.1), transparent 70%);
            bottom: -50px; left: -50px;
            border-radius: 50%;
        }

        /* ── Navbar ── */
        .navbar-brand {
            color: #00d4aa !important;
            font-size: 1.6rem;
            font-weight: 800;
        }
        .nav-btn-login {
            color: rgba(255,255,255,0.8) !important;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 8px;
            padding: 6px 20px !important;
            transition: all 0.2s;
        }
        .nav-btn-login:hover {
            color: #fff !important;
            border-color: #fff;
        }
        .nav-btn-register {
            background: #00d4aa !important;
            color: #fff !important;
            border-radius: 8px;
            padding: 6px 20px !important;
            font-weight: 600;
            transition: all 0.2s;
        }
        .nav-btn-register:hover {
            background: #00b894 !important;
        }


        .hero-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 60px 20px;
            position: relative;
            z-index: 1;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(0,212,170,0.2);
            color: #00d4aa;
            border: 1px solid rgba(0,212,170,0.4);
            border-radius: 50px;
            padding: 6px 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }
        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 20px;
        }
        .hero-title span {
            background: linear-gradient(135deg, #00d4aa, #00a8cc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-subtitle {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.7);
            max-width: 550px;
            margin: 0 auto 40px;
            line-height: 1.7;
        }
        .hero-cta {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-hero-primary {
            background: linear-gradient(135deg, #00d4aa, #00a8cc);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px 36px;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 8px 30px rgba(0,212,170,0.4);
        }
        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0,212,170,0.5);
            color: #fff;
        }
        .btn-hero-secondary {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 12px;
            padding: 14px 36px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
        }
        .btn-hero-secondary:hover {
            background: rgba(255,255,255,0.2);
            color: #fff;
            transform: translateY(-2px);
        }


        .stats-bar {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 24px 0;
            position: relative;
            z-index: 1;
        }
        .stat-item {
            text-align: center;
            color: #fff;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #00d4aa;
        }
        .stat-label {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.6);
            margin-top: 2px;
        }


        .features-section {
            padding: 100px 0;
            background: #f8f9fa;
        }
        .section-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 12px;
        }
        .section-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto 60px;
        }
        .feature-card {
            background: #fff;
            border-radius: 16px;
            padding: 32px 24px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: all 0.3s;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        }
        .feature-icon {
            width: 70px; height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 20px;
        }
        .feature-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 10px;
        }
        .feature-desc {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
        }


        .how-section {
            padding: 100px 0;
            background: #fff;
        }
        .step-number {
            width: 50px; height: 50px;
            background: linear-gradient(135deg, #00d4aa, #00a8cc);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: 1.2rem;
            margin: 0 auto 16px;
        }
        .step-connector {
            position: absolute;
            top: 25px;
            left: calc(50% + 40px);
            right: calc(-50% + 40px);
            height: 2px;
            background: linear-gradient(90deg, #00d4aa, #00a8cc);
        }


        .cta-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #1a1a2e, #0f3460);
            text-align: center;
        }
        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 16px;
        }
        .cta-section p {
            color: rgba(255,255,255,0.7);
            font-size: 1.1rem;
            margin-bottom: 36px;
        }

        /* ── Footer ── */
        .footer {
            background: #0d0d1a;
            color: rgba(255,255,255,0.5);
            text-align: center;
            padding: 24px;
            font-size: 0.9rem;
        }
        .footer span { color: #00d4aa; }
    </style>
</head>
<body>


<section class="hero">


    <nav class="navbar navbar-expand px-4 px-md-5 pt-4" style="position:relative;z-index:2;">
        <a class="navbar-brand" href="#">
            <i class="bi bi-lightning-charge-fill"></i> FitLife
        </a>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('login') }}" class="nav-link nav-btn-login">Login</a>
            <a href="{{ route('register') }}" class="nav-link nav-btn-register">Get Started</a>
        </div>
    </nav>


    <div class="hero-content">
        <div>
            <div class="hero-badge">
                <i class="bi bi-lightning-charge-fill me-1"></i>
                Personal Health & Fitness Manager
            </div>
            <h1 class="hero-title">
                Track Your Fitness.<br>
                <span>Transform Your Life.</span>
            </h1>
            <p class="hero-subtitle">
                Log your meals, track workouts, monitor weight progress,
                and achieve your fitness goals — all in one place.
            </p>
            <div class="hero-cta">
                <a href="{{ route('register') }}" class="btn-hero-primary">
                    <i class="bi bi-rocket-takeoff me-2"></i>Start For Free
                </a>
                <!--<a href="{{ route('login') }}" class="btn-hero-secondary">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </a>-->
            </div>
        </div>
    </div>


    <div class="stats-bar">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Exercises</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">200+</div>
                        <div class="stat-label">Foods Tracked</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">5</div>
                        <div class="stat-label">Fitness Goals</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Free to Use</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="features-section">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Everything You Need</h2>
            <p class="section-subtitle">
                A complete toolkit to manage your health and fitness journey.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"
                         style="background:rgba(0,212,170,0.1); color:#00d4aa;">
                        🍽️
                    </div>
                    <div class="feature-title">Food Diary</div>
                    <p class="feature-desc">
                        Log every meal across breakfast, lunch, dinner and snacks.
                        Track calories, protein, carbs and fat automatically.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"
                         style="background:rgba(220,53,69,0.1); color:#dc3545;">
                        🏋️
                    </div>
                    <div class="feature-title">Workout Tracking</div>
                    <p class="feature-desc">
                        Log exercises with sets, reps, duration and weight.
                        Browse 40+ exercises across 14 muscle group categories.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"
                         style="background:rgba(0,123,255,0.1); color:#007bff;">
                        📊
                    </div>
                    <div class="feature-title">Progress Charts</div>
                    <p class="feature-desc">
                        Visualize your weight journey over time with beautiful
                        charts. See your progress at a glance on your dashboard.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"
                         style="background:rgba(255,193,7,0.1); color:#ffc107;">
                        🎯
                    </div>
                    <div class="feature-title">Goal Setting</div>
                    <p class="feature-desc">
                        Choose from 5 fitness goals — lose weight, gain muscle,
                        improve endurance and more. Get personalized calorie targets.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"
                         style="background:rgba(111,66,193,0.1); color:#6f42c1;">
                        📋
                    </div>
                    <div class="feature-title">Workout Plans</div>
                    <p class="feature-desc">
                        Follow expert-designed workout plans for every level —
                        beginner, intermediate and advanced.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"
                         style="background:rgba(40,167,69,0.1); color:#28a745;">
                        ⚖️
                    </div>
                    <div class="feature-title">BMI Calculator</div>
                    <p class="feature-desc">
                        Automatically calculates your BMI and daily calorie needs
                        based on your age, height, weight and activity level.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="how-section">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">
                Get started in minutes with these simple steps.
            </p>
        </div>

        <div class="row g-4 text-center">
            <div class="col-md-3 position-relative">
                <div class="step-number">1</div>
                <h6 class="fw-bold">Create Account</h6>
                <p class="text-muted small">
                    Register for free and set up your personal health profile.
                </p>
            </div>
            <div class="col-md-3">
                <div class="step-number">2</div>
                <h6 class="fw-bold">Set Your Goal</h6>
                <p class="text-muted small">
                    Choose a fitness goal and get a personalized calorie target.
                </p>
            </div>
            <div class="col-md-3">
                <div class="step-number">3</div>
                <h6 class="fw-bold">Track Daily</h6>
                <p class="text-muted small">
                    Log meals and workouts every day to stay on track.
                </p>
            </div>
            <div class="col-md-3">
                <div class="step-number">4</div>
                <h6 class="fw-bold">See Progress</h6>
                <p class="text-muted small">
                    Watch your weight and fitness improve over time.
                </p>
            </div>
        </div>
    </div>
</section>


<section class="cta-section">
    <div class="container">
        <h2>Ready to Start Your Journey?</h2>
        <p>Join FitLife today and take control of your health.</p>
        <a href="{{ route('register') }}" class="btn-hero-primary"
           style="display:inline-block;">
            <i class="bi bi-rocket-takeoff me-2"></i>Get Started Free
        </a>
    </div>
</section>


<footer class="footer">
    <p>© {{ date('Y') }} <span>FitLife</span> — Personal Health & Fitness Manager</p>
</footer>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>