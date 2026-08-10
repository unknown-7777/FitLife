<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'log_date', 'meal_type'];

    protected $casts = [
        'log_date' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(FoodLogItem::class);
    }


    public function getTotalCaloriesAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->food->calories * $item->quantity;
        });
    }
}