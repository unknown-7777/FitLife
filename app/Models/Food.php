<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = 
    [
        'food_category_id', 'name', 'calories',
        'protein', 'carbohydrates', 'fat',
        'serving_size', 'image',
    ];

    public function category()
    {
        return $this->belongsTo(FoodCategory::class, 'food_category_id');
    }

    public function foodLogItems()
        {
            return $this->hasMany(FoodLogItem::class);
        }
}
