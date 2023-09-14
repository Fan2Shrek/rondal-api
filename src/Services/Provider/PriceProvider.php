<?php

namespace App\Services\Provider;

use App\Entity\Product;
use App\Model\PriceInfo;
use Psr\Cache\CacheItemInterface;
use App\Services\Redis\RedisConnection;
use App\Repository\ProviderAdapterRepository;
use App\Services\Interfaces\UrlAdapterInterface;
use App\Services\Interfaces\PriceFinderInterface;
use App\Services\Interfaces\ProviderCallerInterface;

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

    public function getPriceFromProduct(Product $product): PriceInfo
    {
        $cache = $this->checkInRedis($product);

        if ($cache->isHit()) {
            /**
             * @var PriceInfo
             */
            return $cache->get();
        }

        $priceInfo = $this->refreshPrice($product);

        $cache->set($priceInfo)
            ->expiresAfter(846000);

        /**
         * @phpstan-ignore-next-line
         */
        $this->connection->save($cache);

        return $priceInfo;
    }

    private function refreshPrice(Product $product): PriceInfo
    {
        $priceInfo = new PriceInfo($product);

        foreach ($this->providerAdapterRepository->findAll() as $providerAdapter) {
            $url = $this->urlAdapter->adaptFullUrl($providerAdapter, $product);
            $priceInfo->addPrice($providerAdapter->getProvider()->getName(), $this->priceFinder->findByReponse($this->providerCaller->call($url)));
        }

        return $priceInfo;
    }

    private function checkInRedis(Product $product): CacheItemInterface
    {
        $key = "product-{$product->getId()}";

        /**
         * @phpstan-ignore-next-line
         */
        return $this->connection->getItem(sha1($key));
    }
}
