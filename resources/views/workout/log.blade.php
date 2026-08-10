@extends('layouts.app')
@section('title', 'Workout Log')

@section('content')


<div class="d-flex align-items-center gap-3 mb-4">
    <a href="?date={{ \Carbon\Carbon::parse($date)->subDay()->toDateString() }}"
       class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-chevron-left"></i>
    </a>
    <form method="GET" class="d-flex align-items-center gap-2">
        <input type="date" name="date" value="{{ $date }}"
               class="form-control form-control-sm" onchange="this.form.submit()">
    </form>
    <a href="?date={{ \Carbon\Carbon::parse($date)->addDay()->toDateString() }}"
       class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-chevron-right"></i>
    </a>
</div>

<div class="row g-4">


    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4">
            <h6 class="fw-bold mb-3">Log Exercise</h6>
            <form method="POST" action="{{ route('workout.log.store') }}">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">

                <div class="mb-3">
                    <label class="form-label">Exercise</label>
                    <select name="exercise_id" class="form-select" required>
                        <option value="">— Select —</option>
                        @foreach($exercises as $exercise)
                            <option value="{{ $exercise->id }}">
                                {{ $exercise->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sets</label>
                    <input type="number" name="sets" class="form-control"
                           value="3" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Reps</label>
                    <input type="number" name="reps" class="form-control"
                           placeholder="Optional">
                </div>

                <div class="mb-3">
                    <label class="form-label">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" class="form-control"
                           placeholder="Optional">
                </div>

                <div class="mb-3">
                    <label class="form-label">Weight Used (kg)</label>
                    <input type="number" name="weight_used" class="form-control"
                           step="0.5" placeholder="Optional">
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Log Exercise
                </button>
            </form>
        </div>
    </div>


    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4">
            <h6 class="fw-bold mb-3">
                {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
            </h6>
            @if($log && $log->exercises->count())
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Exercise</th>
                            <th>Sets</th>
                            <th>Reps</th>
                            <th>Duration</th>
                            <th>Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($log->exercises as $ex)
                        <tr>
                            <td class="fw-semibold">{{ $ex->exercise->name }}</td>
                            <td>{{ $ex->sets }}</td>
                            <td>{{ $ex->reps ?? '–' }}</td>
                            <td>{{ $ex->duration_minutes ? $ex->duration_minutes . ' min' : '–' }}</td>
                            <td>{{ $ex->weight_used ? $ex->weight_used . ' kg' : '–' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No exercises logged for this day.</p>
            @endif
        </div>
    </div>
</div>
@endsection