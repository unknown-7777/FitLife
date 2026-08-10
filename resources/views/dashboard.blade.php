@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')


<div class="row mb-4">
    <div class="col-12">
        <div class="card stat-card p-4 border-0 shadow-sm rounded-4"
             style="background: linear-gradient(135deg, #00d4aa, #00a8cc); color:white;">
            <h4 class="fw-bold">Welcome back, {{ auth()->user()->name }}! 👋</h4>
            <p class="mb-0">
                Goal:
                <strong>{{ $profile?->goal?->name ?? 'Not set yet' }}</strong>
            </p>
        </div>
    </div>
</div>


<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-4 text-center border-0 shadow-sm rounded-4 bg-white">
            <div class="text-muted small mb-1 fw-semibold">Current Weight</div>
            <div class="fs-3 fw-bold text-primary">
                {{ $latestWeight?->weight ?? $profile?->current_weight ?? '–' }}
                <small class="fs-6 text-muted">kg</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-4 text-center border-0 shadow-sm rounded-4 bg-white">
            <div class="text-muted small mb-1 fw-semibold">Target Weight</div>
            <div class="fs-3 fw-bold text-success">
                {{ $profile?->target_weight ?? '–' }}
                <small class="fs-6 text-muted">kg</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-4 text-center border-0 shadow-sm rounded-4 bg-white">
            <div class="text-muted small mb-1 fw-semibold">BMI</div>
            <div class="fs-3 fw-bold text-warning">
                {{ $bmi ?? '–' }}
            </div>
            <div class="small text-muted fw-medium">{{ $bmiStatus ?? '' }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-4 text-center border-0 shadow-sm rounded-4 bg-white">
            <div class="text-muted small mb-1 fw-semibold">Daily Calories</div>
            <div class="fs-3 fw-bold text-danger">
                {{ $todayCalories }}
                @if($recommendedCalories)
                    <small class="fs-6 text-muted">/ {{ $recommendedCalories }}</small>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    <div class="col-md-6">
        <div class="card stat-card p-4 border-0 shadow-sm rounded-4 bg-white h-100">
            <h6 class="fw-bold mb-3 text-dark">
                <i class="bi bi-journal-text text-success me-2"></i>Today's Meals
            </h6>
            @forelse($todayFoodLogs as $log)
                <div class="mb-2">
                    <span class="badge bg-secondary text-capitalize px-2 py-1">
                        {{ $log->meal_type }}
                    </span>
                    @foreach($log->items as $item)
                        <span class="ms-2 small text-dark">
                            {{ $item->food->name }}
                            <span class="text-muted">({{ round($item->food->calories * $item->quantity) }} kcal)</span>
                        </span>
                    @endforeach
                </div>
            @empty
                <p class="text-muted small">No meals logged today.</p>
            @endforelse
            <div class="mt-auto pt-2">
                <a href="{{ route('food.diary') }}" class="btn btn-sm btn-outline-success rounded-3 fw-semibold">
                    Log Food
                </a>
            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="card stat-card p-4 border-0 shadow-sm rounded-4 bg-white h-100">
            <h6 class="fw-bold mb-3 text-dark">
                <i class="bi bi-clipboard2-pulse text-danger me-2"></i>Today's Workout
            </h6>
            @if($todayWorkout && $todayWorkout->exercises->count())
                @foreach($todayWorkout->exercises as $ex)
                    <div class="small mb-2 text-dark">
                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                        <strong>{{ $ex->exercise->name }}</strong>
                        <span class="text-muted">
                            — {{ $ex->sets }} sets
                            @if($ex->reps) × {{ $ex->reps }} reps @endif
                            @if($ex->duration_minutes) × {{ $ex->duration_minutes }} min @endif
                        </span>
                    </div>
                @endforeach
            @else
                <p class="text-muted small">No workout logged today.</p>
            @endif
            <div class="mt-auto pt-2">
                <a href="{{ route('workout.log.index') }}" class="btn btn-sm btn-outline-danger rounded-3 fw-semibold">
                    Log Workout
                </a>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="card stat-card p-4 border-0 shadow-sm rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-graph-up text-primary me-2"></i>Weight Progress
                </h6>
                <a href="{{ route('weight.index') }}" class="btn btn-sm btn-light border rounded-3 text-muted fw-semibold">
                    Manage History <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            @if(isset($weeklyWeight) && $weeklyWeight->count() >= 2)
                @php

                    $chartData = $weeklyWeight->sortBy('recorded_at')->values();
                    $weightsList = $chartData->pluck('weight')->map(fn($v) => (float)$v);
                    
                    $minW = $weightsList->min() - 0.5;
                    $maxW = $weightsList->max() + 0.5;
                    $range = max(($maxW - $minW), 1);
            

                    $svgWidth = 700;
                    $svgHeight = 180;
                    $padding = 25;
                    $usableWidth = $svgWidth - ($padding * 2);
                    $usableHeight = $svgHeight - ($padding * 2);
            
                    $stepX = count($weightsList) > 1 ? $usableWidth / (count($weightsList) - 1) : 0;
            

                    $points = [];
                    foreach ($weightsList as $idx => $val) {
                        $x = $padding + ($idx * $stepX);
                        $y = $padding + $usableHeight - (($val - $minW) / $range * $usableHeight);
                        

                        $rawDate = $chartData[$idx]->recorded_at;
                        $dateLabel = ($rawDate instanceof \Carbon\Carbon) 
                            ? $rawDate->format('M d') 
                            : \Carbon\Carbon::parse($rawDate)->format('M d');
            
                        $points[] = ['x' => $x, 'y' => $y, 'val' => $val, 'date' => $dateLabel];
                    }
            

                    $isLoss = $weightsList->last() <= $weightsList->first();
                    $strokeColor = $isLoss ? '#10b981' : '#ef4444';
            

                    $polylinePoints = implode(' ', array_map(fn($p) => "{$p['x']},{$p['y']}", $points));
                    $firstX = $points[0]['x'];
                    $lastX = end($points)['x'];
                    $bottomY = $svgHeight - $padding;
                    $polygonPoints = "{$firstX},{$bottomY} {$polylinePoints} {$lastX},{$bottomY}";
                @endphp

                <div class="w-100 position-relative">
                    <svg viewBox="0 0 {{ $svgWidth }} {{ $svgHeight }}" class="w-100 h-auto overflow-visible" style="max-height: 220px;">
                        <defs>
                            <linearGradient id="dashboardTradeGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="{{ $strokeColor }}" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="{{ $strokeColor }}" stop-opacity="0.0"/>
                            </linearGradient>
                        </defs>


                        <line x1="{{ $padding }}" y1="{{ $padding }}" x2="{{ $svgWidth - $padding }}" y2="{{ $padding }}" stroke="#f3f4f6" stroke-width="1"/>
                        <line x1="{{ $padding }}" y1="{{ $svgHeight / 2 }}" x2="{{ $svgWidth - $padding }}" y2="{{ $svgHeight / 2 }}" stroke="#f3f4f6" stroke-width="1"/>
                        <line x1="{{ $padding }}" y1="{{ $svgHeight - $padding }}" x2="{{ $svgWidth - $padding }}" y2="{{ $svgHeight - $padding }}" stroke="#f3f4f6" stroke-width="1"/>


                        <polygon points="{{ $polygonPoints }}" fill="url(#dashboardTradeGrad)" />


                        <polyline fill="none" stroke="{{ $strokeColor }}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="{{ $polylinePoints }}" />


                        @foreach($points as $p)
                            <g class="chart-point">
                                <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="4" fill="{{ $strokeColor }}" stroke="#ffffff" stroke-width="2" />
                                <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" text-anchor="middle" font-size="10" font-weight="bold" fill="#374151">
                                    {{ $p['val'] }}kg
                                </text>
                                <text x="{{ $p['x'] }}" y="{{ $svgHeight }}" text-anchor="middle" font-size="9" fill="#9ca3af">
                                    {{ $p['date'] }}
                                </text>
                            </g>
                        @endforeach
                    </svg>
                </div>
            @else
                <div class="text-center py-4 text-muted small">
                    <i class="bi bi-graph-up fs-3 d-block mb-2 opacity-50"></i>
                    No sufficient weight data yet (at least 2 entries needed).
                    <a href="{{ route('weight.index') }}" class="d-block mt-1 fw-semibold text-primary">Start tracking weight</a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection