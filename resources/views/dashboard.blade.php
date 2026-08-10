@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')


<div class="row mb-4">
    <div class="col-12">
        <div class="card stat-card p-4"
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
        <div class="card stat-card p-4 text-center">
            <div class="text-muted small mb-1">Current Weight</div>
            <div class="fs-3 fw-bold text-primary">
                {{ $latestWeight?->weight ?? $profile?->current_weight ?? '–' }}
                <small class="fs-6">kg</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-4 text-center">
            <div class="text-muted small mb-1">Target Weight</div>
            <div class="fs-3 fw-bold text-success">
                {{ $profile?->target_weight ?? '–' }}
                <small class="fs-6">kg</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-4 text-center">
            <div class="text-muted small mb-1">BMI</div>
            <div class="fs-3 fw-bold text-warning">
                {{ $bmi ?? '–' }}
            </div>
            <div class="small text-muted">{{ $bmiStatus ?? '' }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-4 text-center">
            <div class="text-muted small mb-1">Daily Calories</div>
            <div class="fs-3 fw-bold text-danger">
                {{ $todayCalories }}
                @if($recommendedCalories)
                    <small class="fs-6">/ {{ $recommendedCalories }}</small>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Today's Food Summary --}}
    <div class="col-md-6">
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-journal-text text-success me-2"></i>Today's Meals
            </h6>
            @forelse($todayFoodLogs as $log)
                <div class="mb-2">
                    <span class="badge bg-secondary text-capitalize">
                        {{ $log->meal_type }}
                    </span>
                    @foreach($log->items as $item)
                        <span class="ms-2 small">
                            {{ $item->food->name }}
                            ({{ round($item->food->calories * $item->quantity) }} kcal)
                        </span>
                    @endforeach
                </div>
            @empty
                <p class="text-muted small">No meals logged today.</p>
            @endforelse
            <a href="{{ route('food.diary') }}" class="btn btn-sm btn-outline-success mt-2">
                Log Food
            </a>
        </div>
    </div>


    <div class="col-md-6">
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-clipboard2-pulse text-danger me-2"></i>Today's Workout
            </h6>
            @if($todayWorkout && $todayWorkout->exercises->count())
                @foreach($todayWorkout->exercises as $ex)
                    <div class="small mb-1">
                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                        {{ $ex->exercise->name }}
                        — {{ $ex->sets }} sets
                        @if($ex->reps) × {{ $ex->reps }} reps @endif
                        @if($ex->duration_minutes) × {{ $ex->duration_minutes }} min @endif
                    </div>
                @endforeach
            @else
                <p class="text-muted small">No workout logged today.</p>
            @endif
            <a href="{{ route('workout.log.index') }}" class="btn btn-sm btn-outline-danger mt-2">
                Log Workout
            </a>
        </div>
    </div>


    <div class="col-12">
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-graph-up text-primary me-2"></i>Weight Progress
            </h6>
            @if($weeklyWeight->count())
                <canvas id="weightChart" height="80"></canvas>
            @else
                <p class="text-muted small">No weight data yet.
                    <a href="{{ route('weight.index') }}">Start tracking</a>
                </p>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
@if($weeklyWeight->count())
const ctx = document.getElementById('weightChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! $weeklyWeight->pluck('recorded_at')->map(fn($d) => $d->format('M d'))->toJson() !!},
        datasets: [{
            label: 'Weight (kg)',
            data: {!! $weeklyWeight->pluck('weight')->toJson() !!},
            borderColor: '#00d4aa',
            backgroundColor: 'rgba(0,212,170,0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#00d4aa',
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: false }
        }
    }
});
@endif
</script>
@endpush