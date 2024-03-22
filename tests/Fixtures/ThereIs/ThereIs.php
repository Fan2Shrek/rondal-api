<?php

namespace App\Tests\Fixtures\ThereIs;

use App\Tests\Fixtures\ThereIs\Resources\ProductBuilder;
use App\Tests\Fixtures\ThereIs\Resources\ProductDataBuilder;
use App\Tests\Fixtures\ThereIs\Resources\ProviderBuilder;
use App\Tests\Fixtures\ThereIs\Resources\ProviderAdapterBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ThereIs
{
    private static ContainerInterface $container;

    public static function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
    }

    public static function aProduct(): ProductBuilder
    {
        return new ProductBuilder();
    }

    public static function aProductData(): ProductDataBuilder
    {
        return new ProductDataBuilder();
    }

    public static function aProvider(): ProviderBuilder
    {
        return new ProviderBuilder();
    }

    public static function aProviderAdapter(): ProviderAdapterBuilder
    {
        return new ProviderAdapterBuilder(self::$container);
    }
}
