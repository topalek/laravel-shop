<?php

namespace App\Routing;


use App\Contracts\RouteRegistrar;
use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class AppRoutes implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        Route::middleware('web')
             ->group(function () {
                 Route::get('/', [HomeController::class, 'index'])->name('home');
                 Route::get('catalog', function () {
                     return view('index');
                 })->name('catalog');

                 Route::get('cart', function () {
                     return view('index');
                 })->name('cart');
             })
        ;
    }
}
