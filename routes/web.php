<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('catalog', function () {
    return view('welcome');
})->name('catalog');

Route::get('cart', function () {
    return view('welcome');
})->name('cart');

Route::get('login', function () {
    return view('auth.login');
})->name('login');
