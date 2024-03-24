<?php

namespace App\Services;

use App\Entity\Data\ProductData;
use App\Entity\Provider;
use App\Entity\ProviderAdapter;
use App\Repository\Data\ProductDataRepository;
use App\Services\Interfaces\UrlAdapterInterface;

class UrlAdapter implements UrlAdapterInterface
{
    private const SCHEMA_FORMAT = [
        'product' => 'originalName',
        'id' => '|-id',
        'name' => '|-name',
    ];

    private Provider $currentProvider;

    public function __construct(
        private readonly ProductDataRepository $productDataRepository
    ) {
    }

    public function adaptFullUrl(ProviderAdapter $providerAdapter, ProductData $productData): string
    {
        $this->currentProvider = $providerAdapter->getProvider();

        $baseUrl = $this->adapt($providerAdapter);
        $url = $this->formatString($baseUrl, $productData);

        return $url;
    }

    public function adapt(ProviderAdapter $providerAdapter): string
    {
        return $providerAdapter->getProvider()->getUrl().$providerAdapter->getUrlSchema();
    }

    private function formatString(string $url, ProductData $productData): string
    {
        $toReplace = [];

        preg_match_all('/{(([a-zA-Z0-9]|-)*)}/', $url, $matches);
        foreach ($matches[1] as $convert) {
            $toReplace['{'.$convert.'}'] = $this->get(self::SCHEMA_FORMAT[$convert], $productData);
        }

        return strtr($url, $toReplace);
    }

    /**
     * @return string[]
     */
    private function transformToMethods(string $toTransform): iterable
    {
        foreach (explode('.', $toTransform) as $step) {
            yield 'get'.ucfirst($step);
        }
    }

    private function get(string $toCall, ProductData $productData): mixed
    {
        $methods = $this->transformToMethods($toCall);

        foreach ($methods as $method) {
            $arg = \str_replace('|', $this->currentProvider->getName(), $method);
            $arg = \str_replace('get', '', $arg);

            $arg = $productData->get(strtolower($arg));
        }

        return $arg ?? '';
    }
}
