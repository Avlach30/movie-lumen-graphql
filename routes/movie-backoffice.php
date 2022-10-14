<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->group(['prefix' => 'api/v1/backoffice',  'middleware' => 'auth'], function () use ($router) {
    $router->post('movies', 'MovieController@CreateNewMovieWithTags');
    $router->get('movies', 'MovieController@GetAllMovieWithTags');

    $router->post('studios', 'StudioController@CreateNewStudio');
});