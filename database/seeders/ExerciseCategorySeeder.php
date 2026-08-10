<?php

namespace Database\Seeders;

use App\Models\ExerciseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExerciseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Chest', 'Back', 'Shoulders',
            'Arms', 'Legs', 'Core', 'Cardio',
        ];

        foreach ($categories as $category) {
            ExerciseCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}