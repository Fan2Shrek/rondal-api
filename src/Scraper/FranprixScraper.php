<?php

namespace App\Scraper;

use Symfony\Contracts\HttpClient\ResponseInterface;

class FranprixScraper extends AbstractProviderScraper
{
    protected function doScrape(ResponseInterface $response): array
    {
        dd('Scraping Franprix');

        /* @phpstan-ignore-next-line */
        return [];
    }
}
