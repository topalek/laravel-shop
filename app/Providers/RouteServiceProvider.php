<?php

namespace App\Providers;

use App\Contracts\RouteRegistrar;
use App\Routing\AppRoutes;
use App\Routing\AuthRoutes;
use App\Routing\CatalogRoutes;
use http\Exception\RuntimeException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    protected array $registrars = [
        AppRoutes::class,
        AuthRoutes::class,
        CatalogRoutes::class,
    ];

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        //        $this->routes(function (Registrar $router) {
        //            $this->mapRoutes($router, $this->registrars);
        //        });
        $this->routes(function () {
            Route::middleware('api')
                 ->prefix('api')
                 ->group(base_path('routes/api.php'))
            ;

            Route::middleware('web')
                 ->group(base_path('routes/web.php'))
            ;
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(500)
                        ->by($request->user()?->id ?: $request->ip())
                        ->response(fn(Request $request, array $headers) => response('Take it easy', Response::HTTP_TOO_MANY_REQUESTS, $head))
            ;
        });

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapRoutes(Registrar $router, array $registrars): void
    {
        foreach ($registrars as $registrar) {
            if (!class_exists($registrar) || !is_subclass_of($registrar, RouteRegistrar::class)) {
                throw new RuntimeException(sprintf("Cannot map routes '%s', it's not valid routes class.", $registrar));
            }

            (new $registrar)->map($router);
        }
    }
}
