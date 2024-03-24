<?php

namespace App\Services\Provider;

use App\Model\PriceInfo;
use App\Scraper\Resolver\ScraperResolverInterface;
use App\Repository\ProviderAdapterRepository;
use App\Entity\Product;
use App\Entity\ProviderAdapter;
use App\Repository\Redis\PriceInfoRepository;
use App\Services\Interfaces\ProviderCallerInterface;
use App\Services\Provider\Exception\ProviderScraperNotFound;

class PriceProvider implements PriceProviderInterface
{
    public function __construct(
        private readonly ProviderAdapterRepository $providerAdapterRepository,
        private readonly ScraperResolverInterface $scraperResolver,
        private readonly ProviderCallerInterface $providerCaller,
        private readonly PriceInfoRepository $priceInfoRespository,
    ) {
    }

    public function getPrices(Product $product): PriceInfo
    {
        $info = new PriceInfo($product);

        foreach ($this->providerAdapterRepository->findAll() as $providerAdapter) {
            $info->addPrice($providerAdapter->getProvider()->getName(), $this->getPrice($product, $providerAdapter));
        }

        $key = $product->getId();
        $this->priceInfoRespository->save((string) $key, $info);

        return $info;
    }

    public function getPrice(Product $product, ProviderAdapter $providerAdapter): float
    {
        $scraper = $this->scraperResolver->resolve($providerAdapter->getProvider());

        if (false === $scraper) {
            throw new ProviderScraperNotFound(sprintf('No scraper found for provider %s', $providerAdapter->getProvider()->getName()));
        }

        $response = $this->providerCaller->callProduct($product, $providerAdapter);

        $prices = $scraper->scrape($response);

        return $prices[0];
    }
}
