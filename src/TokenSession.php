<?php

namespace DLaravel;

use App\Version;
use DLaravel\Exception\LogicException;
use DLaravel\Helper\Logger;

/**
 * Token的session,使用cache作为储存介质,有效期10天
 *
 */
class TokenSession
{

    static $ttl = 3600 * 240;

    static $session_id = '';

    static $prefix = 'token_';

    /**
     * 获取SessionID
     *
     * @return string
     */
    public static function getSessionId(): string
    {
        if (!self::$session_id) {
            self::$session_id = self::genSessionID();
        }
        if (strlen(self::$session_id) != 32) {
            self::$session_id = self::genSessionID();
        }

        return self::$session_id;
    }

    /**
     * 生成SessionID
     *
     * @return string
     */
    public static function genSessionID(): string
    {
        $id = md5(uniqid());

        return $id;
    }

    /**
     * 获取数据
     *
     * @param $key
     * @param $defaultValue
     * @return mixed
     */
    static public function get($key = null, $defaultValue = null)
    {
        $keyFull =static::getKey();
        $data = \Illuminate\Support\Facades\Cache::get($keyFull, []);
        Logger::debug('cache.get: '.$keyFull,  $data);

        if ($key === null) {
            return $data;
        }
        if (strpos($key, '.')) {
            $ks = explode('.', $key);

            if (count($ks) == 2) {
                $value = $data[$ks[0]][$ks[1]] ?? $defaultValue;
            }
            if (count($ks) == 3) {
                $value = $data[$ks[0]][$ks[1]][$ks[2]] ?? $defaultValue;
            }
            if (count($ks) == 4) {
                $value = $data[$ks[0]][$ks[1]][$ks[2]] [$ks[4]] ?? $defaultValue;
            }
            if (count($ks) > 4) {
                throw new LogicException("不允许的操作");
            }
        } else {
            $value = $data[$key] ?? $defaultValue;
        }

        return $value;

    }

    /**
     * remove 的别名
     *
     * @return bool
     */
    static public function reset()
    {
        return self::remove();
    }

    /**
     * 删除 ,remove 的别名
     *
     * @return bool
     */
    static public function delete()
    {
        return self::remove();
    }

    /**
     * 去除,删掉整个Session的数据
     *
     * @return bool
     */
    static protected function remove()
    {
        return \Illuminate\Support\Facades\Cache::delete(static::getKey());
    }

    static protected function set($key, $value = null)
    {
        self::getSessionId();
        $data = \Illuminate\Support\Facades\Cache::get(static::getKey(), []);
        if (strpos($key, '.')) {
            $ks = explode('.', $key);

            if (count($ks) == 2) {
                $data[$ks[0]][$ks[1]] = $value;
            }
            if (count($ks) == 3) {
                $data[$ks[0]][$ks[1]][$ks[2]] = $value;
            }
            if (count($ks) == 4) {
                $data[$ks[0]][$ks[1]][$ks[2]] [$ks[4]] = $value;
            }
            if (count($ks) > 4) {
                throw new LogicException("不允许的操作");
            }
        } else {
            $data[$key] = $value;
        }
        \Illuminate\Support\Facades\Cache::set(static::getKey(), $data, static::$ttl);

        return $data;

    }

    static protected function getKey()
    {
        return static::$prefix . static::$session_id . '_' . \DLaravel\Version::VERSION;
    }



    static public function checktoken($token)
    {
        if (strlen($token) != 32) {
            return false;
        }

        return true;
    }

}
