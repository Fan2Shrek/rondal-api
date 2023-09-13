<?php

namespace App\Domain\Command\Refresh;

use App\Entity\Product;

class RefreshProductPriceCommand
{
    public function __construct(private Product $product)
    {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
