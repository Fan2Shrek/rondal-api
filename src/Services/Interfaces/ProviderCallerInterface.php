<?php

namespace App\Services\Interfaces;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ProviderCallerInterface
{
    /**
     * Return the price from the given url 
     * 
     * @param string $url 
     * @return string 
     */
    public function call(string $url): ResponseInterface;
}
