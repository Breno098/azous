<?php

require_once __DIR__ . str_replace('\\', DIRECTORY_SEPARATOR, '\src\Helper\functions.php');
require_once __DIR__ . str_replace('\\', DIRECTORY_SEPARATOR, '\vendor\autoload.php');

Azous\Routes\Routes::get('/team/getAll'   , 'TeamController@getAll');
Azous\Routes\Routes::get('/team/getById/{id}'   , 'TeamController@getById');

Azous\Routes\Routes::get('/player/getAll' , 'PlayerController@getAll');
Azous\Routes\Routes::get('/player/getById/{id}' , 'PlayerController@getById');

Azous\Routes\Routes::get('/country/getAll', 'CountryController@getAll');
Azous\Routes\Routes::get('/country/getById/{id}', 'CountryController@getById');

Azous\Routes\Routes::get('/game/getAll'   , 'GameController@getAll');
Azous\Routes\Routes::get('/game/getById/{id}'   , 'GameController@getById');

Azous\Routes\Routes::get('/gambler/getAll', 'GamblerController@getAll');
Azous\Routes\Routes::get('/gambler/getById/{id}', 'GamblerController@getById');

Azous\Routes\Routes::get('/goal/getAll'   , 'GoalController@getAll');
Azous\Routes\Routes::get('/goal/getById/{id}'   , 'GoalController@getById');

Azous\Routes\Routes::get('/gamblerUser/getAll'   , 'GamblerUserController@getAll')->auth();

Azous\Routes\Routes::post('/team/register', 'TeamController@registerForRequest')->auth();
Azous\Routes\Routes::post('/player/register', 'TeamController@registerForRequest')->auth();
Azous\Routes\Routes::post('/country/register', 'TeamController@registerForRequest')->auth();
Azous\Routes\Routes::post('/game/register', 'TeamController@registerForRequest')->auth();
Azous\Routes\Routes::post('/gambler/register', 'TeamController@registerForRequest')->auth();
Azous\Routes\Routes::post('/goal/register', 'TeamController@registerForRequest')->auth();

Azous\Routes\Routes::get('/comands/{command}', 'CommandController@index');

Azous\Routes\Routes::run();