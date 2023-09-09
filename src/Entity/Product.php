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

    /**
     * @var array<string, string>
     */
    #[ORM\Column]
    private array $data = [];

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

    /**
     * @return array<string, string>
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function addData(string $key, string $value): static
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function has(string $key): bool
    {
        return \array_key_exists($key, $this->data);
    }

    public function get(string $key): ?string
    {
        if ($this->has($key)) {
            return $this->data[$key];
        }

        return null;
    }
}
