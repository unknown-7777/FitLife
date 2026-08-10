@extends('layouts.admin')
@section('title', 'Manage Exercises')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h6 class="fw-bold">All Exercises</h6>
    <a href="{{ route('admin.exercises.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Add Exercise
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Muscle Group</th>
                    <th>Difficulty</th>
                    <th>Cal/min</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exercises as $exercise)
                <tr>
                    <td class="fw-semibold">{{ $exercise->name }}</td>
                    <td>{{ $exercise->category->name }}</td>
                    <td class="text-muted small">{{ $exercise->muscle_group ?? '–' }}</td>
                    <td>
                        <span class="badge
                            @if($exercise->difficulty === 'beginner') bg-success
                            @elseif($exercise->difficulty === 'intermediate') bg-warning text-dark
                            @else bg-danger
                            @endif">
                            {{ ucfirst($exercise->difficulty) }}
                        </span>
                    </td>
                    <td>{{ $exercise->calories_burned_per_minute ?? '–' }}</td>
                    <td>
                        <a href="{{ route('admin.exercises.edit', $exercise) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST"
                              action="{{ route('admin.exercises.destroy', $exercise) }}"
                              class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No exercises.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $exercises->links() }}
    </div>
</div>
@endsection