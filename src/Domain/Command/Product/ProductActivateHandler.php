<?php

namespace App\Domain\Command\Product;

use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProductActivateHandler
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function __invoke(ProductActivateCommand $command): void
    {
        $product = $command->getCurrentResource();
        $product->setActive(true);

        $this->productRepository->save($product, true);
    }
}
