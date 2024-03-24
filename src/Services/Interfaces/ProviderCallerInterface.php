<?php

namespace App\Services\Interfaces;

use App\Entity\Product;
use App\Entity\ProviderAdapter;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ProviderCallerInterface
{
    public function call(string $url): ResponseInterface;

    public function callProduct(Product $product, ProviderAdapter $provider): ResponseInterface;
}
