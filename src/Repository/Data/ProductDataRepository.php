<?php

namespace App\Repository\Data;

use App\Entity\Data\ProductData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Product;

/**
 * @extends ServiceEntityRepository<ProductData>
 *
 * @method ProductData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductData[]    findAll()
 * @method ProductData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductData::class);
    }

    public function findOneByProduct(Product $product): ?ProductData
    {
        return $this->findOneBy(['product' => $product]);
    }
}
