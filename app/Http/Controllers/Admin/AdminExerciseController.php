<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\ExerciseCategory;
use Illuminate\Http\Request;

class AdminExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::with('category')->orderBy('name')->paginate(15);
        return view('admin.exercises.index', compact('exercises'));
    }

    public function create()
    {
        $categories = ExerciseCategory::all();
        return view('admin.exercises.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exercise_category_id'       => 'required|exists:exercise_categories,id',
            'name'                       => 'required|string|max:255',
            'description'                => 'nullable|string',
            'muscle_group'               => 'nullable|string|max:255',
            'difficulty'                 => 'required|in:beginner,intermediate,advanced',
            'calories_burned_per_minute' => 'nullable|numeric|min:0',
            'equipment_needed'           => 'nullable|string|max:255',
            'image'                      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('exercises', 'public');
        }

        Exercise::create($validated);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise created successfully.');
    }

    public function edit(Exercise $exercise)
    {
        $categories = ExerciseCategory::all();
        return view('admin.exercises.edit', compact('exercise', 'categories'));
    }

    public function update(Request $request, Exercise $exercise)
    {
        $validated = $request->validate([
            'exercise_category_id'       => 'required|exists:exercise_categories,id',
            'name'                       => 'required|string|max:255',
            'description'                => 'nullable|string',
            'muscle_group'               => 'nullable|string|max:255',
            'difficulty'                 => 'required|in:beginner,intermediate,advanced',
            'calories_burned_per_minute' => 'nullable|numeric|min:0',
            'equipment_needed'           => 'nullable|string|max:255',
            'image'                      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('exercises', 'public');
        }

        $exercise->update($validated);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise updated successfully.');
    }

    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise deleted.');
    }
}