<?php

namespace App\Object\Bag;

use App\Object\Bag\Exception\DataNotFoundException;

class DataBag implements DataBagInterface
{
    /** @var array<string, int|bool|string> */
    protected array $data = [];

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function get(string $key): int|bool|string
    {
        if (!$this->has($key)) {
            throw new DataNotFoundException(sprintf('The parameter "%s" does not exist.', $key));
        }

        return $this->data[$key];
    }

    public function set(string $key, int|bool|string $value): void
    {
        $this->data[$key] = $value;
    }

    public function remove(string $key): void
    {
        unset($this->data[$key]);
    }

    public function clear(): void
    {
        $this->data = [];
    }

    public function all(): array
    {
        return $this->data;
    }
}
