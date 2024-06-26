<?php

namespace App\Scraper\Resolver;

use App\Entity\Provider;
use App\Scraper\ProviderScraperInterface;

class ScraperResolver implements ScraperResolverInterface
{
    /**
     * @param ProviderScraperInterface[] $scrapers
     */
    public function __construct(
        private iterable $scrapers,
    ) {
    }

    public function resolve(Provider $provider): false|ProviderScraperInterface
    {
        foreach ($this->scrapers as $scraper) {
            if ($scraper->supports($provider)) {
                return $scraper;
            }
        }

        return false;
    }
}
