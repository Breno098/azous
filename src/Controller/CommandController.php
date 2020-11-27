<?php

namespace Azuos\Controller;

use Azuos\Http\Request;
use Azuos\Database\Schema;
use Azuos\Database\Database;
use Azuos\Tools\AzStr;

class CommandController extends Controller
{
    private $commands = [
        'create-all-schemas' => 'createAllSchemas',
        'factory-all-schemas' => 'factoryAllSchemas',
        'drop-all-schemas' => 'dropAllSchemas'
    ];

    private $schemas = [
        \Azuos\Schema\Country::class,
        \Azuos\Schema\Team::class,
        \Azuos\Schema\Gambler::class,
        \Azuos\Schema\Game::class,
        \Azuos\Schema\Player::class,
        \Azuos\Schema\Goal::class,
    ];
    
    public function index(Request $req)
    {
        // echo (\DateTime::createFromFormat('U.u', microtime(true)))->format("U_u");
        if(isset($this->commands[ $req->command ])){
            $functionCommand = $this->commands[ $req->command ];
            return $this->$functionCommand();
        }
    }
    
    private function createAllSchemas()
    {
        foreach ($this->schemas as $schema) {
            (new $schema)->create();
        }
    }

    private function dropAllSchemas()
    {
        foreach (array_reverse($this->schemas) as $schema) {
            (new $schema)->drop();
        }
    }

    private function factoryAllSchemas()
    {
        foreach ($this->schemas as $schema) {
            (new $schema)->factory();
        }
    }
}