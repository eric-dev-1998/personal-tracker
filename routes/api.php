<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\HabitController;

Route::get('/health', function() {
    return response()->json([
        'status' => 'ok'
    ]);
});

Route::apiResource('tasks', TaskController::class);
Route::apiResource('habits', HabitController::class);
Route::post('habits/{habit}/complete', [HabitController:class, 'complete']);