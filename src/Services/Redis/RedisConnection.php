<?php

namespace App\Services\Redis;

use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;

/**
 * @method CacheItemInterface getItem(string $key)
 * @method bool               save(CacheItemInterface $item)
 */
class RedisConnection
{
    private ?RedisAdapter $connection = null;

    public function __construct(
        private string $dsn,
    ) {
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
        if (!method_exists($this->getConnection(), $name)) {
            throw new \BadMethodCallException(sprintf('Method %s does not exist', $name));
        }

        return $this->getConnection()->$name(...$arguments);
    }
}
