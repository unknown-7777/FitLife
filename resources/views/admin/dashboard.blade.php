@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card p-4 text-center border-0 shadow-sm">
            <div class="fs-1 text-primary fw-bold">{{ $stats['total_users'] }}</div>
            <div class="text-muted">Total Users</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4 text-center border-0 shadow-sm">
            <div class="fs-1 text-success fw-bold">{{ $stats['total_foods'] }}</div>
            <div class="text-muted">Total Foods</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4 text-center border-0 shadow-sm">
            <div class="fs-1 text-warning fw-bold">{{ $stats['total_exercises'] }}</div>
            <div class="text-muted">Total Exercises</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4 text-center border-0 shadow-sm">
            <div class="fs-1 text-danger fw-bold">{{ $stats['total_plans'] }}</div>
            <div class="text-muted">Workout Plans</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card p-4 border-0 shadow-sm">
            <h6 class="fw-bold mb-3">Most Popular Goal</h6>
            @if($mostPopularGoal)
                <div class="d-flex align-items-center gap-3">
                    <div class="fs-2">🏆</div>
                    <div>
                        <div class="fw-bold fs-5">{{ $mostPopularGoal->name }}</div>
                        <div class="text-muted small">
                            {{ $mostPopularGoal->profiles_count }} users
                        </div>
                    </div>
                </div>
            @else
                <p class="text-muted">No data yet.</p>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4 border-0 shadow-sm">
            <h6 class="fw-bold mb-3">Recent Registrations</h6>
            @forelse($recentUsers as $user)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <div class="fw-semibold">{{ $user->name }}</div>
                        <div class="text-muted small">{{ $user->email }}</div>
                    </div>
                    <div class="text-muted small">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <p class="text-muted">No users yet.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection