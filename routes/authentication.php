<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api/v1/auth'], function () use ($router) {
    $router->post('signup-customer', 'AuthController@SignUp');
    $router->post('admin/signup', 'AuthController@SignUp');
    $router->post('login', 'AuthController@login');
});
