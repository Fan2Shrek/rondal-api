<?php

namespace App\Command;

use App\Domain\Command\Refresh\RefreshProductPriceCommand;
use App\EventSubscriber\PopulateStatsSubscriber;
use App\Repository\ProductRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand('app:refresh:product')]
class RefreshAllProductCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly ProductRepository $productRepository,
        private readonly PopulateStatsSubscriber $populateStatsSubscriber,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Refresh all product prices')
            ->addOption('stats', null, InputOption::VALUE_NEGATABLE, 'Display stats', true);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->productRepository->getAllActiveProduct() as $product) {
            $io->section(sprintf('Asking for %s...', $product->getName()));

            $this->bus->dispatch(new RefreshProductPriceCommand($product));
        }

        if ($input->getOption('stats')) {
            $this->displayStats($io);
        }

        return Command::SUCCESS;
    }

    private function displayStats(SymfonyStyle $io): void
    {
        $stats = $this->populateStatsSubscriber->fomartStats();

        $io->section('Stats');
        $io->table(
            ['Provider', 'Success', 'Failed', 'Skiped'],
            array_map(
                fn ($provider, $stats) => [
                    $provider,
                    $stats['success'] ?? 0,
                    $stats['failed'] ?? 0,
                    $stats['skiped'] ?? 0,
                ],
                array_keys($stats),
                $stats,
            ),
        );
    }
}
