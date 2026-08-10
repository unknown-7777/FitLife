@extends('layouts.admin')
@section('title', 'Manage Foods')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h6 class="fw-bold">All Foods</h6>
    <a href="{{ route('admin.foods.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Add Food
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Calories</th>
                    <th>Protein</th>
                    <th>Carbs</th>
                    <th>Fat</th>
                    <th>Serving</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($foods as $food)
                <tr>
                    <td class="fw-semibold">{{ $food->name }}</td>
                    <td>{{ $food->category->name }}</td>
                    <td>{{ $food->calories }}</td>
                    <td>{{ $food->protein }}g</td>
                    <td>{{ $food->carbohydrates }}g</td>
                    <td>{{ $food->fat }}g</td>
                    <td>{{ $food->serving_size }}g</td>
                    <td>
                        <a href="{{ route('admin.foods.edit', $food) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST"
                              action="{{ route('admin.foods.destroy', $food) }}"
                              class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete this food?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No foods found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $foods->links() }}
    </div>
</div>
@endsection