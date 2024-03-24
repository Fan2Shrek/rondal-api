<?php

namespace App\Tests\Fixtures\ThereIs\Resources;

use App\Tests\Fixtures\Factory\ProviderFactory;

class ProviderBuilder extends AbstractBuilder
{
    private string $name = null;
    private string $url = null;

    public function getFactoryFQCN(): string
    {
        return ProviderFactory::class;
    }

    public function getParameters(): array
    {
        return array_filter([
            'name' => $this->name,
            'url' => $this->url,
        ]);
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
