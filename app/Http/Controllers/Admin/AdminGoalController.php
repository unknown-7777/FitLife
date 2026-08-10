<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminGoalController extends Controller
{
    public function index()
    {
        $goals = Goal::withCount('profiles')->get();
        return view('admin.goals.index', compact('goals'));
    }

    public function create()
    {
        return view('admin.goals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:goals,name',
            'description' => 'nullable|string',
        ]);

        Goal::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.goals.index')
            ->with('success', 'Goal created successfully.');
    }

    public function edit(Goal $goal)
    {
        return view('admin.goals.edit', compact('goal'));
    }

    public function update(Request $request, Goal $goal)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:goals,name,' . $goal->id,
            'description' => 'nullable|string',
        ]);

        $goal->update([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.goals.index')
            ->with('success', 'Goal updated successfully.');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();
        return redirect()->route('admin.goals.index')
            ->with('success', 'Goal deleted.');
    }
}