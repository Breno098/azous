<?php

namespace Azous\Database;

class SchemaBase
{
    private $functionExists = true;
    
    public function __call($name, $arguments)
    {
        $this->functionExists = false;
        response()->json()->send([
            'status' => 'error',
            'message' => "schema error {$name}"
        ]);
    }

    public function schema() {
        return new \Azous\Database\Schema();
    }


    public function __destruct() {
        if($this->functionExists){
            response()->json()->send([
                'status' => 'success',
                'message' => "schema {$this->table} success"
            ]);
        }
    }

    public function drop()
    {
        if(isset($this->table)){
            $schema = (new \Azous\Database\Schema)->table($this->table)->drop();
        }
    }
}