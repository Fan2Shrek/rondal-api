<?php

namespace App\Tests\Fixtures\ThereIs\Resources;

use App\Tests\Fixtures\Factory\Data\ProductDataFactory;
use Zenstruck\Foundry\Proxy;

class ProductDataBuilder extends AbstractBuilder
{
    private array $data = [];

    public function getFactoryFQCN(): string
    {
        return ProductDataFactory::class;
    }

    public function withData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function postCreation(Proxy $builder): object
    {
        $productData = $builder->object();

        foreach ($this->data as $key => $value) {
            $productData->set($key, $value);
        }

        return $productData;
    }
}
