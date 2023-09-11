<?php

namespace App\Services\Provider;

use App\Entity\Product;
use App\Entity\Provider;
use App\Repository\ProviderAdapterRepository;
use App\Services\Interfaces\UrlAdapterInterface;

class PriceProvider
{
    public function __construct(
        private readonly UrlAdapterInterface $urlAdapter,
        private readonly ProviderAdapterRepository $providerAdapterRepository,
    ) {
    }

    /** 
     * @return array<string, int> 
     */
    public function getPriceFromProduct(Product $product): array
    {
        foreach ($this->providerAdapterRepository->findAll() as $providerAdapter) {
            dd($this->urlAdapter->adaptFullUrl($providerAdapter, $product));
        }

        return [];
    }
}
