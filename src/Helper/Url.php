<?php

namespace DLaravel\DcatAdmin\Helper;

class Url
{

    static public function getRealUrl($path)
    {
        $host = env('APP_URL', 'http://localhost');

        return $host . '' . $path;
    }

}
