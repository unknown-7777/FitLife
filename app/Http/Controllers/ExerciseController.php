<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\ExerciseCategory;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index(Request $request)
    {
        $categories = ExerciseCategory::all();

        $exercises = Exercise::with('category')
            ->when($request->category, function ($query) use ($request) {
                $query->where('exercise_category_id', $request->category);
            })
            ->when($request->difficulty, function ($query) use ($request) {
                $query->where('difficulty', $request->difficulty);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('name')
            ->paginate(12);

        return view('exercises.index', compact('exercises', 'categories'));
    }

    public function show(Exercise $exercise)
    {
        $exercise->load('category');
        return view('exercises.show', compact('exercise'));
    }
}