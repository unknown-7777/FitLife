@extends('layouts.app')
@section('title', 'Weight History')

@section('content')
<div class="row g-4">


    <div class="col-md-4">
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">Log New Weight</h6>
            <form method="POST" action="{{ route('weight.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Weight (kg)</label>
                    <input type="number" name="weight" step="0.1"
                           class="form-control @error('weight') is-invalid @enderror"
                           value="{{ old('weight') }}" required>
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="recorded_at"
                           class="form-control @error('recorded_at') is-invalid @enderror"
                           value="{{ old('recorded_at', today()->toDateString()) }}" required>
                    @error('recorded_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes (optional)</label>
                    <input type="text" name="notes" class="form-control"
                           value="{{ old('notes') }}">
                </div>
                <button type="submit" class="btn btn-primary w-100">Save Weight</button>
            </form>
        </div>
    </div>


    <div class="col-md-8">
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">History</h6>
            @if($weights->count())
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Weight</th>
                            <th>Notes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weights as $w)
                        <tr>
                            <td>{{ $w->recorded_at->format('M d, Y') }}</td>
                            <td><strong>{{ $w->weight }} kg</strong></td>
                            <td class="text-muted small">{{ $w->notes ?? '–' }}</td>
                            <td>
                                <form method="POST"
                                      action="{{ route('weight.destroy', $w) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Delete this entry?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No weight entries yet. Log your first one!</p>
            @endif
        </div>
    </div>
</div>
@endsection