<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ReservationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/books', [BookController::class, 'index']);

Route::middleware('auth.token')->group(function () {
    Route::post('/reservations', [ReservationController::class, 'store']);
});