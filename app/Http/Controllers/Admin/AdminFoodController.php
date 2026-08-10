<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\FoodCategory;
use Illuminate\Http\Request;

class AdminFoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('category')->orderBy('name')->paginate(15);
        return view('admin.foods.index', compact('foods'));
    }

    public function create()
    {
        $categories = FoodCategory::all();
        return view('admin.foods.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_category_id' => 'required|exists:food_categories,id',
            'name'             => 'required|string|max:255',
            'calories'         => 'required|numeric|min:0',
            'protein'          => 'required|numeric|min:0',
            'carbohydrates'    => 'required|numeric|min:0',
            'fat'              => 'required|numeric|min:0',
            'serving_size'     => 'required|numeric|min:1',
            'image'            => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        Food::create($validated);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food created successfully.');
    }

    public function edit(Food $food)
    {
        $categories = FoodCategory::all();
        return view('admin.foods.edit', compact('food', 'categories'));
    }

    public function update(Request $request, Food $food)
    {
        $validated = $request->validate([
            'food_category_id' => 'required|exists:food_categories,id',
            'name'             => 'required|string|max:255',
            'calories'         => 'required|numeric|min:0',
            'protein'          => 'required|numeric|min:0',
            'carbohydrates'    => 'required|numeric|min:0',
            'fat'              => 'required|numeric|min:0',
            'serving_size'     => 'required|numeric|min:1',
            'image'            => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($validated);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food updated successfully.');
    }

    public function destroy(Food $food)
    {
        $food->delete();
        return redirect()->route('admin.foods.index')
            ->with('success', 'Food deleted.');
    }
}