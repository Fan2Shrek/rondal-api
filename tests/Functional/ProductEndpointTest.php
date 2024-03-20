<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Fixtures\ThereIs\ThereIs;
use Zenstruck\Foundry\Test\Factories;

class ProductEndpointTest extends ApiTestCase
{
    use Factories;

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
}
