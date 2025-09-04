<?php

namespace DLaravel\Validate;

class Arr
{

    /**
     * 数组的keys都存在
     * @param array $array
     * @param array $keys
     * @return bool
     */
    static public function keysExist(array $array,array $keys)
    {
        foreach ($keys as $key){
            if(!isset($array[$key])){
                return false;
            }
        }
        return true;
    }

}
