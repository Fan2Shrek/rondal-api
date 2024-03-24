<?php

namespace App\EventSubscriber;

use App\Event\Scraping\ScrapingFailedEvent;
use App\Event\Scraping\ScrapingSuccessedEvent;
use App\Services\StatsExporter;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\EventDispatcher\Event;

class PopulateStatsSubscriber implements EventSubscriberInterface
{
    /** @var array<string, array<string, int>> */
    private array $stats = [];

    public function __construct(
        private readonly StatsExporter $statsExporter,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ScrapingFailedEvent::class => 'onScrapingFailed',
            ScrapingSuccessedEvent::class => 'onScrapingSuccess',
            ConsoleEvents::TERMINATE => 'exportStats',
            KernelEvents::TERMINATE => 'exportStats',
        ];
    }

    public function onScrapingFailed(ScrapingFailedEvent $event): void
    {
        if (!isset($this->stats[$event->provider->getName()]) || !isset($this->stats[$event->provider->getName()]['failed'])) {
            $this->stats[$event->provider->getName()]['failed'] = 0;
        }

        ++$this->stats[$event->provider->getName()]['failed'];
    }

    public function onScrapingSuccess(ScrapingSuccessedEvent $event): void
    {
        if (!isset($this->stats[$event->provider->getName()]) || !isset($this->stats[$event->provider->getName()]['success'])) {
            $this->stats[$event->provider->getName()]['success'] = 0;
        }

        ++$this->stats[$event->provider->getName()]['success'];
    }

    public function exportStats(Event $event): void
    {
        if (!empty($this->stats)) {
            $this->statsExporter->export($this->stats);
        }
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function getStats(): array
    {
        return $this->stats;
    }
}
