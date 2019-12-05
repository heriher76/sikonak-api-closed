<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
  Route::group(['middleware' => ['auth', 'role:parent']], function () use ($router) {
    $router->post('register-child', 'AuthController@registerChild');
    $router->post('family/create', 'FamilyController@store');
  });
  Route::group(['middleware' => 'auth'], function () use ($router) {
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');
  });
  $router->post('register', 'AuthController@register'); // register parent
  $router->post('login', 'AuthController@login'); // login all
});
