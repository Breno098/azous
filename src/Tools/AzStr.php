<?php

namespace Azuos\Tools;

class AzStr
{
    static function remove($removeValue, string $string)
    {
        return str_replace($removeValue, '', $string);
    }
}