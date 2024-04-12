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
    Route::get('register', 'signUp')->name('signUp');
    Route::post('register', 'register')->name('register');
    Route::get('forgot-password', 'forgotPassword')->name('forgotPassword');
    Route::get('reset-password', 'resetPassword')->name('resetPassword');

});
