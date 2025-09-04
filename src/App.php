<?php

namespace DLaravel;

class App
{

    public static function is_debug(): bool
    {
        return config('app.debug');
    }

    public static function is_local(): bool
    {
        return app()->isLocal();
    }

}
