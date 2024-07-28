<?php

namespace App\Scraper;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MonoprixScraper extends AbstractProviderScraper
{
    protected function doScrape(ResponseInterface $response): array
    {
        /** We need to not use useHtml5Parser
         *  because the Monoprix website is not well formed and the parser will fail.
         */
        $crawler = new Crawler($response->getContent(), useHtml5Parser: false);

        $price = $crawler->filter('div[data-test="price-container"] span')->text();

        return [self::StringToFloat($price)];
    }
}
