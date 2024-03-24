<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Product;
use App\Tests\Fixtures\ThereIs\ThereIs;
use App\Tests\Functional\Trait\EntityTrait;
use Zenstruck\Foundry\Test\Factories;

class ProductEndpointTest extends ApiTestCase
{
    use Factories;
    use EntityTrait;

    public function test_get_all_product(): void
    {
        ThereIs::aProduct()(2);

        $response = static::createClient()->request('GET', '/api/products');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@context' => '/api/contexts/Product',
            '@id' => '/api/products',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 2,
        ]);
        $this->assertCount(2, $response->toArray()['hydra:member']);
    }

    public function test_activate_product(): void
    {
        [$product] = ThereIs::aProduct()->inactive()();

        $this->requestAsJson('POST', "/api/products/{$product->getId()}/activate", []);

        $this->assertResponseIsSuccessful();
        $this->assertLastProductStatus(true);
    }

    public function test_desactivate_product(): void
    {
        [$product] = ThereIs::aProduct()->active()();

        $this->requestAsJson('POST', "/api/products/{$product->getId()}/desactivate", []);

        $this->assertResponseIsSuccessful();
        $this->assertLastProductStatus(false);
    }

    private function requestAsJson(string $method, string $uri, array $data): void
    {
        static::createClient()->request($method, $uri, ['headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'], 'json' => $data]);
    }

    private function assertLastProductStatus(bool $status): void
    {
        $product = $this->getLastEntity(Product::class);

        $this->assertSame($status, $product->isActive());
    }
}
