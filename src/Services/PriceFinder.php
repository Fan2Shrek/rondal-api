<?php

namespace App\Services;

use App\Services\Exception\PriceNotFoundException;
use App\Services\Interfaces\PriceFinderInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PriceFinder implements PriceFinderInterface
{
    public function findByReponse(ResponseInterface $response): float
    {
        $content = $response->getContent();

        if (!str_contains($content, '€')) {
            /**
             * @var array{
             *  url: string
             * }
             */
            $info = $response->getInfo();

            throw new PriceNotFoundException(sprintf('Price was not found in the %s request', $info['url']));
        }

        \preg_match('/<[^>]*>([0-9(.|,)]+)\s*(€|$)<\/[^>]*>/', $content, $matches);

        return \str_replace(',', '.', $matches[1]);
    }
}
