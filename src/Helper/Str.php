<?php

namespace DLaravel\Helper;

class Str
{


    /**
     * 字符串数组替换
     * @param $templete
     * @param $data
     * @return array|mixed|string|string[]
     */
    static  public function strtr($templete,$data)
    {
        $temp = $templete;
        foreach ($data as $k=>$v)
        {
            $temp = str_replace('{'.$k.'}',$v,$temp);
        }
        return $temp;

    }

}
