<?php

namespace App\Scraper;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

class FranprixScraper extends AbstractProviderScraper
{
    protected function doScrape(ResponseInterface $response): array
    {
        $crawler = new Crawler($response->getContent());

        $price = $crawler->filter('div.product-item-price span')->text();

        return [self::StringToFloat($price)];
    }
}
