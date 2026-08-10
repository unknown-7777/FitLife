@extends('layouts.app')
@section('title', $workoutPlan->name)

@section('content')
<div class="card border-0 shadow-sm p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">{{ $workoutPlan->name }}</h4>
            @if($workoutPlan->goal)
                <span class="text-muted small">
                    <i class="bi bi-trophy me-1"></i>{{ $workoutPlan->goal->name }}
                </span>
            @endif
        </div>
        <span class="badge fs-6
            @if($workoutPlan->difficulty === 'beginner') bg-success
            @elseif($workoutPlan->difficulty === 'intermediate') bg-warning text-dark
            @else bg-danger
            @endif">
            {{ ucfirst($workoutPlan->difficulty) }}
        </span>
    </div>
    <p class="text-muted">{{ $workoutPlan->description }}</p>
</div>

<h6 class="fw-bold mb-3">Exercises in this Plan</h6>
<div class="row g-3">
    @foreach($workoutPlan->exercises->sortBy('pivot.order') as $exercise)
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-semibold">{{ $exercise->name }}</div>
                    <div class="small text-muted">{{ $exercise->muscle_group }}</div>
                </div>
                <div class="text-end small text-muted">
                    @if($exercise->pivot->reps)
                        {{ $exercise->pivot->sets }} sets × {{ $exercise->pivot->reps }} reps
                    @endif
                    @if($exercise->pivot->duration_minutes)
                        {{ $exercise->pivot->sets }} sets × {{ $exercise->pivot->duration_minutes }} min
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<a href="{{ route('workout-plans.index') }}" class="btn btn-outline-secondary mt-4">
    <i class="bi bi-arrow-left"></i> Back
</a>
@endsection