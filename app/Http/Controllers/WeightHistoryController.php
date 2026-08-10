<?php

namespace App\Http\Controllers;

use App\Models\WeightHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightHistoryController extends Controller
{
    public function index()
    {
        $weights = WeightHistory::where('user_id', Auth::id())
            ->orderBy('recorded_at', 'desc')
            ->get();

        return view('weight.index', compact('weights'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'weight'      => 'required|numeric|min:20|max:500',
            'recorded_at' => 'required|date|before_or_equal:today',
            'notes'       => 'nullable|string|max:255',
        ]);

        WeightHistory::create([
            'user_id'     => Auth::id(),
            'weight'      => $validated['weight'],
            'recorded_at' => $validated['recorded_at'],
            'notes'       => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Weight recorded successfully!');
    }

    public function destroy(WeightHistory $weightHistory)
    {

        abort_if($weightHistory->user_id !== Auth::id(), 403);

        $weightHistory->delete();

        return back()->with('success', 'Weight entry deleted.');
    }
}