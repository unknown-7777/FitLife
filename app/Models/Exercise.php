<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_category_id', 'name', 'description',
        'muscle_group', 'difficulty', 'calories_burned_per_minute',
        'equipment_needed', 'image',
    ];


    public function category()
    {
        return $this->belongsTo(ExerciseCategory::class, 'exercise_category_id');
    }

    public function workoutPlans()
    {
        return $this->belongsToMany(WorkoutPlan::class, 'workout_plan_exercises')
                    ->withPivot('sets', 'reps', 'duration_minutes', 'order')
                    ->withTimestamps();
    }

    public function workoutLogExercises()
    {
        return $this->hasMany(WorkoutLogExercise::class);
    }
}