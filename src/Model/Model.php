<?php

namespace Azous\Model;

class Model
{
    public function requestStore($req)
    {
       $this->requestAttrs($req);
       $this->store();
    }

    public function requestAttrs($req)
    {
        foreach ($this->attributes as $value) {
            if( isset($req->params[$value]) ){
                $this->$value = $req->params[$value];
            }
        }
        return $this;
    }

    public function store()
    {
       foreach ($this->attributes as $key => $value) {
          $storeArray[$value] = $this->$value ?? null; 
       }
       (new \Azous\Database\Database)->table($this->table)->insert($storeArray);
    }
 
    public function __call($nameFunc, $arguments)
    {
       $attr = strtolower(str_replace('set', '', $nameFunc));
       if(!in_array($attr, $this->attributes))
          return false;
       $this->$attr = $arguments[0];
       return $this;
    }

    public function table()
    {
        return $this->table;
    }
}