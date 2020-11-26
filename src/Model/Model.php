<?php

namespace Azuos\Model;

class Model
{
    public function __construct(int $id = 0)
    {
        $this->setId($id);
        $this->run();   
    }

    public function run()
    {
        if(!$result = $this->searchId($this->id)){
            return false;
        }
        $this->constructAttrs($result);
        return true;
    }

    protected function table()
    {
        return strtolower( 
            str_replace(__NAMESPACE__.'\\', '', get_class($this) ) 
        );
    }

    protected function constructAttrs(array $result)
    {
        foreach ($result[0] as $key => $value) {
            if(is_int($this->$key)){
                continue;
            }
            if($class = trim( preg_replace("/(\(class)\)/i", '', $this->$key)) ){
                $class = __NAMESPACE__.DIRECTORY_SEPARATOR.$class; 
                $this->$key = new $class($value ?? 0);

            } else if(is_object($this->$key)) {
                $this->$key->setId($value)->run();
                
            } else {
                $this->$key = $value;
            }
        }
    }

    public function searchId(int $id)
    {
        return (new \Azuos\Database\Database)
            ->table( $this->table() )
            ->columns( $this->attrToArray() )
            ->where('id', '=', $id)
            ->get();
    }

    private function attrToArray()
    {
        $attrs = [];
        foreach (get_object_vars($this) as $key => $value) {
            $attrs[] = $key;
        }
        return $attrs;
    }

    public function __call($nameFunc, $arguments)
    {
        if(preg_match("/set/i", $nameFunc)){
            $attribute = strtolower( str_replace('set', '', $nameFunc) );
            return $this->_setAttributes($attribute, $arguments[0]);
        }
    }

    private function _setAttributes(string $attribute, $value)
    {
        if(array_key_exists($attribute, get_object_vars($this))){
            $this->$attribute = $value;
        }
        return $this;
    }

    public function save()
    {
        $storeArray = [];
        foreach (get_object_vars($this) as $nameParam => $valueParam) {
            if(is_object($this->$nameParam)){
                $storeArray[$nameParam] = $this->$nameParam->id;
            } else if(!preg_match("/(\(class)\)/i", $this->$nameParam)){
                $storeArray[$nameParam] = $this->$nameParam;
            } 
        }

        if( isset($this->id) && $this->searchId($this->id) ){
            (new \Azuos\Database\Database)->table($this->table())->where('id', '=', $this->id)->update($storeArray);
        } else {
            (new \Azuos\Database\Database)->table($this->table())->insert($storeArray);
        }
    }

    public function saveRequestData(\Azuos\Http\Request $request)
    {
        foreach (get_object_vars($this) as $nameParam => $valueParam) {
            foreach ($request as $indexRequest => $valueRequest) {
                if($nameParam === $indexRequest){
                    $this->$nameParam = $valueRequest;
                }
            }
        }
        $this->save();
    }

    public function delete()
    {
        if( isset($this->id) && $this->searchId($this->id) ){
            (new \Azuos\Database\Database)->table($this->table())->where('id', '=', $this->id)->delete();
        } 
    } 

    public function findAll()
    {
        $results = (new \Azuos\Database\Database)->table( $this->table() )->columns( $this->attrToArray() )->get();
        return $this->constructListModels($results);
    }

    public function paginated(int $offset = 0, int $limit = 10)
    {
        $results = (new \Azuos\Database\Database)->table( $this->table() )->columns( $this->attrToArray() )->paginated($offset, $limit)->get();
        return $this->constructListModels($results);
    }

    private function constructListModels(array $resultModels = [])
    {
        $class = get_class($this);
        $listModels = $this->table();
        foreach ($resultModels as $index => $item) {
            $this->$listModels[] = new $class( $item['id'] );
        }
        return $this->$listModels;
    }

    public function storeAll()
    {
        $listModels = $this->table();
        if($listModels){
            foreach ($this->$listModels as $index => $item) {
                $item->store();
            }
        }
    }
}