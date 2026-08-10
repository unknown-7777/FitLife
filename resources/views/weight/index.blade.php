@extends('layouts.app')
@section('title', 'Weight History')

@section('content')
<div class="row g-4">


    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h6 class="fw-bold mb-3 text-dark">Log New Weight</h6>
            <form method="POST" action="{{ route('weight.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Weight (kg)</label>
                    <input type="number" name="weight" step="0.1"
                           class="form-control rounded-3 @error('weight') is-invalid @enderror"
                           value="{{ old('weight') }}" placeholder="e.g. 78.5" required>
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Date</label>
                    <input type="date" name="recorded_at"
                           class="form-control rounded-3 @error('recorded_at') is-invalid @enderror"
                           value="{{ old('recorded_at', today()->toDateString()) }}" required>
                    @error('recorded_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Notes (optional)</label>
                    <input type="text" name="notes" class="form-control rounded-3"
                           value="{{ old('notes') }}" placeholder="e.g. Morning weigh-in">
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
                    Save Weight
                </button>
            </form>
        </div>
    </div>


    <div class="col-md-8">


        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-graph-down-arrow text-primary me-2"></i>Weight Progress Line
                </h6>
                
                @if($weights->count() > 1)
                    @php
                        $firstWeight = $weights->last()->weight;
                        $latestWeight = $weights->first()->weight;
                        $totalDiff = round($latestWeight - $firstWeight, 2);
                        $totalPercent = $firstWeight > 0 ? round(($totalDiff / $firstWeight) * 100, 2) : 0;
                    @endphp
                    <span class="badge {{ $totalDiff <= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill px-3 py-2 fw-semibold">
                        Overall: {{ $totalDiff > 0 ? '+' : '' }}{{ $totalDiff }} kg ({{ $totalDiff > 0 ? '+' : '' }}{{ $totalPercent }}%)
                    </span>
                @endif
            </div>

            @if($weights->count() >= 2)
                @php

                    $chartData = $weights->reverse()->values();
                    $weightsList = $chartData->pluck('weight')->map(fn($v) => (float)$v);
                    
                    $minW = $weightsList->min() - 0.5;
                    $maxW = $weightsList->max() + 0.5;
                    $range = max(($maxW - $minW), 1);


                    $svgWidth = 600;
                    $svgHeight = 180;
                    $padding = 20;
                    $usableWidth = $svgWidth - ($padding * 2);
                    $usableHeight = $svgHeight - ($padding * 2);

                    $stepX = count($weightsList) > 1 ? $usableWidth / (count($weightsList) - 1) : 0;


                    $points = [];
                    foreach ($weightsList as $idx => $val) {
                        $x = $padding + ($idx * $stepX);

                        $y = $padding + $usableHeight - (($val - $minW) / $range * $usableHeight);
                        $points[] = ['x' => $x, 'y' => $y, 'val' => $val, 'date' => $chartData[$idx]->recorded_at->format('M d')];
                    }


                    $isLoss = $weightsList->last() <= $weightsList->first();
                    $strokeColor = $isLoss ? '#10b981' : '#ef4444';
                    $fillColor = $isLoss ? 'rgba(16, 185, 129, 0.15)' : 'rgba(239, 68, 68, 0.15)';


                    $polylinePoints = implode(' ', array_map(fn($p) => "{$p['x']},{$p['y']}", $points));
                    

                    $firstX = $points[0]['x'];
                    $lastX = end($points)['x'];
                    $bottomY = $svgHeight - $padding;
                    $polygonPoints = "{$firstX},{$bottomY} {$polylinePoints} {$lastX},{$bottomY}";
                @endphp

                <div class="w-100 position-relative">
                    <svg viewBox="0 0 {{ $svgWidth }} {{ $svgHeight }}" class="w-100 h-auto overflow-visible" style="max-height: 220px;">
                        <defs>
                            <linearGradient id="tradeGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="{{ $strokeColor }}" stop-opacity="0.3"/>
                                <stop offset="100%" stop-color="{{ $strokeColor }}" stop-opacity="0.0"/>
                            </linearGradient>
                        </defs>


                        <line x1="{{ $padding }}" y1="{{ $padding }}" x2="{{ $svgWidth - $padding }}" y2="{{ $padding }}" stroke="#f3f4f6" stroke-width="1"/>
                        <line x1="{{ $padding }}" y1="{{ $svgHeight / 2 }}" x2="{{ $svgWidth - $padding }}" y2="{{ $svgHeight / 2 }}" stroke="#f3f4f6" stroke-width="1"/>
                        <line x1="{{ $padding }}" y1="{{ $svgHeight - $padding }}" x2="{{ $svgWidth - $padding }}" y2="{{ $svgHeight - $padding }}" stroke="#f3f4f6" stroke-width="1"/>


                        <polygon points="{{ $polygonPoints }}" fill="url(#tradeGrad)" />


                        <polyline fill="none" stroke="{{ $strokeColor }}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="{{ $polylinePoints }}" />


                        @foreach($points as $p)
                            <g class="chart-point">
                                <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="4" fill="{{ $strokeColor }}" stroke="#ffffff" stroke-width="2" />
                                <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" text-anchor="middle" font-size="10" font-weight="bold" fill="#374151">
                                    {{ $p['val'] }}kg
                                </text>
                                <text x="{{ $p['x'] }}" y="{{ $svgHeight }}" text-anchor="middle" font-size="9" fill="#9ca3af">
                                    {{ $p['date'] }}
                                </text>
                            </g>
                        @endforeach
                    </svg>
                </div>
            @else
                <div class="text-center py-4 text-muted small">
                    Log at least 2 entries to generate your visual trading trend chart.
                </div>
            @endif
        </div>

        {{-- Table Section --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold mb-0">History</h6>
            </div>

            <div class="card-body p-0 mt-3">
                @if($weights->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted text-uppercase text-xs tracking-wider">
                                <tr>
                                    <th class="ps-4 py-3">Date</th>
                                    <th class="py-3">Weight</th>
                                    <th class="py-3">Change</th>
                                    <th class="py-3">Notes</th>
                                    <th class="text-end pe-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($weights as $index => $w)
                                    @php
                                        $prev = $weights[$index + 1] ?? null;
                                        $diff = $prev ? round($w->weight - $prev->weight, 2) : null;
                                        $percent = ($prev && $prev->weight > 0) 
                                            ? round(($diff / $prev->weight) * 100, 2) 
                                            : null;
                                    @endphp
                                    <tr>
                                        <td class="ps-4 py-3 text-dark fw-medium">
                                            {{ $w->recorded_at->format('M d, Y') }}
                                        </td>
                                        <td class="py-3 fs-6 fw-bold text-dark">
                                            {{ number_format($w->weight, 2) }} <small class="text-muted fs-7">kg</small>
                                        </td>
                                        <td class="py-3">
                                            @if($diff === null)
                                                <span class="badge bg-light text-muted border px-2 py-1">Initial Entry</span>
                                            @elseif($diff < 0)
                                                <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded-pill fw-semibold">
                                                    <i class="bi bi-arrow-down-right me-1"></i>{{ $diff }} kg ({{ $percent }}%)
                                                </span>
                                            @elseif($diff > 0)
                                                <span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 rounded-pill fw-semibold">
                                                    <i class="bi bi-arrow-up-right me-1"></i>+{{ $diff }} kg (+{{ $percent }}%)
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5 rounded-pill fw-semibold">
                                                    <i class="bi bi-arrow-right me-1"></i>0.00 kg (0.00%)
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-muted small">
                                            {{ $w->notes ?? '–' }}
                                        </td>
                                        <td class="text-end pe-4 py-3">
                                            <form method="POST" action="{{ route('weight.destroy', $w) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle"
                                                        onclick="return confirm('Delete this entry?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-graph-down fs-2 d-block mb-2 opacity-50"></i>
                        <p class="small mb-0">No weight entries yet. Log your first one!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection