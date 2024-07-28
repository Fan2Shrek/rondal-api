<?php

namespace App\Scraper;

use App\Services\Interfaces\RequestPreparerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\ResponseInterface;

class IntermarcheScraper extends AbstractProviderScraper implements RequestPreparerInterface
{
    public function prepareRequest(string $url): array
    {
        return [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36',
            ],
        ];
    }

    protected function doScrape(ResponseInterface $response): array
    {
        file_put_contents('intermarche.html', $response->getContent(false));
        $crawler = new Crawler($response->getContent(), useHtml5Parser: false);

        $price = $crawler->filter('div[data-test="price-container"] span')->text();

        return [self::StringToFloat($price)];
    }
}
