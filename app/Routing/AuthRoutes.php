<?php

namespace App\Routing;


use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class AuthRoutes implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        Route::middleware(['web', 'guest'])
            ->group(function () {
                Route::controller(LoginController::class)->group(function () {
                    Route::get('login', 'page')->name('login.page');
                    Route::post('login', 'handle')->middleware('throttle:auth')->name('login.handle');
                    Route::delete('logout', 'logout')->name('logout');
                });

                Route::controller(RegisterController::class)->group(function () {
                    Route::get('signup', 'page')->name('register.page');
                    Route::post('signup', 'handle')->middleware('throttle:auth')->name('register.handle');
                });

                Route::controller(ForgotPasswordController::class)->group(function () {
                    Route::get('forgot-password', 'page')->name('forgot.page');
                    Route::post('forgot-password', 'handle')->name('forgot.handle');
                });

                Route::controller(ResetPasswordController::class)->group(function () {
                    Route::get('reset-password/{token}', 'page')->name('password.reset');
                    Route::post('reset-password', 'handle')->name('password.reset.handle');
                });

                Route::controller(SocialAuthController::class)->group(function () {
                    Route::get('/auth/socialite/{driver}', 'redirect')->name('socialite.redirect');
                    Route::get('/auth/socialite/{driver}/callback', 'callback')->name('socialite.callback');
                });
            })
        ;
    }
}
