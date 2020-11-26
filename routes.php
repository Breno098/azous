<?php

use Azuos\Routes\Route;

Route::get('/gamblerUser/getAll/{auth}', 'GamblerUserController@getAll')->auth();
Route::get('/comands/{command}', 'CommandController@index');

Route::group(['prefix' => '/goal'], [
    Route::get('/getAll', 'GoalController@getAll'),
    Route::get('/getById/{id}', 'GoalController@getById'),
    Route::get('/getByRange/{offset}/{limit}', 'GoalController@getByRange'),
    Route::post('/register', 'GoalController@registerForRequest')->auth()
]);

Route::group(['prefix' => '/gambler'], [
    Route::get('/getAll', 'GamblerController@getAll'),
    Route::get('/getById/{id}', 'GamblerController@getById'),
    Route::get('/getByRange/{offset}/{limit}', 'GamblerController@getByRange'),
    Route::post('/register', 'GamblerController@registerForRequest')->auth()
]);

Route::group(['prefix' => '/team'], [
    Route::get('/getAll', 'TeamController@getAll'),
    Route::get('/getById/{id}', 'TeamController@getById'),
    Route::get('/getByRange/{offset}/{limit}', 'TeamController@getByRange'),
    Route::post('/register', 'TeamController@registerForRequest')->auth()
]);

Route::group(['prefix' => '/player'], [
    Route::get('/getAll', 'PlayerController@getAll'),
    Route::get('/getById/{id}', 'PlayerController@getById'),
    Route::get('/getByRange/{offset}/{limit}', 'PlayerController@getByRange'),
    Route::post('/register', 'PlayerController@registerForRequest')->auth()
]);

Route::group(['prefix' => '/country'], [
    Route::get('/getAll', 'CountryController@getAll'),
    Route::get('/getById/{id}', 'CountryController@getById'),
    Route::get('/getByRange/{offset}/{limit}', 'CountryController@getByRange'),
    Route::post('/register', 'CountryController@registerForRequest')->auth()
]);

Route::group(['prefix' => '/game'], [
    Route::get('/getAll', 'GameController@getAll'),
    Route::get('/getById/{id}', 'GameController@getById'),
    Route::get('/getByRange/{offset}/{limit}', 'GameController@getByRange'),
    Route::post('/register', 'GameController@registerForRequest')->auth()
]);

Route::run();