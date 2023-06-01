<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ReservationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'deleteExpiredReservations'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{bookId}', [BookController::class, 'show'])->middleware(['lendingBook', 'reservationBook'])->name('books.show');
    Route::get('/books/tags/{tagId}', [BookController::class, 'bookTag'])->name('books.tags.index');

    Route::get('/lendings', [LendingController::class, 'index'])->name('lendings.index');
    Route::post('/lendings', [LendingController::class, 'store'])->name('lendings.store');
    Route::put('/lendings/{lendingId}/return', [LendingController::class, 'update'])->name('lendings.update');
    Route::get('/lendings/{lendingId}', [LendingController::class, 'show'])->name('lendings.show');

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservationId}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservationId}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

});

require __DIR__.'/auth.php';
