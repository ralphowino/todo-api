<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


/** @var Route $router */
$router = App::make('router');

$router->api(['protected'=>true, 'version'=>'v1', 'prefix' => 'api/v1'], function() use($router){
    $router->delete('todo/{id}/archive','Ralphowino\Tutorials\Todo\Http\Controllers\TodosController@archive');
    $router->put('todo/{id}/restore','Ralphowino\Tutorials\Todo\Http\Controllers\TodosController@restore');
    $router->resource('todo','Ralphowino\Tutorials\Todo\Http\Controllers\TodosController');
});


