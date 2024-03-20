<?php

namespace App\Tests\Fixtures\ThereIs;

use App\Tests\Fixtures\ThereIs\Resources\ProductBuilder;

class ThereIs
{
    public static function aProduct(): ProductBuilder
    {
        return new ProductBuilder();
    }
}
