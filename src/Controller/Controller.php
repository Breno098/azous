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

    public function getAll(Request $req)
    {
        if(isset($this->model)){
            $datas = (new Database)->table( $this->model->table() )->get();
            return response()->json()->send($datas);
        }
    }
    
    public function __call($name, $arguments)
    {
        response()->json()->send([
            'status' => 'error',
            'message' => $name
        ]);
    }
}
