<?php

namespace App\Services\Interfaces;

use App\Entity\Product;
use App\Entity\ProviderAdapter;

interface UrlAdapterInterface
{
    /**
     *  Adapt the url from given provider.
     */
    public function adapt(ProviderAdapter $providerAdapter): string;

    /**
     *  Adapt the url and return the full url to call.
     */
    public function adaptFullUrl(ProviderAdapter $providerAdapter, Product $product): string;
}
