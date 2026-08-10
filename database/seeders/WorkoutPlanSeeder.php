<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Exercise;
use App\Models\Goal;
use App\Models\WorkoutPlan;
use Illuminate\Database\Seeder;

class WorkoutPlanSeeder extends Seeder
{
    public function run(): void
    {

        $ex = fn($name) => Exercise::where('name', $name)->first()?->id;


        $loseWeight = Goal::where('slug', 'lose-weight')->first();
        $plan1 = WorkoutPlan::create([
            'goal_id'     => $loseWeight->id,
            'name'        => 'Beginner Fat Loss',
            'description' => 'A simple plan to start burning fat.',
            'difficulty'  => 'beginner',
        ]);

        $plan1->exercises()->attach([
            $ex('Push Up')  => ['sets' => 3, 'reps' => 15, 'duration_minutes' => null, 'order' => 1],
            $ex('Squat')    => ['sets' => 3, 'reps' => 20, 'duration_minutes' => null, 'order' => 2],
            $ex('Running')  => ['sets' => 1, 'reps' => null, 'duration_minutes' => 20,  'order' => 3],
            $ex('Plank')    => ['sets' => 3, 'reps' => null, 'duration_minutes' => 1,   'order' => 4],
        ]);


        $gainMuscle = Goal::where('slug', 'gain-muscle')->first();
        $plan2 = WorkoutPlan::create([
            'goal_id'     => $gainMuscle->id,
            'name'        => 'Intermediate Muscle Gain',
            'description' => 'Build lean muscle with compound movements.',
            'difficulty'  => 'intermediate',
        ]);

        $plan2->exercises()->attach([
            $ex('Bench Press')    => ['sets' => 4, 'reps' => 10, 'duration_minutes' => null, 'order' => 1],
            $ex('Deadlift')       => ['sets' => 4, 'reps' => 8,  'duration_minutes' => null, 'order' => 2],
            $ex('Pull Up')        => ['sets' => 3, 'reps' => 8,  'duration_minutes' => null, 'order' => 3],
            $ex('Overhead Press') => ['sets' => 3, 'reps' => 10, 'duration_minutes' => null, 'order' => 4],
        ]);


        $plan3 = WorkoutPlan::create([
            'goal_id'     => $gainMuscle->id,
            'name'        => 'Advanced Strength',
            'description' => 'Heavy compound lifts for maximum strength.',
            'difficulty'  => 'advanced',
        ]);

        $plan3->exercises()->attach([
            $ex('Deadlift')    => ['sets' => 5, 'reps' => 5, 'duration_minutes' => null, 'order' => 1],
            $ex('Bench Press') => ['sets' => 5, 'reps' => 5, 'duration_minutes' => null, 'order' => 2],
            $ex('Squat')       => ['sets' => 5, 'reps' => 5, 'duration_minutes' => null, 'order' => 3],
        ]);
    }
}