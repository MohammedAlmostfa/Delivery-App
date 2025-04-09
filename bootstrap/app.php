<?php

use App\Http\Middleware\SetLanguage;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\SecurityMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use CodingPartners\TranslaGenius\Middleware\SetLocale;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
     SetLocale::class,
 ]);

        $middleware->alias([
            'jwt' => JwtMiddleware::class,

        ]);
        $middleware->append([
                'setlan'=>SetLanguage::class,
               'security' => SecurityMiddleware::class,

            ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
