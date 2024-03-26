<?php

namespace App\Tests\Functional\Event;

use App\Entity\Provider;
use App\EventSubscriber\PopulateStatsSubscriber;
use App\Services\Provider\PriceProvider;
use App\Tests\Fixtures\ThereIs\ThereIs;
use App\Tests\Fixtures\ThereIs\ThereIsTrait;
use App\Tests\Mock\HttpMockClientFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PopulateStatsTest extends KernelTestCase
{
    use ThereIsTrait;

    /**
     * @before
     */
    public function initMock(): void
    {
        $factory = self::getContainer()->get(HttpMockClientFactory::class);
        $factory->addResponse('GET', 'http://test.com/buy/1', '<div class="price"><span>15€</span></div>');
        $factory->addResponse('GET', 'http://test.com/buy/2', '<div class="price"><span>hello there</span></div>');
    }

    public function test_populate_on_success(): void
    {
        $priceProvider = self::getContainer()->get(PriceProvider::class);
        [$data] = ThereIs::aProductData()->withData([
            'dummyprovider-id' => 1,
        ])();
        $provider = new Provider('dummyprovider', 'http://test.com');
        ThereIs::aProviderAdapter()->withProvider($provider)->withUrl('/buy/{id}')();

        $priceProvider->getPrices($data->getProduct());

        $this->assertEquals(['dummyprovider' => ['success' => 1, 'failed' => 0, 'skiped' => 0]], $this->getPopulateStatsSubscriber()->fomartStats());
    }

    public function test_populate_on_fail(): void
    {
        $priceProvider = self::getContainer()->get(PriceProvider::class);
        [$data] = ThereIs::aProductData()->withData([
            'dummyprovider-id' => 2,
        ])();
        $provider = new Provider('dummyprovider', 'http://test.com');
        ThereIs::aProviderAdapter()->withProvider($provider)->withUrl('/buy/{id}')();

        $priceProvider->getPrices($data->getProduct());

        $this->assertEquals(['dummyprovider' => ['success' => 0, 'failed' => 1, 'skiped' => 0]], $this->getPopulateStatsSubscriber()->fomartStats());
    }

    public function test_populate_both(): void
    {
        $priceProvider = self::getContainer()->get(PriceProvider::class);
        [$data] = ThereIs::aProductData()->withData([
            'dummyprovider-id' => 1,
        ])();
        [$dataSecond] = ThereIs::aProductData()->withData([
            'dummyprovider-id' => 2,
        ])();
        $provider = new Provider('dummyprovider', 'http://test.com');
        ThereIs::aProviderAdapter()->withProvider($provider)->withUrl('/buy/{id}')();

        $priceProvider->getPrices($data->getProduct());
        $priceProvider->getPrices($dataSecond->getProduct());

        $this->assertEquals(['dummyprovider' => ['success' => 1, 'failed' => 1, 'skiped' => 0]], $this->getPopulateStatsSubscriber()->fomartStats());
    }

    private function getPopulateStatsSubscriber(): PopulateStatsSubscriber
    {
        return self::getContainer()->get(PopulateStatsSubscriber::class);
    }
}
