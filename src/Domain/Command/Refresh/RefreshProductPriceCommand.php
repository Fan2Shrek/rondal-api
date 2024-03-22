<?php

namespace App\Domain\Command\Refresh;

use App\Entity\Product;

class RefreshProductPriceCommand
{
    public function __construct(
        public readonly Product $product,
    ) {
    }
}
