<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class WorkoutPlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = WorkoutPlan::with(['goal', 'exercises'])
            ->when($request->difficulty, function ($query) use ($request) {
                $query->where('difficulty', $request->difficulty);
            })
            ->get();

        return view('workout-plans.index', compact('plans'));
    }

    public function show(WorkoutPlan $workoutPlan)
    {
        $workoutPlan->load(['goal', 'exercises.category']);
        return view('workout-plans.show', compact('workoutPlan'));
    }
}