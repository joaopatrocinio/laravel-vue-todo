<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::apiResources([
    'tasks' => TaskController::class,
]);