<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife – @yield('title', 'Welcome')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .brand {
            color: #00d4aa;
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
        }
        .brand-sub {
            text-align: center;
            color: #6c757d;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand">
            <i class="bi bi-lightning-charge-fill"></i> FitLife
        </div>
        <div class="brand-sub">Personal Health & Fitness Manager</div>
        {{ $slot }}
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>