<?php

namespace Database\Seeders;

use App\Models\Goal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GoalSeeder extends Seeder
{
    public function run(): void
    {
        $goals = [
            ['name' => 'Lose Weight',         'description' => 'Burn fat and reduce body weight.'],
            ['name' => 'Gain Weight',         'description' => 'Increase body mass and size.'],
            ['name' => 'Gain Muscle',         'description' => 'Build lean muscle mass.'],
            ['name' => 'Maintain Weight',     'description' => 'Keep current weight stable.'],
            ['name' => 'Improve Endurance',   'description' => 'Boost stamina and cardiovascular fitness.'],
        ];

        foreach ($goals as $goal) {
            Goal::create([
                'name'        => $goal['name'],
                'slug'        => Str::slug($goal['name']),
                'description' => $goal['description'],
            ]);
        }
    }
}