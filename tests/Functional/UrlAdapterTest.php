<?php

namespace App\Tests\Functional;

use App\Entity\Provider;
use App\Services\UrlAdapter;
use App\Entity\ProviderAdapter;
use App\Tests\Fixtures\ThereIs\ThereIs;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;

class UrlAdapterTest extends KernelTestCase
{
    use Factories;

    public function test_adapt_url(): void
    {
        [$data] = ThereIs::aProductData()->withData([
            'testprovider-id' => 1,
        ])();
        $adapter = new ProviderAdapter(new Provider('testProvider', 'http://test.com'), '/product/{id}');

        $url = self::getContainer()->get(UrlAdapter::class)->adaptFullUrl($adapter, $data);

        $this->assertSame('http://test.com/product/1', $url);
    }
}
