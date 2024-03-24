<?php

namespace App\Repository\Redis;

use App\Services\Redis\RedisConnection;
use App\Model\PriceInfo;

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
