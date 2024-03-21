<?php

namespace App\Object\Bag;

interface DataBagInterface
{
    public function has(string $key): bool;

    public function get(string $key): int|bool|string;

    public function set(string $key, int|bool|string $value): void;

    public function remove(string $key): void;

    public function clear(): void;

    /**
     * @return array<string, int|bool|string>
     */
    public function all(): array;
}
