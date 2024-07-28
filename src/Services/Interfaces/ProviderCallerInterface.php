<?php

namespace App\Services\Interfaces;

use App\Entity\Product;
use App\Entity\ProviderAdapter;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ProviderCallerInterface
{
    /**
     * @param RequestPreparerInterface[] $requestPreparer
     */
    public function call(string $url, array $requestPreparer = []): ResponseInterface;

    /**
     * @param RequestPreparerInterface[] $requestPreparer
     */
    public function callProduct(Product $product, ProviderAdapter $provider, array $requestPreparer = []): ResponseInterface;
}
