<?php

namespace App\Http\Controllers;

use App\Models\FoodLog;
use App\Models\WeightHistory;
use App\Models\WorkoutLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $profile = $user->profile;


        $latestWeight = WeightHistory::where('user_id', $user->id)
            ->orderBy('recorded_at', 'desc')
            ->first();


        $todayFoodLogs = FoodLog::where('user_id', $user->id)
            ->where('log_date', today())
            ->with('items.food')
            ->get();


        $todayCalories = $todayFoodLogs->sum(function ($log) {
            return $log->items->sum(function ($item) {
                return $item->food->calories * $item->quantity;
            });
        });


        $todayWorkout = WorkoutLog::where('user_id', $user->id)
            ->where('log_date', today())
            ->with('exercises.exercise')
            ->first();


        $weeklyWeight = WeightHistory::where('user_id', $user->id)
            ->orderBy('recorded_at', 'desc')
            ->take(7)
            ->get()
            ->reverse()
            ->values();


        $bmi       = $profile?->bmi;
        $bmiStatus = $profile?->bmi_status;


        $recommendedCalories = null;
        if ($profile && $profile->current_weight && $profile->height && $profile->date_of_birth) {
            $age = now()->diffInYears($profile->date_of_birth);
            if ($profile->gender === 'male') {
                $bmr = 88.36 + (13.4 * $profile->current_weight) + (4.8 * $profile->height) - (5.7 * $age);
            } else {
                $bmr = 447.6 + (9.2 * $profile->current_weight) + (3.1 * $profile->height) - (4.3 * $age);
            }

            $activityMultipliers = [
                'sedentary'  => 1.2,
                'light'      => 1.375,
                'moderate'   => 1.55,
                'active'     => 1.725,
                'very_active'=> 1.9,
            ];

            $multiplier = $activityMultipliers[$profile->activity_level] ?? 1.55;
            $recommendedCalories = round($bmr * $multiplier);
        }

        return view('dashboard', compact(
            'user',
            'profile',
            'latestWeight',
            'todayFoodLogs',
            'todayCalories',
            'todayWorkout',
            'weeklyWeight',
            'bmi',
            'bmiStatus',
            'recommendedCalories'
        ));
    }
}