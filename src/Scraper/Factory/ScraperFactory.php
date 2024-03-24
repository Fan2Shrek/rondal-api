<?php

namespace App\Scraper\Factory;

use App\Repository\ProviderRepository;
use App\Scraper\AbstractProviderScraper;
use App\Scraper\Exceptions\UnsupportedScraperExecption;
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

    /**
     * @template T of object
     *
     * @param class-string<T> $scraperClass
     */
    public function create(string $scraperClass, string $providerName): AbstractProviderScraper
    {
        if (!class_exists($scraperClass) || !is_subclass_of($scraperClass, AbstractProviderScraper::class)) {
            throw new \InvalidArgumentException(sprintf('The class "%s either not exist or is not a subclass of "%s".', $scraperClass, AbstractProviderScraper::class));
        }

        $provider = $this->providerRepository->findOneByName($providerName);

        if (null === $provider) {
            throw new UnsupportedScraperExecption(sprintf('There are not provider with the name "%s".', $providerName));
        }

        return new $scraperClass($provider, $this->eventDispatcher);
    }
}
