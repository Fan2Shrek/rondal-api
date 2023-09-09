<?php

namespace App\Entity;

use App\Repository\ProviderAdapterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProviderAdapterRepository::class)]
class ProviderAdapter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Provider $provider;

    #[ORM\Column(length: 255)]
    private string $urlSchema;

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    public function getProvider(): Provider
    {
        return $this->provider;
    }

    public function setProvider(Provider $provider): static
    {
        $this->provider = $provider;

        return $this;
    }

    public function getUrlSchema(): string
    {
        return $this->urlSchema;
    }

    public function setUrlSchema(string $urlSchema): static
    {
        $this->urlSchema = $urlSchema;

        return $this;
    }
}
