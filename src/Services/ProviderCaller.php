<?php

namespace App\Services;

use App\Services\Interfaces\ProviderCallerInterface;
use App\Services\Interfaces\UrlAdapterInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use App\Entity\Product;
use App\Entity\ProviderAdapter;
use App\Repository\Data\ProductDataRepository;

class ProviderCaller implements ProviderCallerInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly UrlAdapterInterface $urlAdapter,
        private readonly ProductDataRepository $productDataRepository,
    ) {
    }

    public function call(string $url): ResponseInterface
    {
        return $this->httpClient->request('GET', $url);
    }

    public function callProduct(Product $product, ProviderAdapter $providerAdapter): ResponseInterface
    {
        $product = $this->productDataRepository->findOneByProduct($product);
        $url = $this->urlAdapter->adaptFullUrl($providerAdapter, $product);

        return $this->call($url);
    }
}