@extends('layouts.admin')
@section('title', 'Add Exercise')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:700px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.exercises.store') }}"
              enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Exercise Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category</label>
                    <select name="exercise_category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Muscle Group</label>
                    <input type="text" name="muscle_group" class="form-control"
                           value="{{ old('muscle_group') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Difficulty</label>
                    <select name="difficulty" class="form-select" required>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Cal/min</label>
                    <input type="number" name="calories_burned_per_minute"
                           step="0.1" class="form-control"
                           value="{{ old('calories_burned_per_minute') }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Equipment Needed</label>
                    <input type="text" name="equipment_needed" class="form-control"
                           value="{{ old('equipment_needed') }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="3"
                              class="form-control">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Image (optional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Create Exercise</button>
                <a href="{{ route('admin.exercises.index') }}"
                   class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection