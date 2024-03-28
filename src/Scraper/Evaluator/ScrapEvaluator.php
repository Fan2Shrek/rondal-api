<?php

namespace App\Scraper\Evaluator;

use App\Entity\Provider;

class ScrapEvaluator
{
    /** @var array<string, int> */
    private array $success = [];

    /** @var array<string, int> */
    private array $failed = [];

    /** @var array<string, int> */
    private array $skipped = [];

    /** @var array<Provider> */
    private array $trackedProvider = [];

    public function addSuccess(Provider $provider): void
    {
        if (in_array($provider, $this->trackedProvider)) {
            ++$this->success[$provider->getName()];
        }
    }

    public function addFailed(Provider $provider): void
    {
        if (in_array($provider, $this->trackedProvider)) {
            ++$this->failed[$provider->getName()];
        }
    }

    public function addSkipped(Provider $provider): void
    {
        if (in_array($provider, $this->trackedProvider)) {
            ++$this->skipped[$provider->getName()];
        }
    }

    public function evaluate(Provider $provider): ?bool
    {
        if (!in_array($provider, $this->trackedProvider)) {
            return null;
        }

        return $this->failed[$provider->getName()] <= 3;
    }

    public function track(Provider $provider): void
    {
        $this->trackedProvider[] = $provider;

        $this->skipped[$provider->getName()] = 0;
        $this->failed[$provider->getName()] = 0;
        $this->success[$provider->getName()] = 0;
    }

    /**
     * @return array{
     *   success: array<string, int>,
     *   failed: array<string, int>,
     *   skipped: array<string, int>,
     * }
     */
    public function getStats(): array
    {
        return [
            'success' => $this->success,
            'failed' => $this->failed,
            'skipped' => $this->skipped,
        ];
    }
}
