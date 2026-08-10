<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife Admin – @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">
    <style>
        body { background-color: #f1f3f5; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #0f0c29, #302b63, #24243e);
            width: 260px;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            padding-top: 20px;
        }
        .sidebar .brand {
            color: #f39c12;
            font-size: 1.4rem;
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
            background: rgba(243,156,18,0.2);
        }
        .sidebar .nav-link i { margin-right: 8px; }
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
        .topbar {
            background: #fff;
            padding: 15px 30px;
            margin: -30px -30px 30px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <div class="brand"><i class="bi bi-shield-fill"></i> Admin Panel</div>
    <nav class="nav flex-column mt-3">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('admin.goals.index') }}"
           class="nav-link {{ request()->routeIs('admin.goals.*') ? 'active' : '' }}">
            <i class="bi bi-trophy"></i> Goals
        </a>
        <a href="{{ route('admin.foods.index') }}"
           class="nav-link {{ request()->routeIs('admin.foods.*') ? 'active' : '' }}">
            <i class="bi bi-egg-fried"></i> Foods
        </a>
        <a href="{{ route('admin.exercises.index') }}"
           class="nav-link {{ request()->routeIs('admin.exercises.*') ? 'active' : '' }}">
            <i class="bi bi-activity"></i> Exercises
        </a>
        <a href="{{ route('admin.workout-plans.index') }}"
           class="nav-link {{ request()->routeIs('admin.workout-plans.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Workout Plans
        </a>

        <!--<hr style="border-color:rgba(255,255,255,0.1); margin: 10px 20px;">

        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="bi bi-arrow-left-circle"></i> Back to App
        </a>-->

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
        <h5 class="mb-0 fw-bold">@yield('title')</h5>
        <span class="text-muted">{{ auth()->user()->name }}</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
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