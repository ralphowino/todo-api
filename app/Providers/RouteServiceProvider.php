<?php namespace Ralphowino\Tutorials\Todo\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    function register()
    {
        require_once app_path().'/Http/routes.php';
    }
}