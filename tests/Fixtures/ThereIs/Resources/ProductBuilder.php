<?php

namespace App\Tests\Fixtures\ThereIs\Resources;

use App\Tests\Fixtures\Factory\ProductFactory;

class ProductBuilder extends AbstractBuilder
{
    public function getFactoryFQCN(): string
    {
        return ProductFactory::class;
    }
}
