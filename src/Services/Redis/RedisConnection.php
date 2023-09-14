<?php

namespace App\Services\Redis;

use Symfony\Component\Cache\Adapter\RedisAdapter;

class RedisConnection
{
    private ?RedisAdapter $connection = null;

    public function __construct(private string $dsn)
    {
    }

    private function connect(): RedisAdapter
    {
        $redis = RedisAdapter::createConnection($this->dsn);

        return new RedisAdapter($redis);
    }

    public function getConnection(): RedisAdapter
    {
        if (null === $this->connection) {
            $this->connection = $this->connect();
        }

        return $this->connection;
    }

    /**
     * Call the function to the redis connection.
     * 
     * @param mixed[] $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        return $this->getConnection()->$name(...$arguments);
    }
}
