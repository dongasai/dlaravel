<?php

namespace DLaravel\Helper;



use DLaravel\Exception\CodeException;

/**
 * BC的再封装
 */
class Bc
{

    /**
     * 除法
     *
     * @param $num1
     * @param $num2
     * @param int $scale
     * @param string $error
     * @return string
     */
    static public function div($num1, $num2, int $scale = 0, $error = '0')
    {
        if (empty($num1)) {
            if(is_null($error)){
                throw new CodeException("bc_div 0 ");
            }
            return (string) $error;
        }
        return bcdiv((string)$num1, (string)$num2, $scale);
    }

}
