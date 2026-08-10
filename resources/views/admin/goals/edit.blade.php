@extends('layouts.admin')
@section('title', 'Edit Goal')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:600px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.goals.update', $goal) }}">
            @csrf @method('PATCH')
            <div class="mb-3">
                <label class="form-label fw-semibold">Goal Name</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $goal->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" rows="3"
                          class="form-control">{{ old('description', $goal->description) }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Goal</button>
                <a href="{{ route('admin.goals.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection