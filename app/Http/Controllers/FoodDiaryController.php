<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodLog;
use App\Models\FoodLogItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodDiaryController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', today()->toDateString());


        $logs = FoodLog::where('user_id', Auth::id())
            ->where('log_date', $date)
            ->with('items.food')
            ->get()
            ->keyBy('meal_type');


        $foods = Food::with('category')->orderBy('name')->get();


        $totals = [
            'calories'      => 0,
            'protein'       => 0,
            'carbohydrates' => 0,
            'fat'           => 0,
        ];

        foreach ($logs as $log) {
            foreach ($log->items as $item) {
                $totals['calories']      += $item->food->calories      * $item->quantity;
                $totals['protein']       += $item->food->protein       * $item->quantity;
                $totals['carbohydrates'] += $item->food->carbohydrates * $item->quantity;
                $totals['fat']           += $item->food->fat           * $item->quantity;
            }
        }

        $totals = array_map(fn($v) => round($v, 1), $totals);

        $mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];

        return view('food.diary', compact('logs', 'foods', 'date', 'totals', 'mealTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_id'   => 'required|exists:foods,id',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'quantity'  => 'required|numeric|min:0.1|max:100',
            'date'      => 'required|date',
        ]);


        $log = FoodLog::firstOrCreate([
            'user_id'   => Auth::id(),
            'log_date'  => $validated['date'],
            'meal_type' => $validated['meal_type'],
        ]);


        FoodLogItem::create([
            'food_log_id' => $log->id,
            'food_id'     => $validated['food_id'],
            'quantity'    => $validated['quantity'],
        ]);

        return back()->with('success', 'Food added to diary!');
    }

    public function destroy(FoodLogItem $foodLogItem)
    {

        abort_if($foodLogItem->foodLog->user_id !== Auth::id(), 403);

        $foodLogItem->delete();

        return back()->with('success', 'Food item removed.');
    }
}