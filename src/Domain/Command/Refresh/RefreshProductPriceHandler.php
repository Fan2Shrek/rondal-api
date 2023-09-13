<?php

namespace App\Domain\Command\Refresh;

use App\Repository\ProductRepository;
use App\Services\Provider\PriceProvider;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RefreshProductPriceHandler
{
    public function __construct(
        private readonly PriceProvider $priceProvider,
        private readonly ProductRepository $productRepository
    ) {
    }

    public function __invoke(RefreshProductPriceCommand $command): void
    {
        dd($this->priceProvider->getPriceFromProduct($command->getProduct()));
    }
}
