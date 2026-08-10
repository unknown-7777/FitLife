<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\WorkoutLog;
use App\Models\WorkoutLogExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutLogController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', today()->toDateString());

        $log = WorkoutLog::where('user_id', Auth::id())
            ->where('log_date', $date)
            ->with('exercises.exercise')
            ->first();

        $exercises = Exercise::orderBy('name')->get();

        return view('workout.log', compact('log', 'exercises', 'date'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exercise_id'      => 'required|exists:exercises,id',
            'sets'             => 'required|integer|min:1',
            'reps'             => 'nullable|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
            'weight_used'      => 'nullable|numeric|min:0',
            'date'             => 'required|date',
        ]);


        $log = WorkoutLog::firstOrCreate([
            'user_id'  => Auth::id(),
            'log_date' => $validated['date'],
        ]);

        WorkoutLogExercise::create([
            'workout_log_id'   => $log->id,
            'exercise_id'      => $validated['exercise_id'],
            'sets'             => $validated['sets'],
            'reps'             => $validated['reps'] ?? null,
            'duration_minutes' => $validated['duration_minutes'] ?? null,
            'weight_used'      => $validated['weight_used'] ?? null,
        ]);

        return back()->with('success', 'Exercise logged successfully!');
    }

    public function destroy(WorkoutLog $workoutLog)
    {
        abort_if($workoutLog->user_id !== Auth::id(), 403);
        $workoutLog->delete();
        return back()->with('success', 'Workout log deleted.');
    }
}