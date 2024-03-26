<?php

namespace App\Scraper\Factory;

use App\Repository\ProviderRepository;
use App\Scraper\AbstractProviderScraper;
use App\Scraper\Evaluator\ScrapEvaluator;
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
        private readonly ScrapEvaluator $scrapEvaluator,
    ) {
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $scraperClass
     */
    public function create(string $scraperClass, string $providerName, bool $track = false): AbstractProviderScraper
    {
        if (!class_exists($scraperClass) || !is_subclass_of($scraperClass, AbstractProviderScraper::class)) {
            throw new \InvalidArgumentException(sprintf('The class "%s either not exist or is not a subclass of "%s".', $scraperClass, AbstractProviderScraper::class));
        }

        $provider = $this->providerRepository->findOneByName($providerName);

        if (null === $provider) {
            throw new UnsupportedScraperExecption(sprintf('There are not provider with the name "%s".', $providerName));
        }

        if ($track) {
            $this->scrapEvaluator->track($provider);
        }

        return new $scraperClass($provider, $this->eventDispatcher);
    }
}
