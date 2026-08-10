<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id', 'name', 'description', 'difficulty',
    ];


    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_plan_exercises')
                    ->withPivot('sets', 'reps', 'duration_minutes', 'order')
                    ->withTimestamps();
    }

    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class);
    }
}