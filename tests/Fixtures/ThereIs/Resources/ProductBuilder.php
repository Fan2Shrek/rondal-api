<?php

namespace App\Tests\Fixtures\ThereIs\Resources;

use App\Tests\Fixtures\Factory\ProductFactory;

class ProductBuilder
{
    public function __invoke(int $count = 1): array
    {
        $builder = ProductFactory::createMany($count);

        return array_map(fn ($builder) => $builder->object(), $builder);
    }
}
