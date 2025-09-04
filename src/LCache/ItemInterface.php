<?php

namespace DLaravel\LCache;

use Psr\Cache\CacheItemInterface;

interface ItemInterface
{
    public function get();

    public function update($data,$ttl=60):CacheItemInterface;
}
