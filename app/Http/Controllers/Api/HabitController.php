<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Habit;
use App\Models\HabitLog;

class HabitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Habit::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' -> 'required|string|max:255',
            'user_id' -> 'required|exists:users_id',
        ]);

        $habit = Habit::create($validated);
        return response()->json($habit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($habit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $habit->update($request->all());
        return response()->json($habit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $habit->delete();
        return response()->json(null, 204);
    }

    public function complete(Habit $habit)
    {
        // Prevent duplicate log for same day
        $today = now()->toDateString();
        $existingLog = $habit->logs()->whereDate('created_at', $today)->first();

        if($existingLog) {
            return response()->json(['message' -> 'Habit already completed today.'], 400);
        }

        $log = HabitLog::create([
            'habit_id' -> $habit->id
        ]);

        return response()->json($log, 201);
    }
}
