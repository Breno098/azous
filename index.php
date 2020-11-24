<?php

require_once __DIR__ . str_replace('\\', DIRECTORY_SEPARATOR, '\src\Helper\functions.php');
require_once __DIR__ . str_replace('\\', DIRECTORY_SEPARATOR, '\vendor\autoload.php');

// Azous\Routes\Routes::get('/{name}/{country_id}', 'PlayerController@gets');

Azous\Routes\Routes::post('/team/register', 'TeamController@register');
Azous\Routes\Routes::get('/team/gets', 'TeamController@getAll');

Azous\Routes\Routes::get('/country/gets', 'CountryController@getAll');
Azous\Routes\Routes::get('/country/store/{name}', 'CountryController@store');

Azous\Routes\Routes::get('/comands/{command}', 'CommandController@index');

Azous\Routes\Routes::run();
