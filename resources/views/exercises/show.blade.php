@extends('layouts.app')
@section('title', $exercise->name)

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ $exercise->name }}</h4>
                <span class="badge fs-6
                    @if($exercise->difficulty === 'beginner') bg-success
                    @elseif($exercise->difficulty === 'intermediate') bg-warning text-dark
                    @else bg-danger
                    @endif">
                    {{ ucfirst($exercise->difficulty) }}
                </span>
            </div>

            <table class="table table-borderless table-sm">
                <tr>
                    <td class="text-muted fw-semibold">Category</td>
                    <td>{{ $exercise->category->name }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold">Muscle Group</td>
                    <td>{{ $exercise->muscle_group ?? '–' }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold">Equipment</td>
                    <td>{{ $exercise->equipment_needed ?? 'None' }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-semibold">Calories Burned</td>
                    <td>{{ $exercise->calories_burned_per_minute ?? '–' }} kcal/min</td>
                </tr>
            </table>

            @if($exercise->description)
                <hr>
                <p class="text-muted">{{ $exercise->description }}</p>
            @endif

            <a href="{{ route('exercises.index') }}"
               class="btn btn-outline-secondary mt-2">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>
@endsection