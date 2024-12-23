<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::apiResources([
    'tasks' => TaskController::class,
]);

Route::post('tasks/markAsCompleted', [TaskController::class, 'markAsCompleted']);
Route::post('tasks/markAsPending', [TaskController::class, 'markAsPending']);