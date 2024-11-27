<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        // Register route-specific middleware here
        $router->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
        $router->aliasMiddleware('student', \App\Http\Middleware\StudentMiddleware::class);
        $router->aliasMiddleware('teacher', \App\Http\Middleware\TeacherMiddleware::class);
        $router->aliasMiddleware('parent', \App\Http\Middleware\ParentMiddleware::class);
    }

    public function register()
    {
        //
    }
}
