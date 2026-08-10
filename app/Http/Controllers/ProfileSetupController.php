<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileSetupController extends Controller
{
    public function index()
    {
        if (Auth::user()->profile) {
            return redirect()->route('dashboard');
        }

        $goals = Goal::all();
        return view('profile.setup', compact('goals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gender'         => 'required|in:male,female,other',
            'date_of_birth'  => 'required|date|before:today',
            'height'         => 'required|numeric|min:50|max:300',
            'current_weight' => 'required|numeric|min:20|max:500',
            'target_weight'  => 'required|numeric|min:20|max:500',
            'activity_level' => 'required|in:sedentary,light,moderate,active,very_active',
            'goal_id'        => 'required|exists:goals,id',
        ]);

        Profile::create([
            'user_id'        => Auth::id(),
            'gender'         => $validated['gender'],
            'date_of_birth'  => $validated['date_of_birth'],
            'height'         => $validated['height'],
            'current_weight' => $validated['current_weight'],
            'target_weight'  => $validated['target_weight'],
            'activity_level' => $validated['activity_level'],
            'goal_id'        => $validated['goal_id'],
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Welcome to FitLife! Your profile is all set. 🎉');
    }
}