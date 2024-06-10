<?php

namespace App\Providers;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;
use View;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Vite::macro('image', fn(string $asset) => $this->asset("resources/images/$asset"));

        View::composer('*', function ($view) {
            $view->with(
                'menu',
                Menu::make()
                    ->add(MenuItem::make(route('home'), 'Главная'))
                    ->add(MenuItem::make(route('shop'), 'Каталог'))
                    ->add(MenuItem::make(route('cart'), 'Корзина'))
            );
        });
    }
}
