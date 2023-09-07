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

    public function __invoke(ProductActivateCommand $command)
    {
        $product = $command->getCurrentResource();
        $product->setActive(1);

        $this->productRepository->save($product, true);
    }
}
