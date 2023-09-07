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

    public function __invoke(ProductDesactivateCommand $command)
    {
        $product = $command->getCurrentResource();
        $product->setActive(0);

        $this->productRepository->save($product, true);
    }
}
