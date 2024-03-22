<?php

namespace App\Tests\Fixtures\ThereIs\Resources;

use App\Entity\Provider;
use App\Entity\ProviderAdapter;
use App\Tests\Fixtures\ThereIs\ThereIs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProviderAdapterBuilder
{
    private string $url;
    private Provider $provider;
    private EntityManagerInterface $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->entityManager = $container->get(EntityManagerInterface::class);
    }

    public function __invoke(): ProviderAdapter
    {
        if (null === ($this->provider ?? null)) {
            [$this->provider] = ThereIs::aProvider()();
        }

        $adapter = new ProviderAdapter($this->provider, $this->url);

        $this->entityManager->persist($adapter);
        $this->entityManager->flush();

        return $adapter;
    }

    public function withProvider(Provider $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function withUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
