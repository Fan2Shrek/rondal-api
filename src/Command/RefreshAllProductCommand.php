<?php

namespace App\Command;

use App\Repository\ProductRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Domain\Command\Refresh\RefreshProductPriceCommand;

#[AsCommand('app:refresh:product')]
class RefreshAllProductCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly ProductRepository $productRepository,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->productRepository->getAllActiveProduct() as $product) {
            $this->bus->dispatch(new RefreshProductPriceCommand($product));
        }

        return Command::SUCCESS;
    }
}
