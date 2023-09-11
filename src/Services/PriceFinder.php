<?php

namespace App\Services;

use App\Services\Interfaces\PriceFinderInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PriceFinder implements PriceFinderInterface
{
    public function findByReponse(ResponseInterface $responseInterface): int
    {
        return 1;
    }
}
