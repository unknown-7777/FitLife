<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Goal;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $admin = User::create([
            'name'     => 'Admin FitLife',
            'email'    => 'admin@fitlife.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);


        $user = User::create([
            'name'     => 'John Doe',
            'email'    => 'john@fitlife.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $goal = Goal::where('slug', 'lose-weight')->first();

        Profile::create([
            'user_id'          => $user->id,
            'gender'           => 'male',
            'date_of_birth'    => '1995-06-15',
            'height'           => 175,
            'current_weight'   => 85,
            'target_weight'    => 75,
            'activity_level'   => 'moderate',
            'goal_id'          => $goal->id,
        ]);
    }
}