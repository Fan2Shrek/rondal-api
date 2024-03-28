<?php

namespace App\EventSubscriber;

use App\Event\Scraping\ScrapingFailedEvent;
use App\Event\Scraping\ScrapingSkipedEvent;
use App\Event\Scraping\ScrapingSuccessedEvent;
use App\Scraper\Evaluator\ScrapEvaluator;
use App\Services\StatsExporter;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\EventDispatcher\Event;

class PopulateStatsSubscriber implements EventSubscriberInterface
{
    private bool $isActive = false;

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
            ScrapingSkipedEvent::class => 'onScrapingSkiped',
            ConsoleEvents::TERMINATE => 'exportStats',
            KernelEvents::TERMINATE => 'exportStats',
        ];
    }

    public function onScrapingFailed(ScrapingFailedEvent $event): void
    {
        $this->activate();
        $this->scrapEvaluator->addFailed($event->provider);
    }

    public function onScrapingSuccess(ScrapingSuccessedEvent $event): void
    {
        $this->activate();
        $this->scrapEvaluator->addSuccess($event->provider);
    }

    public function onScrapingSkiped(ScrapingSkipedEvent $event): void
    {
        $this->activate();
        $this->scrapEvaluator->addSkipped($event->provider);
    }

    public function exportStats(Event $event): void
    {
        if ($this->isActive) {
            $this->statsExporter->export($this->fomartStats());
        }
    }

    private function activate(): void
    {
        $this->isActive = true;
    }

    /**
     * @return array{
     *   success: array<string, int>,
     *   failed: array<string, int>,
     *   skipped: array<string, int>,
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
