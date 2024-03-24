<?php

namespace App\Services\Provider;

use App\Entity\Product;
use App\Entity\ProviderAdapter;
use App\Model\PriceInfo;

interface PriceProviderInterface
{
    public function getPrice(Product $product, ProviderAdapter $providerAdapter): float;

    public function getPrices(Product $product): PriceInfo;
}
