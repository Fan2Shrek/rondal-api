<?php

namespace App\Domain\Command\Refresh;

use App\Repository\ProviderAdapterRepository;
use App\Services\Provider\PriceProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RefreshProductPriceHandler
{
    public function __construct(
        private readonly PriceProviderInterface $priceProvider,
        private readonly ProviderAdapterRepository $providerAdapterRepository,
    ) {
    }

    public function __invoke(RefreshProductPriceCommand $command): void
    {
        if (null !== $command->providerName) {
            $providerAdapter = $this->providerAdapterRepository->findByProviderName($command->providerName);

            if (null === $providerAdapter) {
                throw new \LogicException(sprintf('Provider %s not found', $command->providerName));
            }

            $priceInfo = $this->priceProvider->getPrice($command->product, $providerAdapter);
        } else {
            $priceInfo = $this->priceProvider->getPrices($command->product);
        }

        dump($priceInfo);
    }
}
