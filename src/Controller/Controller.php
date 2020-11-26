<?php

namespace Azuos\Controller;

use Azuos\Http\Request;
use Azuos\Database\Database;

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

    public function getById(\Azuos\Http\Request $request)
    {
        if(isset($this->model)){
            $this->model->setId($request->id)->run();
            return response()->json()->send($this->model);
        }
    }

    public function getByRange(\Azuos\Http\Request $request)
    {
        if(isset($this->model)){
            return response()->json()->send(
                $this->model->paginated((int) $request->offset, (int) $request->limit)
            );
        }
    }

    public function registerForRequest(\Azuos\Http\Request $request)
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
