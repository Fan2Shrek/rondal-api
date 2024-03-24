<?php

namespace App\Scraper;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MonoprixScraper extends AbstractProviderScraper
{
    protected function doScrape(ResponseInterface $response): array
    {
        $crawler = new Crawler($response->getContent());

        $price = $crawler->filter('div[data-test="price-container"] span')->text();

        return [self::StringToFloat($price)];
    }
}
