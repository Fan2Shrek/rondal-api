<?php

namespace App\Scraper;

use App\Entity\Provider;
use App\Event\Scraping\ScrapingFailedEvent;
use App\Event\Scraping\ScrapingSkipedEvent;
use App\Event\Scraping\ScrapingSuccessedEvent;
use App\Scraper\Evaluator\ScrapEvaluator;
use App\Scraper\Exceptions\ScrapingFailedException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractProviderScraper implements ProviderScraperInterface
{
    public function __construct(
        private readonly Provider $provider,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ScrapEvaluator $scrapEvaluator,
    ) {
    }

    public function scrape(ResponseInterface $response): array
    {
        if (false === $this->scrapEvaluator->evaluate($this->provider)) {
            $this->eventDispatcher->dispatch(new ScrapingSkipedEvent($this->provider));

            dump('skip');

            return [];
        }

        try {
            $price = $this->doScrape($response);

            $this->postScrape($price);
            $this->eventDispatcher->dispatch(new ScrapingSuccessedEvent($this->provider));

            return $price;
        } catch (ScrapingFailedException $e) {
            $this->handleException($e);
        }

        return [];
    }

    /** @return float[] */
    abstract protected function doScrape(ResponseInterface $response): array;

    protected function handleException(ScrapingFailedException $e): void
    {
        $this->eventDispatcher->dispatch(new ScrapingFailedEvent($e, $this->provider));
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

    /**
     * @param mixed[] $price
     */
    protected function postScrape(array $price): void
    {
        if (!\is_float($price[0]) || 0.0 === $price[0]) {
            throw new ScrapingFailedException(sprintf('Scraping failed for provider %s', $this->provider->getName()));
        }
    }
}
