<?php

namespace App\Scraper\Resolver;

use App\Entity\Provider;
use App\Scraper\ProviderScraperInterface;

interface ScraperResolverInterface
{
    public function resolve(Provider $provider): false|ProviderScraperInterface;
}
