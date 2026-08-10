@extends('layouts.app')
@section('title', 'Workout Plans')

@section('content')

<div class="mb-4">
    <form method="GET" class="d-flex gap-2">
        <select name="difficulty" class="form-select w-auto">
            <option value="">All Levels</option>
            <option value="beginner"     {{ request('difficulty') == 'beginner'     ? 'selected' : '' }}>Beginner</option>
            <option value="intermediate" {{ request('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
            <option value="advanced"     {{ request('difficulty') == 'advanced'     ? 'selected' : '' }}>Advanced</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('workout-plans.index') }}" class="btn btn-outline-secondary">Reset</a>
    </form>
</div>

<div class="row g-4">
    @forelse($plans as $plan)
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="fw-bold">{{ $plan->name }}</h6>
                    <span class="badge
                        @if($plan->difficulty === 'beginner') bg-success
                        @elseif($plan->difficulty === 'intermediate') bg-warning text-dark
                        @else bg-danger
                        @endif">
                        {{ ucfirst($plan->difficulty) }}
                    </span>
                </div>
                @if($plan->goal)
                    <div class="small text-muted mb-2">
                        <i class="bi bi-trophy me-1"></i>{{ $plan->goal->name }}
                    </div>
                @endif
                <p class="small text-muted">{{ $plan->description }}</p>
                <div class="small text-muted mb-3">
                    <i class="bi bi-list-check me-1"></i>
                    {{ $plan->exercises->count() }} exercises
                </div>
                <a href="{{ route('workout-plans.show', $plan) }}"
                   class="btn btn-sm btn-outline-primary w-100">
                    View Plan
                </a>
            </div>
        </div>
    </div>
    @empty
        <p class="text-muted">No workout plans available.</p>
    @endforelse
</div>
@endsection