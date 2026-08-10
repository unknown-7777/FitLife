@extends('layouts.admin')
@section('title', 'Create Workout Plan')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:800px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.workout-plans.store') }}">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Plan Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Goal</label>
                    <select name="goal_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($goals as $goal)
                            <option value="{{ $goal->id }}">{{ $goal->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Difficulty</label>
                    <select name="difficulty" class="form-select" required>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="2"
                              class="form-control">{{ old('description') }}</textarea>
                </div>
            </div>

            <h6 class="fw-bold mb-3">Select Exercises</h6>
            <div class="row g-2">
                @foreach($exercises as $exercise)
                <div class="col-md-6">
                    <div class="card border p-2">
                        <div class="form-check">
                            <input class="form-check-input exercise-check"
                                   type="checkbox"
                                   name="exercises[]"
                                   value="{{ $exercise->id }}"
                                   id="ex{{ $exercise->id }}">
                            <label class="form-check-label fw-semibold"
                                   for="ex{{ $exercise->id }}">
                                {{ $exercise->name }}
                                <small class="text-muted">({{ $exercise->muscle_group }})</small>
                            </label>
                        </div>
                        <div class="row g-1 mt-1 ms-3 exercise-inputs-{{ $exercise->id }}"
                             style="display:none;">
                            <div class="col-6">
                                <input type="number" name="sets[{{ $exercise->id }}]"
                                       class="form-control form-control-sm"
                                       placeholder="Sets" min="1" value="3">
                            </div>
                            <div class="col-6">
                                <input type="number" name="reps[{{ $exercise->id }}]"
                                       class="form-control form-control-sm"
                                       placeholder="Reps" min="1">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Create Plan</button>
                <a href="{{ route('admin.workout-plans.index') }}"
                   class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.exercise-check').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const inputs = document.querySelector(`.exercise-inputs-${this.value}`);
        inputs.style.display = this.checked ? 'flex' : 'none';
    });
});
</script>
@endpush