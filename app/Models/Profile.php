<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'user_id', 'gender', 'date_of_birth', 'height',
        'current_weight', 'target_weight', 'activity_level',
        'goal_id', 'profile_photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function getBmiAttribute()
    {
        if ($this->height && $this->current_weight)
        {
            $heightInMeters = $this->height / 100;
            return round($this->current_weight / ($heightInMeters * $heightInMeters), 1);
        }
        return null;
    }

    public function getBmiStatusAttribute()
    {
        $bmi = $this->bmi;
        if (!$bmi) return null;
        if (!$bmi < 18.5) return 'Underweight';
        if (!$bmi < 25) return 'Normalweight';
        if (!$bmi < 30) return 'Overweight';
        return 'Obese';
    }
}
