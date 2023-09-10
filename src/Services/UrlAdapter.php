<?php

namespace App\Services;

use App\Entity\Product;
use App\Entity\Provider;
use App\Entity\ProviderAdapter;
use App\Services\Interfaces\UrlAdapterInterface;

class UrlAdapter implements UrlAdapterInterface
{
    private const SCHEMA_FORMAT = [
        'product' => 'originalName',
        'id' => '|-id',
    ];

    private ?Provider $currentProvider = null;

    public function adaptFullUrl(ProviderAdapter $providerAdapter, Product $product): string
    {
        $this->currentProvider = $providerAdapter->getProvider();

        $baseUrl = $this->adapt($providerAdapter);
        $url = $this->formatString($baseUrl, $product);

        return $url;
    }

    public function adapt(ProviderAdapter $providerAdapter): string
    {
        return $providerAdapter->getProvider()->getUrl() . $providerAdapter->getUrlSchema();
    }

    private function formatString(string $url, object $object): string
    {
        $convertedString = '';
        $toReplace = [];

        preg_match_all('/{(([a-zA-Z0-9]|-)*)}/', $url, $matches);
        foreach ($matches[1] as $convert) {
            $toReplace["{" . $convert . "}"] = $this->get(self::SCHEMA_FORMAT[$convert], $object);
        }
        dd($toReplace);

        return $convertedString;
    }

    /**
     * @return string[]
     */
    private function transformToMethods(string $toTransform): iterable
    {
        foreach (explode('.', $toTransform) as $step) {
            yield 'get' . ucfirst($step);
        }
    }

    private function get(string $toCall, object $target): string
    {
        $methods = $this->transformToMethods($toCall);

        foreach ($methods as $method) {
            if (!\str_contains($method, '|')) {
                $target = $target->$method() ?? 'unknow';

                continue;
            }

            $arg = \str_replace('|', $this->currentProvider->getName(), $method);
            $target = $target->get($arg);
        }

        return (string) $target;
    }
}
