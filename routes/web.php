<?php

use Illuminate\Support\Facades\Route;


// API Routes (Ensure API Calls Work)
Route::prefix('api')->group(base_path('routes/api.php'));

// Catch-All for Vue Frontend (But Exclude API Calls)
Route::get('/{any}', function () {
    return view('cards.card'); // Serves Vue app
})->where('any', '^(?!api).*'); // Exclude API routes
