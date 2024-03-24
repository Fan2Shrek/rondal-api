<?php

namespace App\Tests\Resources;

use App\Scraper\AbstractProviderScraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\ResponseInterface;

class DummyScraper extends AbstractProviderScraper
{
    protected function doScrape(ResponseInterface $response): array
    {
        $content = $response->getContent();

        $crawler = new Crawler($content);
        $price = $crawler->filter('.price span')->text();

        return [str_replace('€', '', $price)];
    }
}
