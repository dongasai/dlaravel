<?php

namespace DLaravel\LCache;

use DLaravel\Helper\Logger;

use function Laravel\Prompts\select;

trait QueueCache
{

    public function run(): bool
    {
        $indexs = static::getRequiredArgIndex();
        foreach ($indexs as $index) {
            if (!isset($this->arg[$index])) {
                Logger::error("Cache-error", [ $this->arg, $indexs, $index ]);

                return false;
            }
        }
//        dump($this->arg);
        $key  = self::getKey($this->arg);
        $key2 = $key . '_PD';// 防止重复执行
        $pd   = SCache::get($key2);
        if ($pd->isHit()) {
            // 重复执行
            return true;
        }
        $d = static::getNewData($this->arg);
        self::updateData($key, $d);

        return true;
    }

    public static function updateData($key, $d)
    {
        $key2 = $key . '_PD';// 防止重复执行
//        dump($key,$d);
        $data = new CacheItem($key, $d, time(), static::getTtl());
        SCache::put($key, $data, null);
        SCache::put($key2, 1, static::getPreventDuplication());

        return $data;
    }

    /**
     * 更新数据,同步,强制
     *
     * @param $arg
     * @return void
     */
    static public function updateSync($parameter)
    {
        $key  = static::getKey($parameter);
        $d    = static::getNewData($parameter);
        $data = new CacheItem($key, $d, time(), static::getTtl());
        SCache::put($key, $data, null);

        return $key;
    }


    /**
     * 获取缓存key
     *
     * @param $parameter
     * @return string
     */
    static protected function getKey($parameter)
    {
        return md5(serialize([ static::class, $parameter ]));
    }


    /**
     * 获取数据
     *
     * @return mixed|null
     */
    static public function getData($parameter = [], $force = false)
    {
        $key = static::getKey($parameter);


        $item = SCache::get($key);
//        var_dump($key);
        // 3ee2d37c91b4abcf418bd24c0c0e1dea
        // 3ee2d37c91b4abcf418bd24c0c0e1dea

        if (!$item->isHit()) {
            $force = true;
        }
        if ($force) {
            $d    = static::getNewData($parameter);
            $item = self::updateData($key, $d);
        }

        return $item->getValue();
    }


}
