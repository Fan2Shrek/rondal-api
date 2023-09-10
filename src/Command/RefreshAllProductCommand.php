<?php

namespace App\Command;

use App\Domain\Command\Refresh\RefreshProductPriceCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand('app:refresh:product')]
class RefreshAllProductCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bus->dispatch(new RefreshProductPriceCommand);

        return Command::SUCCESS;
    }
}
