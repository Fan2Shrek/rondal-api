<?php

namespace App\Services\Redis;

use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\CacheItem;

class CacheFactory
{
    public function createCache(): CacheItemInterface
    {
        return new CacheItem();
    }
}
