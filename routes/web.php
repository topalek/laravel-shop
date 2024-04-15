<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('catalog', function () {
    return view('welcome');
})->name('catalog');

Route::get('cart', function () {
    return view('welcome');
})->name('cart');

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('index');
    Route::post('login', 'login')->name('login');
    Route::delete('logout', 'logout')->name('logout');
    Route::get('register', 'signUp')->name('signUp');
    Route::post('register', 'register')->name('register');
    Route::get('forgot-password', 'passwordResetRequest')->middleware('guest')->name('forgotPassword');
    Route::post('forgot-password', 'forgotPassword')->middleware('guest')->name('password.reset.email');
    Route::get('reset-password/{token}', 'resetPassword')->middleware('guest')->name('password.reset');
    Route::post('reset-password', 'passwordUpdate')->name('password.update');
    Route::get('reset-password', 'resetPassword')->name('resetPassword');
    Route::get('/auth/socialite/github', 'github')->name('github');
    Route::get('/auth/socialite/github/callback', 'githubCallback')->name('githubCallback');
});
