<?php

namespace App\Tests\Fixtures\ThereIs\Resources;

use App\Tests\Fixtures\Factory\Data\ProductDataFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zenstruck\Foundry\Proxy;

class ProductDataBuilder extends AbstractBuilder
{
    private array $data = [];
    private readonly EntityManagerInterface $entityManager;

    public function __construct(ContainerInterface $container)
    {
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
    }

    public function getFactoryFQCN(): string
    {
        return ProductDataFactory::class;
    }

    public function withData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function postCreation(Proxy $builder): object
    {
        $productData = $builder->object();

        foreach ($this->data as $key => $value) {
            $productData->set($key, $value);
        }

        $this->entityManager->persist($productData);
        $this->entityManager->flush();

        return $productData;
    }
}
