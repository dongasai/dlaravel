<?php

namespace DLaravel;

use App\Logic\Cache;
use App\Logic\Helper;

/**
 * 追踪运行时间
 *
 */
class TraceTime
{

    static $stime     = 0;
    static $last_time = 0;

    static public function start()
    {
        self::$stime = microtime(true);
    }

    /**
     * 进行一次时间记录
     * @param $name
     * @return void
     */
    static public function log($name)
    {
        if (!self::$stime) {
            self::start();
        }
        $last_time = microtime(true);
        Helper::infoLog("TraceTime -$name - last ", $last_time - self::$last_time);
        self::$last_time = $last_time;
        Helper::infoLog("TraceTime -$name -stime ", self::$last_time - self::$stime);

    }

}
