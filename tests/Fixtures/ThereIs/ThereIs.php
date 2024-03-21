<?php

namespace App\Tests\Fixtures\ThereIs;

use App\Tests\Fixtures\ThereIs\Resources\ProductBuilder;
use App\Tests\Fixtures\ThereIs\Resources\ProductDataBuilder;

class ThereIs
{
    public static function aProduct(): ProductBuilder
    {
        return new ProductBuilder();
    }

    public static function aProductData(): ProductDataBuilder
    {
        return new ProductDataBuilder();
    }
}
