<?php

namespace App\Model;

use App\Entity\Product;

class PriceInfo
{
    private Product $product;

    /**
     * @var array<string, float>
     */
    private array $prices;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->prices = [];
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return array<string, float>
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    public function addPrice(string $provider, float $price): void
    {
        $this->prices[$provider] = $price;
    }
}
