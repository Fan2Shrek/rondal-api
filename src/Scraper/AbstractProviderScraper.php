<?php

namespace App\Scraper;

use App\Entity\Provider;
use App\Event\Scraping\ScrapingFailedEvent;
use App\Scraper\Exceptions\ScrapingFailedException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractProviderScraper implements ProviderScraperInterface
{
    public function __construct(
        private readonly Provider $provider,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function scrape(ResponseInterface $response): array
    {
        try {
            return $this->doScrape($response);
        } catch (ScrapingFailedException $e) {
            $this->handleException($e);
        }

        return [];
    }

    /** @return float[] */
    abstract protected function doScrape(ResponseInterface $response): array;

    protected function handleException(ScrapingFailedException $e): void
    {
        $this->eventDispatcher->dispatch(new ScrapingFailedEvent($e));
    }

    public function supports(Provider $provider): bool
    {
        return $this->provider === $provider;
    }

    public static function StringToFloat(string $price): float
    {
        $convertedPrice = trim($price);
        $convertedPrice = str_replace('€', '', $convertedPrice);
        $convertedPrice = str_replace(',', '.', $convertedPrice);

        return (float) $convertedPrice;
    }
}
