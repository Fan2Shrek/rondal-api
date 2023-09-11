<?php

namespace App\Domain\Command\Product;

use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProductDesactivateHandler
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function __invoke(ProductDesactivateCommand $command): void
    {
        $product = $command->getCurrentResource();
        $product->setActive(false);

        $this->productRepository->save($product, true);
    }
}
