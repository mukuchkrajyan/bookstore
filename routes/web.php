<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReservationController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');


Route::post('/reservations',[ReservationController::class,'store'])->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/books',[BookController::class,'index'])->name('books.index');
    Route::get('/dashboard/books/create',[BookController::class,'create'])->name('books.create');
    Route::post('/dashboard/books',[BookController::class,'store'])->name('books.store');
    Route::get('/dashboard/books/show/{id}',[BookController::class,'show'])->name('books.show');

});

require __DIR__.'/auth.php';
