<?php

namespace App\Scraper;

use App\Entity\Provider;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ProviderScraperInterface
{
    public function supports(Provider $provider): bool;

    /**
     * @return float[]
     */
    public function scrape(ResponseInterface $response): array;
}
