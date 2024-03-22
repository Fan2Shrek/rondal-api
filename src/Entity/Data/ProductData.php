<?php

namespace App\Entity\Data;

use App\Entity\Product;
use App\Repository\Data\ProductDataRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Object\Bag\EntityDataBag;

/**
 * @method mixed get(string $key)
 * @method void set(string $key, mixed $value)
 * @method bool has(string $key)
 * @method void remove(string $key)
 * @method void clear()
 * @method array all()
 */
#[ORM\Entity(repositoryClass: ProductDataRepository::class)]
class ProductData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    #[ORM\Column(type: 'entityBag')]
    private EntityDataBag $informations;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->informations = new EntityDataBag();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function getInformations(): EntityDataBag
    {
        return $this->informations;
    }

    /**
     * @param array<string, int|bool|string> $arguments
     */
    public function __call(string $name, array $arguments): int|string|bool|null
    {
        if (!method_exists($this->informations, $name)) {
            throw new \BadMethodCallException(sprintf('Method "%s" not found in "%s".', $name, EntityDataBag::class));
        }

        return $this->informations->$name(...$arguments);
    }
}
