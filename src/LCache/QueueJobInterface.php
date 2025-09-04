<?php

namespace DLaravel\LCache;

interface QueueJobInterface
{

    /**
     * 获取数据
     *
     * @param $parameter
     * @return mixed
     */
    static public function getNewData(array $parameter = []);

    /**
     * 缓存时间
     *
     * @return int
     */
    static public function getTtl(): int;

    /**
     * 缓存时间，防止重复执行
     *
     * @return int
     */
    static public function getPreventDuplication(): int;

    /**
     * 获取必填参数索引
     * @return array
     */
    static public function getRequiredArgIndex(): array;


}
