<?php

namespace DLaravel\LCache;

use DLaravel\Helper\CacheTag;
use DLaravel\Helper\Logger;


class Cache
{

    /**
     * 回调函数的缓存
     *
     * @param $key
     * @param callable $callable
     * @param $param_arr
     * @param $exp
     * @return mixed
     *
     */
    static public function cacheCall($key2, callable $callable, $param_arr, $exp = 60, $tags = [])
    {
        $key = self::getKey($key2);
        $old = \Illuminate\Support\Facades\Cache::get($key);
        if (!is_null($old)) {
            return $old;
        }
        $new = call_user_func_array($callable, $param_arr);
        \Illuminate\Support\Facades\Cache::put($key, $new, $exp);
        if ($tags) {
            CacheTag::key_tags($key, $tags, null);
        }
        return $new;
    }


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
        \Illuminate\Support\Facades\Cache::put($key, $data, $exp);
        if ($tags) {
            CacheTag::key_tags($key, $tags, null);
        }

    }

    /**
     * 获取数据
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    static public function get($key, $default = null)
    {
        $key = self::getKey($key);
        Logger::debug("Cache-get".$key);
        return \Illuminate\Support\Facades\Cache::get($key,$default);
    }


    /**
     * has数据
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
     * @param $data
     * @return string
     */
    static public function getKey($data)
    {
        return md5(serialize($data));
    }


}
