<?php

namespace App\Repository\Redis;

use App\Model\PriceInfo;
use App\Services\Redis\RedisConnection;

/**
 * @extends AbstractRedisRepository<PriceInfo>
 */
class PriceInfoRepository extends AbstractRedisRepository
{
    public function __construct(RedisConnection $redisConnection)
    {
        parent::__construct($redisConnection, PriceInfo::class);
    }
}
