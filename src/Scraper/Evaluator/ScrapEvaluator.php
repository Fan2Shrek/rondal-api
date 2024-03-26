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
    private array $skiped = [];

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

    public function addSkiped(Provider $provider): void
    {
        if (in_array($provider, $this->trackedProvider)) {
            ++$this->skiped[$provider->getName()];
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
        dump();
        $this->trackedProvider[] = $provider;

        $this->skiped[$provider->getName()] = 0;
        $this->failed[$provider->getName()] = 0;
        $this->success[$provider->getName()] = 0;
    }

    /**
     * @return array{
     *   success: array<string, int>,
     *   failed: array<string, int>,
     *   skiped: array<string, int>,
     * }
     */
    public function getStats(): array
    {
        return [
            'success' => $this->success,
            'failed' => $this->failed,
            'skiped' => $this->skiped,
        ];
    }
}
