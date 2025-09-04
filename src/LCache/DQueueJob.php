<?php

namespace DLaravel\LCache;


use App\Module\DelayQueue\Redis;
use DLaravel\Helper\Logger;

abstract class DQueueJob  implements QueueJobInterface,DQueueJobInterface
{
    use QueueCache;


    static public function getDelay(): int
    {
        return 2;
    }

    /**
     * 事件监听
     * @param  $user
     *
     */
    static public function eventListen($user)
    {
        $arg2   = [];
        $indexs = static::getRequiredArgIndex();
        foreach ($indexs as $index) {
            if (!isset($user->$index)) {
                Logger::error("Cache-error", [ $user, $indexs, $index ]);
                throw new \InvalidArgumentException("参数错误");
            }
            $arg2[$index] = $user->$index;
        }

        static::jobUpdate($arg2);
    }

    /**
     * 使用任务更新
     *
     * @param $arg
     * @return void
     */
    static protected function jobUpdate($parameter)
    {

        Redis::addQueue([static::class, 'updateSync'], $parameter, static::getDelay());

    }



}
