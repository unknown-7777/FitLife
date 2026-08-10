<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodLogItem extends Model
{
    use HasFactory;

    protected $fillable = ['food_log_id', 'food_id', 'quantity'];


    public function foodLog()
    {
        return $this->belongsTo(FoodLog::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }


    public function getCaloriesAttribute()
    {
        return round($this->food->calories * $this->quantity, 1);
    }

    public function getProteinAttribute()
    {
        return round($this->food->protein * $this->quantity, 1);
    }

    public function getCarbsAttribute()
    {
        return round($this->food->carbohydrates * $this->quantity, 1);
    }

    public function getFatAttribute()
    {
        return round($this->food->fat * $this->quantity, 1);
    }
}