<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Category\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegisterUserController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/categories', [CategoriesController::class, 'index']);
});
