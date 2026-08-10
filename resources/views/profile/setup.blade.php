<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife – Complete Your Profile</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.min.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 0;
        }
        .setup-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .step-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .step-header .icon { font-size: 3rem; margin-bottom: 10px; }
        .goal-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }
        .goal-card:hover { border-color: #00d4aa; background: rgba(0,212,170,0.05); }
        .activity-option {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 10px 15px;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 8px;
        }
        .activity-option:hover { border-color: #00d4aa; }
    </style>
</head>
<body>
<div class="setup-card">

    <div class="step-header">
        <div class="icon">💪</div>
        <h4 class="fw-bold">Complete Your Profile</h4>
        <p class="text-muted">Help us personalize your fitness journey</p>
    </div>


    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.setup.save') }}">
        @csrf


        <h6 class="fw-bold text-muted mb-3">
            <i class="bi bi-person me-2"></i>Personal Information
        </h6>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Gender</label>
                <select name="gender"
                        class="form-select @error('gender') is-invalid @enderror"
                        required>
                    <option value="">— Select —</option>
                    <option value="male"   {{ old('gender') == 'male'   ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other"  {{ old('gender') == 'other'  ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Date of Birth</label>
                <input type="date" name="date_of_birth"
                       class="form-control @error('date_of_birth') is-invalid @enderror"
                       value="{{ old('date_of_birth') }}" required>
                @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Height (cm)</label>
                <input type="number" name="height" step="0.1"
                       class="form-control @error('height') is-invalid @enderror"
                       value="{{ old('height') }}"
                       placeholder="e.g. 175" required>
                @error('height')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Current Weight (kg)</label>
                <input type="number" name="current_weight" step="0.1"
                       class="form-control @error('current_weight') is-invalid @enderror"
                       value="{{ old('current_weight') }}"
                       placeholder="e.g. 80" required>
                @error('current_weight')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Target Weight (kg)</label>
                <input type="number" name="target_weight" step="0.1"
                       class="form-control @error('target_weight') is-invalid @enderror"
                       value="{{ old('target_weight') }}"
                       placeholder="e.g. 70" required>
                @error('target_weight')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <hr class="my-4">


        <h6 class="fw-bold text-muted mb-3">
            <i class="bi bi-lightning me-2"></i>Activity Level
        </h6>

        @php
        $activities = [
            'sedentary'   => ['label' => 'Sedentary',   'desc' => 'Little or no exercise',            'icon' => '🪑'],
            'light'       => ['label' => 'Light',       'desc' => 'Exercise 1–3 days/week',           'icon' => '🚶'],
            'moderate'    => ['label' => 'Moderate',    'desc' => 'Exercise 3–5 days/week',           'icon' => '🏃'],
            'active'      => ['label' => 'Active',      'desc' => 'Hard exercise 6–7 days/week',      'icon' => '🏋️'],
            'very_active' => ['label' => 'Very Active', 'desc' => 'Very hard exercise, physical job', 'icon' => '⚡'],
        ];
        @endphp

        <div class="mb-4">
            @foreach($activities as $value => $activity)
            <label class="d-block">
                <input type="radio" name="activity_level"
                       value="{{ $value }}"
                       class="d-none"
                       {{ old('activity_level', 'moderate') == $value ? 'checked' : '' }}>
                <div class="activity-option d-flex align-items-center gap-3">
                    <span style="font-size:1.5rem;">{{ $activity['icon'] }}</span>
                    <div>
                        <div class="fw-semibold">{{ $activity['label'] }}</div>
                        <div class="small text-muted">{{ $activity['desc'] }}</div>
                    </div>
                </div>
            </label>
            @endforeach
            @error('activity_level')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <hr class="my-4">

        {{-- Fitness Goal --}}
        <h6 class="fw-bold text-muted mb-3">
            <i class="bi bi-trophy me-2"></i>Fitness Goal
        </h6>

        @php
        $goalIcons = [
            'lose-weight'       => '🔥',
            'gain-weight'       => '📈',
            'gain-muscle'       => '💪',
            'maintain-weight'   => '⚖️',
            'improve-endurance' => '🏅',
        ];
        @endphp

        <div class="row g-3 mb-4">
            @foreach($goals as $goal)
            <div class="col-md-4">
                <label class="d-block">
                    <input type="radio" name="goal_id"
                           value="{{ $goal->id }}"
                           class="d-none"
                           {{ old('goal_id') == $goal->id ? 'checked' : '' }}
                           required>
                    <div class="goal-card">
                        <div style="font-size:1.8rem;">
                            {{ $goalIcons[$goal->slug] ?? '🎯' }}
                        </div>
                        <div class="fw-semibold mt-1">{{ $goal->name }}</div>
                        <div class="small text-muted">{{ $goal->description }}</div>
                    </div>
                </label>
            </div>
            @endforeach
            @error('goal_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold fs-5">
            <i class="bi bi-rocket-takeoff me-2"></i>Start My Journey!
        </button>

        <div class="text-center mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link text-muted small">
                    Not you? Logout
                </button>
            </form>
        </div>
    </form>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>

document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const name = this.getAttribute('name');
        document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
            const card = r.nextElementSibling;
            if (card) {
                card.style.borderColor = '';
                card.style.background  = '';
            }
        });
        const selected = this.nextElementSibling;
        if (selected) {
            selected.style.borderColor = '#00d4aa';
            selected.style.background  = 'rgba(0,212,170,0.1)';
        }
    });
});


document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
    const card = radio.nextElementSibling;
    if (card) {
        card.style.borderColor = '#00d4aa';
        card.style.background  = 'rgba(0,212,170,0.1)';
    }
});
</script>
</body>
</html>