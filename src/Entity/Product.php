<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Domain\Command\Product\ProductActivateCommand;
use App\Domain\Command\Product\ProductDesactivateCommand;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(operations: [
    new GetCollection(),
    new Post(
        '/product/{id}/activate',
        messenger: 'input',
        input: ProductActivateCommand::class,
        output: false,
    ),
    new Post(
        '/product/{id}/desactivate',
        messenger: 'input',
        input: ProductDesactivateCommand::class,
        output: false,
    ),
])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $originalName;

    #[ORM\Column]
    private bool $active;

    public function __construct(string $name, string $originalName)
    {
        $this->name = $name;
        $this->originalName = $originalName;
        $this->active = true;
    }

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): static
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
