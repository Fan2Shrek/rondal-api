<?php

namespace App\Scraper;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CarrefourScraper extends AbstractProviderScraper
{
    protected function doScrape(ResponseInterface $response): array
    {
        $crawler = new Crawler($response->getContent());

        $price = $crawler->filter('div.product-price__content')->text();
        dd($price);
        return [self::StringToFloat($price)];
    }
}
