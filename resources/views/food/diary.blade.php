@extends('layouts.app')
@section('title', 'Food Diary')

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


<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <div class="fs-4 fw-bold text-danger">{{ $totals['calories'] }}</div>
            <div class="small text-muted">Calories</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <div class="fs-4 fw-bold text-primary">{{ $totals['protein'] }}g</div>
            <div class="small text-muted">Protein</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <div class="fs-4 fw-bold text-warning">{{ $totals['carbohydrates'] }}g</div>
            <div class="small text-muted">Carbs</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <div class="fs-4 fw-bold text-success">{{ $totals['fat'] }}g</div>
            <div class="small text-muted">Fat</div>
        </div>
    </div>
</div>


@foreach($mealTypes as $meal)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-capitalize">
            @switch($meal)
                @case('breakfast') 🌅 @break
                @case('lunch')     🌞 @break
                @case('dinner')    🌙 @break
                @case('snack')     🍎 @break
            @endswitch
            {{ ucfirst($meal) }}
        </h6>
        <button class="btn btn-sm btn-outline-primary"
                data-bs-toggle="modal"
                data-bs-target="#addFoodModal"
                data-meal="{{ $meal }}">
            <i class="bi bi-plus-lg"></i> Add Food
        </button>
    </div>
    <div class="card-body">
        @if(isset($logs[$meal]) && $logs[$meal]->items->count())
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Food</th>
                        <th>Qty</th>
                        <th>Calories</th>
                        <th>Protein</th>
                        <th>Carbs</th>
                        <th>Fat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs[$meal]->items as $item)
                    <tr>
                        <td>{{ $item->food->name }}</td>
                        <td>{{ $item->quantity }}x</td>
                        <td>{{ round($item->food->calories * $item->quantity) }}</td>
                        <td>{{ round($item->food->protein * $item->quantity, 1) }}g</td>
                        <td>{{ round($item->food->carbohydrates * $item->quantity, 1) }}g</td>
                        <td>{{ round($item->food->fat * $item->quantity, 1) }}g</td>
                        <td>
                            <form method="POST"
                                  action="{{ route('food.destroy', $item) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted small mb-0">No food logged for {{ $meal }}.</p>
        @endif
    </div>
</div>
@endforeach


<div class="modal fade" id="addFoodModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Food</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('food.store') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="date" value="{{ $date }}">
                    <input type="hidden" name="meal_type" id="modalMealType">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Meal</label>
                        <input type="text" id="modalMealLabel"
                               class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Food</label>
                        <select name="food_id" class="form-select" required>
                            <option value="">— Select food —</option>
                            @foreach($foods as $food)
                                <option value="{{ $food->id }}">
                                    {{ $food->name }}
                                    ({{ $food->calories }} kcal / {{ $food->serving_size }}g)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Quantity (servings)</label>
                        <input type="number" name="quantity"
                               class="form-control" value="1"
                               step="0.5" min="0.5" max="20" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Food</button>
                </div>
            </form>  
        </div>      
    </div>          
</div>              

@endsection         

@push('scripts')
<script>
const addFoodModal = document.getElementById('addFoodModal');
addFoodModal.addEventListener('show.bs.modal', function (e) {
    const meal = e.relatedTarget.getAttribute('data-meal');
    document.getElementById('modalMealType').value  = meal;
    document.getElementById('modalMealLabel').value =
        meal.charAt(0).toUpperCase() + meal.slice(1);
});
</script>
@endpush