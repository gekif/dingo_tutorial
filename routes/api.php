<?php

use Dingo\Api\Routing\Router;

$router = app(Router::class);

$router->version('v1', function (Router $router) {
    $router->group(['namespace' => 'App\Http\Controllers'], function ($router) {

        $router->get('test', 'ServerController@test');

        // System status
        $router->group(['prefix' => 'status'], function (Router $router) {
            $router->get('ping', 'ServerController@ping');
            $router->get('version', 'ServerController@version');
        });

        // Weather
        $router->group(['prefix' => 'weather'], function (Router $router) {
            $router->get('city/{city}/current', 'QueryController@current');
            $router->get('city/{city}/all', 'QueryController@all');
        });

        $router->resource('users', 'UsersController');

        // Auth routes
        $router->group(['prefix' => 'auth'], function (Router $router) {
            $router->post('login', 'Auth\AuthsController@login');
            $router->patch('refresh', 'Auth\AuthsController@refreshToken');
            $router->delete('invalidate', 'Auth\AuthsController@deleteInvalidate');
            $router->post('register', 'Auth\AuthsController@register');

            $router->group(['middleware' => ['api.auth']], function (Router $router) {
                $router->get('user', 'Auth\AuthsController@getUser');
            });
        });


    });
});