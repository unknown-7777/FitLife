<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Goal;
use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class AdminWorkoutPlanController extends Controller
{
    public function index()
    {
        $plans = WorkoutPlan::with(['goal', 'exercises'])->paginate(15);
        return view('admin.workout-plans.index', compact('plans'));
    }

    public function create()
    {
        $goals     = Goal::all();
        $exercises = Exercise::orderBy('name')->get();
        return view('admin.workout-plans.create', compact('goals', 'exercises'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'goal_id'      => 'nullable|exists:goals,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'difficulty'   => 'required|in:beginner,intermediate,advanced',
            'exercises'    => 'nullable|array',
            'exercises.*'  => 'exists:exercises,id',
        ]);

        $plan = WorkoutPlan::create([
            'goal_id'     => $validated['goal_id'],
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'difficulty'  => $validated['difficulty'],
        ]);

        if (!empty($validated['exercises'])) {
            $sync = [];
            foreach ($validated['exercises'] as $i => $exerciseId) {
                $sync[$exerciseId] = [
                    'sets'  => $request->input("sets.$exerciseId", 3),
                    'reps'  => $request->input("reps.$exerciseId"),
                    'order' => $i + 1,
                ];
            }
            $plan->exercises()->attach($sync);
        }

        return redirect()->route('admin.workout-plans.index')
            ->with('success', 'Workout plan created.');
    }

    public function edit(WorkoutPlan $workoutPlan)
    {
        $goals     = Goal::all();
        $exercises = Exercise::orderBy('name')->get();
        $workoutPlan->load('exercises');
        return view('admin.workout-plans.edit', compact('workoutPlan', 'goals', 'exercises'));
    }

    public function update(Request $request, WorkoutPlan $workoutPlan)
    {
        $validated = $request->validate([
            'goal_id'     => 'nullable|exists:goals,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'difficulty'  => 'required|in:beginner,intermediate,advanced',
            'exercises'   => 'nullable|array',
            'exercises.*' => 'exists:exercises,id',
        ]);

        $workoutPlan->update([
            'goal_id'     => $validated['goal_id'],
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'difficulty'  => $validated['difficulty'],
        ]);

        $sync = [];
        foreach ($validated['exercises'] ?? [] as $i => $exerciseId) {
            $sync[$exerciseId] = [
                'sets'  => $request->input("sets.$exerciseId", 3),
                'reps'  => $request->input("reps.$exerciseId"),
                'order' => $i + 1,
            ];
        }
        $workoutPlan->exercises()->sync($sync);

        return redirect()->route('admin.workout-plans.index')
            ->with('success', 'Workout plan updated.');
    }

    public function destroy(WorkoutPlan $workoutPlan)
    {
        $workoutPlan->delete();
        return redirect()->route('admin.workout-plans.index')
            ->with('success', 'Workout plan deleted.');
    }
}