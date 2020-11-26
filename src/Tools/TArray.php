<?php

namespace Azuos\Tools;

class TArray
{
    static function explode(string $delimiter, string $string, array $keys = [], bool $length = false)
    {
        $explodeArray = explode($delimiter, $string);
        if($length){
            $explodeArray['length'] = count($explodeArray);
        }
        if(!$keys)
            return $explodeArray;
            
        $count = 0;
        $return = array();
        foreach ($keys as $key) {
            if(isset($explodeArray[$count])){
                $return[$key] = $explodeArray[$count];
                $count++;
            } else {
                $return[$key] = null;
            }
        }
        if($length){
            $return['length'] = $count;
        }
        return $return;
    }

    static function invertKeyValue(array $array)
    {
        $arrayReturn = [];
        foreach ($array as $key => $value) {
            $arrayReturn[$value] = $key;
        }
        return $arrayReturn;
    }
}