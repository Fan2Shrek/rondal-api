<?php

namespace App\Repository\Redis;

use App\Services\Redis\RedisConnection;

/**
 * @template T of object
 */
abstract class AbstractRedisRepository
{
    private string $prefix;

    /**
     * @param class-string<T> $class
     */
    public function __construct(
        private readonly RedisConnection $redisConnection,
        private readonly string $class,
        ?string $prefix = null,
    ) {
        $this->prefix = $prefix ?? $this->getPrefix($this->class);
    }

    final protected function getPrefix(string $class): string
    {
        $parts = explode('\\', $class);

        return end($parts);
    }

    final protected function getFullKey(string $key): string
    {
        return sha1($this->prefix.$key);
    }

    /**
     * @param T $value
     */
    public function save(string $key, object $value, int $expiresAfter = 3600): void
    {
        $cache = $this->redisConnection->getItem($this->getFullKey($key));

        $cache->set($value)
            ->expiresAfter($expiresAfter);

        $this->redisConnection->save($cache);
    }

    /**
     * @return T|null
     */
    public function get(string $key, bool $createOnMiss = true): ?object
    {
        $cache = $this->redisConnection->getItem($this->getFullKey($key));

        if ($cache->isHit()) {
            $resource = $cache->get();

            if (!$resource instanceof $this->class) {
                throw new \RuntimeException(sprintf('Expected instance of %s, got %s', $this->class, get_debug_type($resource)));
            }

            return $resource;
        }

        if (!$createOnMiss) {
            return null;
        }

        $resource = new $this->class();

        return $resource;
    }
}
