<?php

namespace App\Routing;


use App\Contracts\RouteRegistrar;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class AppRoutes implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        Route::middleware('web')
             ->group(function () {
                 Route::get('/', [HomeController::class, 'index'])->name('home');
                 Route::get(
                     '/storage/images/{dir}/{method}/{size}/{file}',
                     ThumbnailController::class
                 )
                      ->where('method', 'resize|crop|fit')
                      ->where('size', '\d+x\d+')
                     ->where('file', '.+\.(png|jpg|jpeg|svg|gif|bmp)$')
                      ->name('thumbnail')
                 ;

                 Route::get('cart', function () {
                     return view('index');
                 })->name('cart');
             })
        ;
    }
}
