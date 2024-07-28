<?php

namespace App\Services;

use App\Entity\Product;
use App\Entity\ProviderAdapter;
use App\Repository\Data\ProductDataRepository;
use App\Services\Interfaces\ProviderCallerInterface;
use App\Services\Interfaces\UrlAdapterInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ProviderCaller implements ProviderCallerInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly UrlAdapterInterface $urlAdapter,
        private readonly ProductDataRepository $productDataRepository,
    ) {
    }

    public function call(string $url, array $requestPreparer = []): ResponseInterface
    {
        $options  = [];

        foreach ($requestPreparer as $preparer) {
            $options = array_merge($preparer->prepareRequest($url));
        }

        return $this->httpClient->request('GET', $url, $options);
    }

    public function callProduct(Product $product, ProviderAdapter $providerAdapter, array $requestPreparer = []): ResponseInterface
    {
        $product = $this->productDataRepository->findOneByProduct($product);

        if (null === $product) {
            throw new \LogicException('Product not found');
        }

        $url = $this->urlAdapter->adaptFullUrl($providerAdapter, $product);

        return $this->call($url, $requestPreparer);
    }
}
