<?php

namespace App\Services\Redis;

use Symfony\Component\Cache\Adapter\RedisAdapter;

class RedisConnection
{
    private ?\Redis $connection = null;

    private function connect(): void
    {
        $this->connection = RedisAdapter::createConnection('redis://redis:6379');
    }

    public function getConnection(): \Redis
    {
        if (null === $this->connection) {
            $this->connect();
        }

        return $this->connection;
    }
}
