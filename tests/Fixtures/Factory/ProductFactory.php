<?php

namespace App\Tests\Fixtures\Factory;

use App\Entity\Product;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<Product>
 */
final class ProductFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        $name = self::faker()->words(rand(1, 3), true);

        return [
            'active' => self::faker()->boolean(),
            'name' => \str_replace(' ', '-', $name),
            'originalName' => $name,
        ];
    }

    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Product $product): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Product::class;
    }
}
