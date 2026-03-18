<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::middleware(['auth', 'verified', 'api.token', 'redirect.if.admin'])->group(function () {

    Route::get('/user-interface', [HomeController::class, 'index'])
        ->name('home');

    // user reservation (API testing)
    Route::post('/reservations', [ReservationController::class, 'store']);

});


Route::middleware(['auth', 'admin'])->group(function () {

    // profile (verified users)
    Route::prefix('profile')->group(function () {

        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');

    });

    Route::get('/dashboard', fn() => view('dashboard'))
        ->name('dashboard');

    // books
    Route::prefix('dashboard/books')->group(function () {

        Route::get('/', [BookController::class, 'index'])->name('books.index');
        Route::get('/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/', [BookController::class, 'store'])->name('books.store');
        Route::get('/{id}', [BookController::class, 'show'])->name('books.show');

    });

    // reservations
    Route::prefix('dashboard/reservations')->group(function () {

        Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/{id}', [ReservationController::class, 'show'])->name('reservations.show');

        Route::post('/{id}/confirm', [ReservationController::class, 'confirm'])
            ->name('reservations.confirm');

        Route::post('/{id}/cancel', [ReservationController::class, 'cancel'])
            ->name('reservations.cancel');

    });

});

require __DIR__ . '/auth.php';
