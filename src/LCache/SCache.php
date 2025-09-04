<?php

namespace DLaravel\LCache;


use DLaravel\Helper\CacheTag;
use DLaravel\Helper\Logger;

/**
 * symfony/cache使用laravel的配置的封装
 *
 *
 */
class SCache
{


    /**
     * 设置数据
     *
     * @param $key
     * @param $data
     * @param $exp
     * @param $tags
     * @return void
     */
    static public function put($key, $data, $exp = 60, $tags = [])
    {
        $key = self::getKey($key);
        if ($data instanceof CacheItem) {
            $d2 = $data;
        } else {
            $d2 = new CacheItem($key, $data, time(), $exp);
        }

        \Illuminate\Support\Facades\Cache::put($key, $d2, $exp);
        if ($tags) {
            CacheTag::key_tags($key, $tags, null);
        }

        return $d2;

    }

    /**
     * 获取数据
     *
     * @param $key
     * @param $default
     * @return CacheItem
     */
    static public function get($key, $default = null)
    {

        $key = self::getKey($key);
        Logger::debug("Cache-get" . $key);
        $res = \Illuminate\Support\Facades\Cache::get($key, $default);
        if ($res instanceof CacheItem) {
            Logger::debug("Cache-get hit" . $key);
            $res->isHit();
            return $res;
        }
        $res = new CacheItem($key, $default, 0);
        $res->setHit(false)->expiresAfter(-1);
        Logger::debug("Cache-get no hit" . $key);

        return $res;
    }


    /**
     * 获取数据
     * @param $key
     * @param $default
     * @return mixed|null
     */
    static public function getValue($key, $default = null)
    {
        $item = self::get($key, $default);

        return $item->getValue();
    }

    /**
     * has数据
     *
     * @param $key
     * @return bool
     */
    static public function has($key)
    {
        $key = self::getKey($key);

        return \Illuminate\Support\Facades\Cache::has($key);
    }

    static public function getTags($key)
    {
        $key = self::getKey($key);

    }

    /**
     * 获取键名
     *
     * @param $data
     * @return string
     */
    static public function getKey($data)
    {
        if(is_string($data)){
            return $data;
        }
        return md5(serialize($data));
    }


}
