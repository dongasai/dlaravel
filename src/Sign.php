<?php

namespace DLaravel;


class Sign
{

    public function __construct(private string $app_token)
    {
    }


    /**
     * 获取签名
     *
     * @param $times
     * @param $data
     * @return string
     */
    public function getSign( $data)
    {

        ksort($data);
//        dd($data,$this->app_id);

        $string = '';
        foreach ($data as $k => $v) {
            $string = $string . $k . '=' . urlencode($v) . '&';
        }
        $string .= 'key=' . $this->app_token;
        $md5 = md5($string);

        return strtoupper($md5);
    }

}
