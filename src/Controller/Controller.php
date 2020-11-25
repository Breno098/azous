<?php

namespace Azous\Controller;

use Azous\Http\Request;
use Azous\Database\Database;

class Controller
{
    public function __construct()
    {
        if(isset($this->model)){
            $this->model = (new $this->model);
        }
    }

    public function getAll()
    {
        if(isset($this->model)){
            return response()->json()->send(
                $this->model->findAll()
            );
        }
    } 

    public function getById(\Azous\Http\Request $request)
    {
        if(isset($this->model)){
            $this->model->setId($request->id)->run();
            return response()->json()->send($this->model);
        }
    }

    public function registerForRequest(\Azous\Http\Request $request)
    {
        $this->model->saveRequestData($request); 
    }
    
    public function __call($name, $arguments)
    {
        response()->json()->send([
            'status' => 'error',
            'message' => $name
        ]);
    }
}
