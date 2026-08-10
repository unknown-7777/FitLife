@extends('layouts.admin')
@section('title', 'Edit Food')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:700px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.foods.update', $food) }}"
              enctype="multipart/form-data">
            @csrf @method('PATCH')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Food Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $food->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category</label>
                    <select name="food_category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ $food->food_category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Calories</label>
                    <input type="number" name="calories" step="0.1"
                           class="form-control" value="{{ old('calories', $food->calories) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Protein (g)</label>
                    <input type="number" name="protein" step="0.1"
                           class="form-control" value="{{ old('protein', $food->protein) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Carbohydrates (g)</label>
                    <input type="number" name="carbohydrates" step="0.1"
                           class="form-control" value="{{ old('carbohydrates', $food->carbohydrates) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Fat (g)</label>
                    <input type="number" name="fat" step="0.1"
                           class="form-control" value="{{ old('fat', $food->fat) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Serving Size (g)</label>
                    <input type="number" name="serving_size" step="0.1"
                           class="form-control"
                           value="{{ old('serving_size', $food->serving_size) }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Image (optional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Update Food</button>
                <a href="{{ route('admin.foods.index') }}"
                   class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection