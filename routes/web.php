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
    $router->put('family/update', 'FamilyController@update');
  });
  Route::group(['middleware' => 'auth'], function () use ($router) {
    //PROFILE
    $router->get('profile', 'UserController@profile');
    $router->put('profile/edit', 'UserController@editProfile');
    $router->put('profile/photo', 'UserController@editPhoto');
    $router->put('profile/password', 'UserController@editPassword');
    //GET USER
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');
    //EVENT
    $router->get('event', 'EventController@index');
    $router->post('event/create', 'EventController@store');
    $router->put('event/update/{id}', 'EventController@update');
    $router->delete('event/delete/{id}', 'EventController@destroy');
  });
  $router->post('register', 'AuthController@register'); // register parent
  $router->post('login', 'AuthController@login'); // login all
});
