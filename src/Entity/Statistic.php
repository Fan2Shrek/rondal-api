<?php

namespace App\Entity;

use App\Object\Bag\EntityDataBag;
use App\Repository\StatisticRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatisticRepository::class)]
class Statistic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'entityBag')]
    private EntityDataBag $data;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->data = new EntityDataBag();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getData(): EntityDataBag
    {
        return $this->data;
    }
}
