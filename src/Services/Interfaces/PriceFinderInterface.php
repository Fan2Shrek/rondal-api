<?php

namespace App\Services\Interfaces;

use App\Services\Exception\PriceNotFoundException;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface PriceFinderInterface
{
    /**
     * Find and return the price from the given erro.
     *
     * @throws PriceNotFoundException
     */
    public function findByReponse(ResponseInterface $responseInterface): string;
}
