<?php

namespace App\Services\Interfaces;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ProviderCallerInterface
{
    /**
     * Return the price from the given url.
     */
    public function call(string $url): ResponseInterface;
}
