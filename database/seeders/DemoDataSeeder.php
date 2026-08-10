<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Food;
use App\Models\FoodLog;
use App\Models\FoodLogItem;
use App\Models\User;
use App\Models\WeightHistory;
use App\Models\WorkoutLog;
use App\Models\WorkoutLogExercise;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'john@fitlife.com')->first();

        if (!$user) {
            $this->command->warn('Demo user not found. Run UserSeeder first.');
            return;
        }

        $this->seedWeightHistory($user);
        $this->seedFoodLogs($user);
        $this->seedWorkoutLogs($user);

        $this->command->info('Demo data seeded successfully!');
    }


    private function seedWeightHistory(User $user): void
    {

        $entries = [
            ['date' => now()->subWeeks(9)->toDateString(), 'weight' => 85.0],
            ['date' => now()->subWeeks(8)->toDateString(), 'weight' => 84.2],
            ['date' => now()->subWeeks(7)->toDateString(), 'weight' => 83.5],
            ['date' => now()->subWeeks(6)->toDateString(), 'weight' => 83.0],
            ['date' => now()->subWeeks(5)->toDateString(), 'weight' => 82.1],
            ['date' => now()->subWeeks(4)->toDateString(), 'weight' => 81.5],
            ['date' => now()->subWeeks(3)->toDateString(), 'weight' => 80.8],
            ['date' => now()->subWeeks(2)->toDateString(), 'weight' => 80.2],
            ['date' => now()->subWeeks(1)->toDateString(), 'weight' => 79.5],
            ['date' => now()->toDateString(),              'weight' => 79.0],
        ];

        foreach ($entries as $entry) {
            WeightHistory::firstOrCreate(
                ['user_id' => $user->id, 'recorded_at' => $entry['date']],
                ['weight'  => $entry['weight'], 'notes' => null]
            );
        }
    }


    private function seedFoodLogs(User $user): void
    {
        $meals = [
            'breakfast' => ['Oats', 'Whole Milk', 'Banana'],
            'lunch'     => ['Chicken Breast', 'Brown Rice', 'Broccoli'],
            'dinner'    => ['Salmon', 'White Rice', 'Spinach'],
            'snack'     => ['Greek Yogurt', 'Almonds'],
        ];

        for ($daysAgo = 6; $daysAgo >= 0; $daysAgo--) {
            $date = now()->subDays($daysAgo)->toDateString();

            foreach ($meals as $mealType => $foodNames) {
                $log = FoodLog::firstOrCreate([
                    'user_id'   => $user->id,
                    'log_date'  => $date,
                    'meal_type' => $mealType,
                ]);

                foreach ($foodNames as $foodName) {
                    $food = Food::where('name', $foodName)->first();
                    if (!$food) continue;

                    FoodLogItem::firstOrCreate([
                        'food_log_id' => $log->id,
                        'food_id'     => $food->id,
                    ], [
                        'quantity' => 1,
                    ]);
                }
            }
        }
    }


    private function seedWorkoutLogs(User $user): void
    {
        $workouts = [
            [
                'daysAgo'   => 4,
                'exercises' => [
                    ['name' => 'Push Up',    'sets' => 3, 'reps' => 15, 'weight' => null],
                    ['name' => 'Squat',      'sets' => 3, 'reps' => 20, 'weight' => null],
                    ['name' => 'Plank',      'sets' => 3, 'reps' => null, 'duration' => 1],
                ],
            ],
            [
                'daysAgo'   => 3,
                'exercises' => [
                    ['name' => 'Running',    'sets' => 1, 'reps' => null, 'duration' => 25],
                    ['name' => 'Jump Rope',  'sets' => 3, 'reps' => null, 'duration' => 5],
                ],
            ],
            [
                'daysAgo'   => 2,
                'exercises' => [
                    ['name' => 'Bench Press','sets' => 4, 'reps' => 10, 'weight' => 60],
                    ['name' => 'Pull Up',    'sets' => 3, 'reps' => 8,  'weight' => null],
                    ['name' => 'Bicep Curl', 'sets' => 3, 'reps' => 12, 'weight' => 15],
                ],
            ],
            [
                'daysAgo'   => 1,
                'exercises' => [
                    ['name' => 'Deadlift',   'sets' => 4, 'reps' => 8,  'weight' => 80],
                    ['name' => 'Squat',      'sets' => 4, 'reps' => 10, 'weight' => 70],
                    ['name' => 'Crunches',   'sets' => 3, 'reps' => 20, 'weight' => null],
                ],
            ],
            [
                'daysAgo'   => 0,
                'exercises' => [
                    ['name' => 'Push Up',    'sets' => 3, 'reps' => 20, 'weight' => null],
                    ['name' => 'Running',    'sets' => 1, 'reps' => null, 'duration' => 30],
                    ['name' => 'Plank',      'sets' => 3, 'reps' => null, 'duration' => 2],
                ],
            ],
        ];

        foreach ($workouts as $workout) {
            $date = now()->subDays($workout['daysAgo'])->toDateString();

            $log = WorkoutLog::firstOrCreate([
                'user_id'  => $user->id,
                'log_date' => $date,
            ], [
                'notes' => null,
            ]);

            foreach ($workout['exercises'] as $ex) {
                $exercise = Exercise::where('name', $ex['name'])->first();
                if (!$exercise) continue;

                WorkoutLogExercise::firstOrCreate([
                    'workout_log_id' => $log->id,
                    'exercise_id'    => $exercise->id,
                ], [
                    'sets'             => $ex['sets'],
                    'reps'             => $ex['reps'] ?? null,
                    'duration_minutes' => $ex['duration'] ?? null,
                    'weight_used'      => $ex['weight'] ?? null,
                ]);
            }
        }
    }
}