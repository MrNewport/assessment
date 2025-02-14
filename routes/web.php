<?php

use Illuminate\Support\Facades\Route;

// Catch-All for Vue Frontend (But Exclude API Calls)
Route::get('/{any}', function () {
    return view('cards.card'); // Serves Vue app
})->where('any', '^(?!api).*'); // Exclude API routes
