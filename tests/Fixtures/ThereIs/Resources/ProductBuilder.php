<?php

namespace App\Tests\Fixtures\ThereIs\Resources;

use App\Tests\Fixtures\Factory\ProductFactory;

class ProductBuilder extends AbstractBuilder
{
    private bool $active = true;

    public function getFactoryFQCN(): string
    {
        return ProductFactory::class;
    }

    public function getParameters(): array
    {
        return [
            'active' => $this->active,
        ];
    }

    public function inactive(): self
    {
        $this->active = false;

        return $this;
    }

    public function active(): self
    {
        $this->active = true;

        return $this;
    }
}
