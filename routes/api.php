<?php

use App\Http\Controllers\CardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/cards/{card}', [CardController::class, 'show']); // API to fetch a card
Route::post('/cards', [CardController::class, 'store']); // API to create a card
Route::put('/cards/{card}', [CardController::class, 'update']); // API to update a card
