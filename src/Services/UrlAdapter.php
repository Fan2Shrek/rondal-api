<?php

namespace App\Services;

use App\Entity\Product;
use App\Entity\ProviderAdapter;
use App\Services\Interfaces\UrlAdapterInterface;

class UrlAdapter implements UrlAdapterInterface
{
    private const SHORT_FORMATS = [];

    public function adapt(ProviderAdapter $providerAdapter): string
    {
        return $providerAdapter->getProvider()->getUrl() . $providerAdapter->getUrlSchema();
    }

    public function format(string $url): string
    {
        return $url;
    }

    public function adaptFullUrl(ProviderAdapter $providerAdapter, Product $product): string
    {
        $baseUrl = $this->adapt($providerAdapter);
        $url = $this->format($baseUrl);

        return $url;
    }
}
