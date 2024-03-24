<?php

namespace App\Scraper;

use Symfony\Contracts\HttpClient\ResponseInterface;
use App\Scraper\Exceptions\ScrapingFailedException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use App\Event\Scraping\ScrapingFailedEvent;
use App\Entity\Provider;

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

    abstract protected function doScrape(ResponseInterface $response): array;

    protected function handleException(ScrapingFailedException $e): void
    {
        $this->eventDispatcher->dispatch(new ScrapingFailedEvent($e));
    }

    public function supports(Provider $provider): bool
    {
        return $this->provider === $provider;
    }
}
