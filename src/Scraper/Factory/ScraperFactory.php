<?php

namespace App\Scraper\Factory;

use App\Repository\ProviderRepository;
use App\Scraper\AbstractProviderScraper;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @todo Maybe we can add the container to this class
 * that way scrapers can be autowired
 */
class ScraperFactory
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ProviderRepository $providerRepository,
    ) {
    }

    public function create(string $scraperClass, string $providerName): AbstractProviderScraper
    {
        $provider = $this->providerRepository->findOneByName($providerName);

        return new $scraperClass($provider, $this->eventDispatcher);
    }
}
