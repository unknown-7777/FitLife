<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ExerciseCategory;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [

            ['category' => 'Chest', 'name' => 'Push Up',          'muscle' => 'Chest, Triceps',     'difficulty' => 'beginner',     'calories' => 7,  'equipment' => 'None'],
            ['category' => 'Chest', 'name' => 'Bench Press',       'muscle' => 'Chest, Shoulders',   'difficulty' => 'intermediate', 'calories' => 8,  'equipment' => 'Barbell, Bench'],
            ['category' => 'Chest', 'name' => 'Incline Dumbbell',  'muscle' => 'Upper Chest',        'difficulty' => 'intermediate', 'calories' => 7,  'equipment' => 'Dumbbells, Bench'],


            ['category' => 'Back', 'name' => 'Pull Up',           'muscle' => 'Back, Biceps',       'difficulty' => 'intermediate', 'calories' => 9,  'equipment' => 'Pull-up Bar'],
            ['category' => 'Back', 'name' => 'Deadlift',          'muscle' => 'Full Back, Legs',    'difficulty' => 'advanced',     'calories' => 11, 'equipment' => 'Barbell'],
            ['category' => 'Back', 'name' => 'Bent Over Row',     'muscle' => 'Mid Back',           'difficulty' => 'intermediate', 'calories' => 8,  'equipment' => 'Barbell'],


            ['category' => 'Legs', 'name' => 'Squat',             'muscle' => 'Quads, Glutes',      'difficulty' => 'beginner',     'calories' => 9,  'equipment' => 'None'],
            ['category' => 'Legs', 'name' => 'Lunges',            'muscle' => 'Quads, Hamstrings',  'difficulty' => 'beginner',     'calories' => 7,  'equipment' => 'None'],
            ['category' => 'Legs', 'name' => 'Leg Press',         'muscle' => 'Quads, Glutes',      'difficulty' => 'intermediate', 'calories' => 8,  'equipment' => 'Leg Press Machine'],


            ['category' => 'Core', 'name' => 'Plank',             'muscle' => 'Core, Shoulders',    'difficulty' => 'beginner',     'calories' => 5,  'equipment' => 'None'],
            ['category' => 'Core', 'name' => 'Crunches',          'muscle' => 'Abs',                'difficulty' => 'beginner',     'calories' => 5,  'equipment' => 'None'],
            ['category' => 'Core', 'name' => 'Russian Twist',     'muscle' => 'Obliques',           'difficulty' => 'intermediate', 'calories' => 6,  'equipment' => 'None'],


            ['category' => 'Cardio', 'name' => 'Running',         'muscle' => 'Full Body',          'difficulty' => 'beginner',     'calories' => 11, 'equipment' => 'None'],
            ['category' => 'Cardio', 'name' => 'Jump Rope',       'muscle' => 'Full Body, Calves',  'difficulty' => 'beginner',     'calories' => 12, 'equipment' => 'Jump Rope'],
            ['category' => 'Cardio', 'name' => 'Cycling',         'muscle' => 'Legs, Cardio',       'difficulty' => 'beginner',     'calories' => 9,  'equipment' => 'Bike'],


            ['category' => 'Shoulders', 'name' => 'Overhead Press', 'muscle' => 'Shoulders, Triceps', 'difficulty' => 'intermediate', 'calories' => 7, 'equipment' => 'Barbell'],
            ['category' => 'Shoulders', 'name' => 'Lateral Raise',  'muscle' => 'Side Delts',         'difficulty' => 'beginner',     'calories' => 5, 'equipment' => 'Dumbbells'],


            ['category' => 'Arms', 'name' => 'Bicep Curl',        'muscle' => 'Biceps',             'difficulty' => 'beginner',     'calories' => 5,  'equipment' => 'Dumbbells'],
            ['category' => 'Arms', 'name' => 'Tricep Dips',       'muscle' => 'Triceps',            'difficulty' => 'beginner',     'calories' => 6,  'equipment' => 'Bench or Chair'],
        ];

        foreach ($exercises as $ex) {
            $category = ExerciseCategory::where('name', $ex['category'])->first();

            Exercise::create([
                'exercise_category_id'      => $category->id,
                'name'                      => $ex['name'],
                'muscle_group'              => $ex['muscle'],
                'difficulty'                => $ex['difficulty'],
                'calories_burned_per_minute'=> $ex['calories'],
                'equipment_needed'          => $ex['equipment'],
                'description'               => 'Standard ' . $ex['name'] . ' exercise.',
            ]);
        }
    }
}