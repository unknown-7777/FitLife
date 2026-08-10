<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Food;
use App\Models\Goal;
use App\Models\Profile;
use App\Models\User;
use App\Models\WorkoutPlan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'    => User::where('role', 'user')->count(),
            'total_exercises'=> Exercise::count(),
            'total_foods'    => Food::count(),
            'total_plans'    => WorkoutPlan::count(),
        ];

        $mostPopularGoal = Goal::withCount('profiles')
            ->orderBy('profiles_count', 'desc')
            ->first();

        $recentUsers = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'mostPopularGoal', 'recentUsers'));
    }
}