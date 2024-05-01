<?php

namespace Domain\Auth\Routing;


use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class AuthRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        Route::middleware('web')
             ->group(function () {
                 Route::controller(LoginController::class)->group(function () {
                     Route::get('login', 'page')->name('login.page');
                     Route::post('login', 'handle')->middleware('throttle:auth')->name('login');
                 });
                 Route::controller(RegisterController::class)->group(function () {
                     Route::get('register', 'page')->name('register.page');
                     Route::post('register', 'handle')->middleware('throttle:auth')->name('register');
                 });


                 Route::delete('logout', 'logout')->name('logout');
                 Route::get('register', 'signUp')->name('signUp');
                 Route::post('register', 'register')
                      ->middleware('throttle:auth')
                      ->name('register')
                 ;
                 Route::get('forgot-password', 'passwordResetRequest')->middleware('guest')->name('forgotPassword');
                 Route::post('forgot-password', 'forgotPassword')->middleware('guest')->name('password.reset.email');
                 Route::get('reset-password/{token}', 'resetPassword')->middleware('guest')->name('password.reset');
                 Route::post('reset-password', 'passwordUpdate')->name('password.update');
                 Route::get('reset-password', 'resetPassword')->name('resetPassword');
                 Route::get('/auth/socialite/github', 'github')->name('github');
                 Route::get('/auth/socialite/github/callback', 'githubCallback')->name('githubCallback');
             })
        ;
    }
}
