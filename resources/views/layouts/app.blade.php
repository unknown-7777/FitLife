<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife – @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            width: 250px;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            padding-top: 20px;
        }
        .sidebar .brand {
            color: #00d4aa;
            font-size: 1.5rem;
            font-weight: 700;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 10px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(0,212,170,0.2);
        }
        .sidebar .nav-link i { margin-right: 8px; }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .topbar {
            background: #fff;
            padding: 15px 30px;
            margin: -30px -30px 30px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
    </style>
    
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <div class="brand"><i class="bi bi-lightning-charge-fill"></i> FitLife</div>
    <nav class="nav flex-column mt-3">
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('profile.edit') }}"
           class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profile
        </a>
        <a href="{{ route('food.diary') }}"
           class="nav-link {{ request()->routeIs('food.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Food Diary
        </a>
        <a href="{{ route('exercises.index') }}"
           class="nav-link {{ request()->routeIs('exercises.*') ? 'active' : '' }}">
            <i class="bi bi-activity"></i> Exercises
        </a>
        <a href="{{ route('workout-plans.index') }}"
           class="nav-link {{ request()->routeIs('workout-plans.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Workout Plans
        </a>
        <a href="{{ route('workout.log.index') }}"
           class="nav-link {{ request()->routeIs('workout.log.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard2-pulse"></i> Workout Log
        </a>
        <a href="{{ route('weight.index') }}"
           class="nav-link {{ request()->routeIs('weight.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i> Weight History
        </a>

        <hr style="border-color:rgba(255,255,255,0.1); margin: 10px 20px;">

        <!--@if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="bi bi-shield-lock"></i> Admin Panel
        </a>
        @endif-->

        <form method="POST" action="{{ route('logout') }}" class="mx-3 mt-2">
            @csrf
            <button type="submit"
                    class="nav-link btn btn-link text-start w-100"
                    style="color:rgba(255,255,255,0.7);">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </nav>
</div>

<div class="main-content">
    <div class="topbar">
        <h5 class="mb-0 fw-bold">@yield('title', 'Dashboard')</h5>
        <span class="text-muted">{{ auth()->user()->name }}</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@stack('scripts')
</body>
</html>
