<?php

namespace App\Services;

use App\Services\Exception\PriceNotFoundException;
use App\Services\Interfaces\PriceFinderInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PriceFinder implements PriceFinderInterface
{
    public function findByReponse(ResponseInterface $response): int
    {
        $content = $response->getContent();

        if (!str_contains($content, '€')) {
            throw new PriceNotFoundException(sprintf("Price was not found in the %s request", $response->getInfo()['url']));
        }

        \preg_match('/<[^>]*>\s*([\d,.]+)\s*€\s*<[^>]*>/', $content, $matches);

        dump($matches[0]);

        return 1;
    }
}
