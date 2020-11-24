<?php

namespace Azous\Controller;

use Azous\Http\Request;
use Azous\Database\Database;

class CountryController extends Controller
{
    public function gets(Request $req)
    {
        $datas = (new Database)->table('country')->get();

        return response()->json()->send([
            'status' => 'success',
            'datas' => $datas,
        ]);
    }

    public function store(Request $req)
    {
        // $datas = (new Database)->table('country')->insert([
        //     'name' => $req->name
        // ]);

        return response()->json()->send([
            'status' => 'success',
            'datas' => $req->params['name']
        ]);
    }
}