@extends('layouts.app')
@section('title', 'Exercises')

@push('styles')
<style>
.exercise-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: transform 0.2s;
    height: 100%;
    background: #fff;
    padding: 20px;
}
.exercise-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}
.filter-bar {
    background: #fff;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}
</style>
@endpush

@section('content')

{{-- Filter Bar --}}
<div class="filter-bar">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search"
                   placeholder="Search exercises..."
                   value="{{ request('search') }}"
                   class="form-control">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="difficulty" class="form-select">
                <option value="">All Levels</option>
                <option value="beginner"
                    {{ request('difficulty') == 'beginner' ? 'selected' : '' }}>
                    Beginner
                </option>
                <option value="intermediate"
                    {{ request('difficulty') == 'intermediate' ? 'selected' : '' }}>
                    Intermediate
                </option>
                <option value="advanced"
                    {{ request('difficulty') == 'advanced' ? 'selected' : '' }}>
                    Advanced
                </option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
            <a href="{{ route('exercises.index') }}"
               class="btn btn-outline-secondary">✕</a>
        </div>
    </form>
</div>

{{-- Results Count --}}
<p class="text-muted mb-3">
    Showing {{ $exercises->count() }} of {{ $exercises->total() }} exercises
</p>

{{-- Exercise Cards --}}
<div class="row g-4">
    @forelse($exercises as $exercise)
    <div class="col-md-4 col-sm-6">
        <div class="exercise-card">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h6 class="fw-bold mb-0" style="font-size:1rem;">
                    {{ $exercise->name }}
                </h6>
                @if($exercise->difficulty === 'beginner')
                    <span class="badge bg-success">Beginner</span>
                @elseif($exercise->difficulty === 'intermediate')
                    <span class="badge bg-warning text-dark">Intermediate</span>
                @else
                    <span class="badge bg-danger">Advanced</span>
                @endif
            </div>

            {{-- Details --}}
            <div class="mb-1" style="font-size:0.85rem; color:#6c757d;">
                <i class="bi bi-tag me-1"></i>
                {{ $exercise->category->name }}
            </div>
            <div class="mb-1" style="font-size:0.85rem; color:#6c757d;">
                <i class="bi bi-person me-1"></i>
                {{ $exercise->muscle_group ?? '–' }}
            </div>
            <div class="mb-1" style="font-size:0.85rem; color:#6c757d;">
                <i class="bi bi-tools me-1"></i>
                {{ $exercise->equipment_needed ?? 'No equipment' }}
            </div>
            <div class="mb-3" style="font-size:0.85rem; color:#6c757d;">
                <i class="bi bi-fire me-1 text-danger"></i>
                {{ $exercise->calories_burned_per_minute ?? '–' }} kcal/min
            </div>

            {{-- Action --}}
            <a href="{{ route('exercises.show', $exercise) }}"
               class="btn btn-outline-primary btn-sm w-100">
                View Details
            </a>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5 text-muted">
            <i class="bi bi-search" style="font-size:3rem;"></i>
            <p class="mt-3">No exercises found matching your filters.</p>
            <a href="{{ route('exercises.index') }}" class="btn btn-outline-primary">
                Clear Filters
            </a>
        </div>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-4 d-flex justify-content-center">
    {{ $exercises->withQueryString()->links() }}
</div>

@endsection