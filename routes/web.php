<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware('guest')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/login', [UserController::class, 'showLoginForm'])->name('user.showLoginForm');
        Route::post('/login', [UserController::class, 'login'])->name('user.login');
        Route::get('/register', [UserController::class, 'showRegisterForm'])->name('user.showRegisterForm');
        Route::post('/register', [UserController::class, 'register'])->name('user.register');
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/logout', function () {
            Auth::logout(); return redirect()->route('home.index');
        })->name('user.logout');
    });
});

Route::apiResource('message', MessageController::class)->names('message');
