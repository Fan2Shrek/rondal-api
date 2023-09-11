<?php

namespace App\Services\Interfaces;

use App\Services\Exception\PriceNotFoundException;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface PriceFinderInterface
{
    /**
     * Find and return the price from the given erro
     * 
     * @throws PriceNotFoundException
     * 
     * @param ResponseInterface $responseInterface 
     * @return int 
     */
    public function findByReponse(ResponseInterface $responseInterface): int;
}
