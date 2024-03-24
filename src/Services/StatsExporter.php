<?php

namespace App\Services;

use App\Entity\Statistic;
use App\Repository\StatisticRepository;

class StatsExporter
{
    public function __construct(
        private readonly StatisticRepository $statisticRepository,
    ) {
    }

    /** 
     * @param array<string, array<string, int>> $stats 
     */
    public function export(array $stats): void
    {
        $statistic = new Statistic();

        foreach ($stats as $providerName => $providerStats) {
            foreach ($providerStats as $key => $value) {
                $key = sprintf('%s_%s', $key, $providerName);
                $statistic->getData()->set($key, $value);
            }
        }

        $this->statisticRepository->save($statistic);
    }
}
