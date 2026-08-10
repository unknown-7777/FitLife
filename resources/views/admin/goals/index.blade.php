@extends('layouts.admin')
@section('title', 'Manage Goals')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h6 class="fw-bold">All Goals</h6>
    <a href="{{ route('admin.goals.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Add Goal
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Users</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($goals as $goal)
                <tr>
                    <td class="fw-semibold">{{ $goal->name }}</td>
                    <td><code>{{ $goal->slug }}</code></td>
                    <td class="text-muted small">{{ $goal->description ?? '–' }}</td>
                    <td>{{ $goal->profiles_count }}</td>
                    <td>
                        <a href="{{ route('admin.goals.edit', $goal) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST"
                              action="{{ route('admin.goals.destroy', $goal) }}"
                              class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete goal?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection