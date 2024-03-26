<?php

namespace App\EventSubscriber;

use App\Event\Scraping\ScrapingFailedEvent;
use App\Event\Scraping\ScrapingSuccessedEvent;
use App\Scraper\Evaluator\ScrapEvaluator;
use App\Services\StatsExporter;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\EventDispatcher\Event;

class PopulateStatsSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly StatsExporter $statsExporter,
        private readonly ScrapEvaluator $scrapEvaluator,
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
        $this->scrapEvaluator->addFailed($event->provider);
    }

    public function onScrapingSuccess(ScrapingSuccessedEvent $event): void
    {
        $this->scrapEvaluator->addSuccess($event->provider);
    }

    public function exportStats(Event $event): void
    {
        $this->statsExporter->export($this->fomartStats());
    }

    /**
     * @return array{
     *   success: array<string, int>,
     *   failed: array<string, int>,
     *   skiped: array<string, int>,
     * }
     */
    private function getStats(): array
    {
        return $this->scrapEvaluator->getStats();
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function fomartStats(): array
    {
        $stats = $this->getStats();
        $formatted = [];

        foreach ($stats as $status => $providerStats) {
            foreach ($providerStats as $name => $value) {
                $formatted[$name][$status] = $value;
            }
        }

        return $formatted;
    }
}
