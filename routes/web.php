<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\JournalController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/journal');

Route::get('/journal', [JournalController::class, 'index'])->name('journal.index')->middleware('auth');
Route::get('/journal/{journal}', [JournalController::class, 'show'])->name('journal.show')->middleware('auth');

Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

Route::post('/logout', [SessionController::class, 'destroy']);
