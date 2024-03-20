<?php

namespace App\Tests\Functional;

use App\Entity\Provider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Product;
use App\Entity\ProviderAdapter;
use App\Services\UrlAdapter;

class UrlAdapterTest extends KernelTestCase
{
    public function test_adapt_url(): void
    {
        $product = new Product('test', 'test');
        $product->addData('testprovider-id', 1);
        $adapter = new ProviderAdapter(new Provider('testProvider', 'http://test.com'), '/product/{id}');

        $url = self::getContainer()->get(UrlAdapter::class)->adaptFullUrl($adapter, $product);

        $this->assertSame('http://test.com/product/1', $url);
    }
}
