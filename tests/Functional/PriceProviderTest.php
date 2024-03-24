<?php

namespace App\Tests\Functional;

use App\Entity\Provider;
use App\Services\Provider\PriceProvider;
use App\Tests\Fixtures\ThereIs\ThereIs;
use App\Tests\Fixtures\ThereIs\ThereIsTrait;
use App\Tests\Mock\HttpMockClientFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PriceProviderTest extends KernelTestCase
{
    use ThereIsTrait;

    /**
     * @before
     */
    public function initMock(): void
    {
        $factory = self::getContainer()->get(HttpMockClientFactory::class);
        $factory->addResponse('GET', 'http://test.com/buy/1', '<div class="price"><span>15€</span></div>');
    }

    public function test_get_price_from_product(): void
    {
        [$data] = ThereIs::aProductData()->withData([
            'dummyprovider-id' => 1,
        ])();
        $provider = new Provider('dummyprovider', 'http://test.com');
        ThereIs::aProviderAdapter()->withProvider($provider)->withUrl('/buy/{id}')();

        $priceProvider = self::getContainer()->get(PriceProvider::class);
        $priceInfo = $priceProvider->getPrices($data->getProduct());

        $this->assertEquals(15.0, $priceInfo->getPrices()['dummyprovider']);
    }
}
