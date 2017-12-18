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

$router->get('/', function () { 
	$res['success'] = true;
  	$res['result'] = "Hello there welcome to web api using lumen tutorial!";
  	return response($res);
});

$router->post('/login', 'LoginController@index');
$router->post('/register', 'UserController@register');
$router->get('/user/{id}', ['middleware' => 'auth', 'uses' =>  'UserController@get_user']);