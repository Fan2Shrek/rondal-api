<?php

namespace App\Domain\Command\Refresh;

use App\Services\Provider\PriceProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RefreshProductPriceHandler
{
    public function __construct(
        private readonly PriceProviderInterface $priceProvider,
    ) {
    }

    public function __invoke(RefreshProductPriceCommand $command): void
    {
        $this->priceProvider->getPrices($command->product);
    }
}
