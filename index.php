<?php

require_once __DIR__ . str_replace('\\', DIRECTORY_SEPARATOR, '\src\Helper\functions.php');
require_once __DIR__ . str_replace('\\', DIRECTORY_SEPARATOR, '\vendor\autoload.php');

use Azous\Routes\Route;

Route::get('/gamblerUser/getAll/{auth}', 'GamblerUserController@getAll')->auth([1]);
Route::get('/comands/{command}', 'CommandController@index');

Route::group(['prefix' => '/goal'], [
    Route::get('/getAll', 'GoalController@getAll'),
    Route::get('/getById/{id}', 'GoalController@getById'),
    Route::post('/register', 'GoalController@registerForRequest')->auth()
]);

Route::group(['prefix' => '/gambler'], [
    Route::get('/getAll', 'GamblerController@getAll'),
    Route::get('/getById/{id}', 'GamblerController@getById'),
    Route::post('/register', 'GamblerController@registerForRequest')->auth()
]);

Route::group(['prefix' => '/team'], [
    Route::get('/getAll', 'TeamController@getAll'),
    Route::get('/getById/{id}', 'TeamController@getById'),
    Route::post('/register', 'TeamController@registerForRequest')->auth()
]);

Route::group(['prefix' => '/player'], [
    Route::get('/getAll', 'PlayerController@getAll'),
    Route::get('/getById/{id}', 'PlayerController@getById'),
    Route::post('/register', 'PlayerController@registerForRequest')->auth()
]);

Route::group(['prefix' => '/country'], [
    Route::get('/getAll', 'CountryController@getAll'),
    Route::get('/getById/{id}', 'CountryController@getById'),
    Route::post('/register', 'CountryController@registerForRequest')->auth()
]);

Route::group(['prefix' => '/game'], [
    Route::get('/getAll', 'GameController@getAll'),
    Route::get('/getById/{id}', 'GameController@getById'),
    Route::post('/register', 'GameController@registerForRequest')->auth()
]);

Route::run();