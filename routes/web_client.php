<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\FoodDiaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSetupController;
use App\Http\Controllers\WeightHistoryController;
use App\Http\Controllers\WorkoutLogController;
use App\Http\Controllers\WorkoutPlanController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/setup', [ProfileSetupController::class, 'index'])
        ->name('profile.setup');
    Route::post('/profile/setup', [ProfileSetupController::class, 'store'])
        ->name('profile.setup.save');
});


Route::middleware(['auth', 'verified', 'profile.complete', 'not.admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/weight', [WeightHistoryController::class, 'index'])
        ->name('weight.index');
    Route::post('/weight', [WeightHistoryController::class, 'store'])
        ->name('weight.store');
    Route::delete('/weight/{weightHistory}', [WeightHistoryController::class, 'destroy'])
        ->name('weight.destroy');

    Route::get('/food-diary', [FoodDiaryController::class, 'index'])
        ->name('food.diary');
    Route::post('/food-diary', [FoodDiaryController::class, 'store'])
        ->name('food.store');
    Route::delete('/food-diary/{foodLogItem}', [FoodDiaryController::class, 'destroy'])
        ->name('food.destroy');

    Route::get('/exercises', [ExerciseController::class, 'index'])
        ->name('exercises.index');
    Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])
        ->name('exercises.show');

    Route::get('/workout-plans', [WorkoutPlanController::class, 'index'])
        ->name('workout-plans.index');
    Route::get('/workout-plans/{workoutPlan}', [WorkoutPlanController::class, 'show'])
        ->name('workout-plans.show');

    Route::get('/workout-log', [WorkoutLogController::class, 'index'])
        ->name('workout.log.index');
    Route::post('/workout-log', [WorkoutLogController::class, 'store'])
        ->name('workout.log.store');
    Route::delete('/workout-log/{workoutLog}', [WorkoutLogController::class, 'destroy'])
        ->name('workout.log.destroy');
});