<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminExerciseController;
use App\Http\Controllers\Admin\AdminFoodController;
use App\Http\Controllers\Admin\AdminGoalController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminWorkoutPlanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
        ->name('users.edit');
    Route::patch('/users/{user}', [AdminUserController::class, 'update'])
        ->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
        ->name('users.destroy');

    Route::resource('goals', AdminGoalController::class);
    Route::resource('foods', AdminFoodController::class);
    Route::resource('exercises', AdminExerciseController::class);
    Route::resource('workout-plans', AdminWorkoutPlanController::class);
});