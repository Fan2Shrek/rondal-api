<?php

namespace App\Services\Provider;

use App\Entity\Product;
use App\Repository\ProviderAdapterRepository;
use App\Services\Interfaces\PriceFinderInterface;
use App\Services\Interfaces\ProviderCallerInterface;
use App\Services\Interfaces\UrlAdapterInterface;

class PriceProvider
{
    public function __construct(
        private readonly UrlAdapterInterface $urlAdapter,
        private readonly ProviderAdapterRepository $providerAdapterRepository,
        private readonly ProviderCallerInterface $providerCaller,
        private readonly PriceFinderInterface $priceFinder,
    ) {
    }

    /** 
     * @return array<string, int> 
     */
    public function getPriceFromProduct(Product $product): array
    {
        $allPrices = [];

        foreach ($this->providerAdapterRepository->findAll() as $providerAdapter) {
            $url = $this->urlAdapter->adaptFullUrl($providerAdapter, $product);
            $allPrices[$providerAdapter->getProvider()->getName()] = $this->priceFinder->findByReponse($this->providerCaller->call($url));
        }

        dd($allPrices);

        return $allPrices;
    }
}
