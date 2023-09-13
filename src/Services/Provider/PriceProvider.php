<?php

namespace App\Services\Provider;

use App\Entity\Product;
use App\Repository\ProviderAdapterRepository;
use App\Services\Interfaces\PriceFinderInterface;
use App\Services\Interfaces\ProviderCallerInterface;
use App\Services\Interfaces\UrlAdapterInterface;
use App\Services\Redis\RedisConnection;
use Symfony\Component\Cache\CacheItem;

class PriceProvider
{
    public function __construct(
        private readonly UrlAdapterInterface $urlAdapter,
        private readonly ProviderAdapterRepository $providerAdapterRepository,
        private readonly ProviderCallerInterface $providerCaller,
        private readonly PriceFinderInterface $priceFinder,
        private readonly RedisConnection $connection,
    ) {
    }

    /**
     * @return array<string, float>
     */
    public function getPriceFromProduct(Product $product): array
    {
        $allPrices = [];

        foreach ($this->providerAdapterRepository->findAll() as $providerAdapter) {
            $url = $this->urlAdapter->adaptFullUrl($providerAdapter, $product);
            $allPrices[$providerAdapter->getProvider()->getName()] = $this->priceFinder->findByReponse($this->providerCaller->call($url));
        }

        return $allPrices;
    }

    private function checkInRedis(): ?CacheItem
    {
    }
}
