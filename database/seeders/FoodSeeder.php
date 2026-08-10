<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\FoodCategory;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [

            ['category' => 'Proteins', 'name' => 'Chicken Breast',  'calories' => 165, 'protein' => 31, 'carbs' => 0,  'fat' => 3.6, 'serving' => 100],
            ['category' => 'Proteins', 'name' => 'Eggs',            'calories' => 155, 'protein' => 13, 'carbs' => 1,  'fat' => 11,  'serving' => 100],
            ['category' => 'Proteins', 'name' => 'Tuna (canned)',   'calories' => 116, 'protein' => 26, 'carbs' => 0,  'fat' => 1,   'serving' => 100],
            ['category' => 'Proteins', 'name' => 'Salmon',          'calories' => 208, 'protein' => 20, 'carbs' => 0,  'fat' => 13,  'serving' => 100],


            ['category' => 'Grains & Carbs', 'name' => 'White Rice',   'calories' => 130, 'protein' => 2.7, 'carbs' => 28, 'fat' => 0.3, 'serving' => 100],
            ['category' => 'Grains & Carbs', 'name' => 'Brown Rice',   'calories' => 112, 'protein' => 2.6, 'carbs' => 24, 'fat' => 0.9, 'serving' => 100],
            ['category' => 'Grains & Carbs', 'name' => 'Oats',         'calories' => 389, 'protein' => 17,  'carbs' => 66, 'fat' => 7,   'serving' => 100],
            ['category' => 'Grains & Carbs', 'name' => 'Whole Bread',  'calories' => 247, 'protein' => 13,  'carbs' => 41, 'fat' => 4,   'serving' => 100],


            ['category' => 'Vegetables', 'name' => 'Broccoli',   'calories' => 34,  'protein' => 2.8, 'carbs' => 7,  'fat' => 0.4, 'serving' => 100],
            ['category' => 'Vegetables', 'name' => 'Spinach',    'calories' => 23,  'protein' => 2.9, 'carbs' => 3.6,'fat' => 0.4, 'serving' => 100],
            ['category' => 'Vegetables', 'name' => 'Carrot',     'calories' => 41,  'protein' => 0.9, 'carbs' => 10, 'fat' => 0.2, 'serving' => 100],


            ['category' => 'Fruits', 'name' => 'Banana',  'calories' => 89,  'protein' => 1.1, 'carbs' => 23, 'fat' => 0.3, 'serving' => 100],
            ['category' => 'Fruits', 'name' => 'Apple',   'calories' => 52,  'protein' => 0.3, 'carbs' => 14, 'fat' => 0.2, 'serving' => 100],
            ['category' => 'Fruits', 'name' => 'Orange',  'calories' => 47,  'protein' => 0.9, 'carbs' => 12, 'fat' => 0.1, 'serving' => 100],


            ['category' => 'Dairy', 'name' => 'Whole Milk',      'calories' => 61,  'protein' => 3.2, 'carbs' => 4.8, 'fat' => 3.3, 'serving' => 100],
            ['category' => 'Dairy', 'name' => 'Greek Yogurt',    'calories' => 59,  'protein' => 10,  'carbs' => 3.6, 'fat' => 0.4, 'serving' => 100],
            ['category' => 'Dairy', 'name' => 'Cheddar Cheese',  'calories' => 403, 'protein' => 25,  'carbs' => 1.3, 'fat' => 33,  'serving' => 100],


            ['category' => 'Fats & Oils', 'name' => 'Olive Oil',  'calories' => 884, 'protein' => 0, 'carbs' => 0, 'fat' => 100, 'serving' => 100],
            ['category' => 'Fats & Oils', 'name' => 'Almonds',    'calories' => 579, 'protein' => 21, 'carbs' => 22, 'fat' => 50, 'serving' => 100],


            ['category' => 'Snacks', 'name' => 'Protein Bar',   'calories' => 200, 'protein' => 20, 'carbs' => 25, 'fat' => 5, 'serving' => 60],
            ['category' => 'Snacks', 'name' => 'Rice Cakes',    'calories' => 387, 'protein' => 8,  'carbs' => 81, 'fat' => 3, 'serving' => 100],
        ];

        foreach ($foods as $food) {
            $category = FoodCategory::where('name', $food['category'])->first();

            Food::create([
                'food_category_id' => $category->id,
                'name'             => $food['name'],
                'calories'         => $food['calories'],
                'protein'          => $food['protein'],
                'carbohydrates'    => $food['carbs'],
                'fat'              => $food['fat'],
                'serving_size'     => $food['serving'],
            ]);
        }
    }
}