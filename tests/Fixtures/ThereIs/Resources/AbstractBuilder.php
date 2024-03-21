<?php

namespace App\Tests\Fixtures\ThereIs\Resources;

use Zenstruck\Foundry\Proxy;

abstract class AbstractBuilder
{
    public function __invoke(int $count = 1): array
    {
        $builders = $this->getFactoryFQCN()::createMany($count);

        return array_map(fn ($builder) => $this->postCreation($builder), $builders);
    }

    abstract public function getFactoryFQCN(): string;

    protected function postCreation(Proxy $builder): object
    {
        return $builder->object();
    }
}
