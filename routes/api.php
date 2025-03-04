<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth.session'])->group(function () {
    Route::apiResource('tasks', TaskController::class);
});
