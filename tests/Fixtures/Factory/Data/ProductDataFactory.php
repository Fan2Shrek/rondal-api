<?php

namespace App\Tests\Fixtures\Factory\Data;

use App\Entity\Data\ProductData;
use App\Tests\Fixtures\Factory\ProductFactory;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<ProductData>
 */
final class ProductDataFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'product' => ProductFactory::new(),
        ];
    }

    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(ProductData $productData): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ProductData::class;
    }
}
