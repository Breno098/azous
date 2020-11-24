<?php

namespace Azous\Controller;

use Azous\Http\Request;
use Azous\Database\Schema;
use Azous\Database\Database;
use Azous\Tools\TArray;

class CommandController extends Controller
{
    private $commands = [
        'create-all-schemas' => 'createAllSchemas',
        'factory-all-schemas' => 'factoryAllSchemas',
        'drop-all-schemas' => 'dropAllSchemas'
    ];

    private $schemas = [
        // 'user' => \Azous\Schema\User::class,
        \Azous\Schema\Country::class,
        \Azous\Schema\Team::class,
        \Azous\Schema\Gambler::class,
        \Azous\Schema\Game::class,
        \Azous\Schema\Player::class,
        \Azous\Schema\Goal::class,
    ];
    
    public function index(Request $req)
    {
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