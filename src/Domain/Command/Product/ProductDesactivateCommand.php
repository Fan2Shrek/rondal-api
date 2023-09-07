<?php

namespace App\Domain\Command\Product;

use App\Domain\Command\Interface\CurrentResourceAwareInterface;
use App\Entity\Product;

/**
 * @phpstan-implements CurrentResourceAwareInterface<Product>
 */
class ProductDesactivateCommand implements CurrentResourceAwareInterface
{
    private Product $product;

    public function setCurrentResource(object $currentResource): void
    {
        $this->product = $currentResource;
    }

    public function getCurrentResource(): Product
    {
        return $this->product;
    }
}
