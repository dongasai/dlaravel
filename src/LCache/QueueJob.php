<?php

namespace DLaravel\LCache;


use DLaravel\Helper\Logger;

abstract class QueueJob extends \DLaravel\Queue\QueueJob implements QueueJobInterface
{

    use QueueCache;

    public function __construct(public array $arg = [])
    {
        Logger::info('队列任务创建', [
            'job_class' => static::class,
            'args' => $arg
        ]);
    }




    public function payload()
    {
        Logger::info('队列任务准备执行', [
            'job_class' => static::class,
            'payload' => $this->arg
        ]);
        return $this->arg;
    }


    /**
     * 使用任务更新
     *
     * @param $arg
     * @return void
     */
    static protected function jobUpdate($parameter)
    {
        Logger::info('队列任务更新', [
            'job_class' => static::class,
            'parameter' => $parameter
        ]);

        $queue = env('CACHE_QUEUE', null);
        if ($queue) {
            self::dispatch($parameter)->delay(2)->onQueue($queue);
        } else {
            self::dispatch($parameter)->delay(2);
        }
    }




}
