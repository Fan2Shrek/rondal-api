<?php

namespace App\Tests\Functional;

use App\Services\Provider\PriceProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Tests\Fixtures\ThereIs\ThereIs;
use App\Entity\Provider;
use App\Tests\Fixtures\ThereIs\ThereIsTrait;
use App\Tests\Mock\HttpMockClientFactory;

class PriceProviderTest extends KernelTestCase
{
    use ThereIsTrait;

    /**
     * @before
     */
    public function initMock(): void
    {
        $factory = self::getContainer()->get(HttpMockClientFactory::class);
        $factory->addResponse('GET', 'http://test.com/buy/1', '<span>15€</span>');
    }

    public function test_get_price_from_product(): void
    {
        $priceProvider = self::getContainer()->get(PriceProvider::class);
        [$data] = ThereIs::aProductData()->withData([
            'yipeetest-id' => 1,
        ])();
        $provider = new Provider('yipeetest', 'http://test.com');
        ThereIs::aProviderAdapter()->withProvider($provider)->withUrl('/buy/{id}')();

        $priceInfo = $priceProvider->refreshPrice($data->getProduct());

        $this->assertEquals(15.0, $priceInfo->getPrices()['yipeetest']);
    }
}
