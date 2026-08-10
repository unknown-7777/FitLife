<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FoodCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Proteins', 'Vegetables', 'Fruits',
            'Grains & Carbs', 'Dairy', 'Fats & Oils', 'Snacks',
        ];

        foreach ($categories as $category) {
            FoodCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}