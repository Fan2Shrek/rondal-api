<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getAllActiveProduct(): array
    {
        return $this->createQueryBuilder('product')
            ->where('product.active = 1')
            ->getQuery()
            ->getResult();
    }

    public function save(Product $entity, bool $flush = false)
    {
        $this->_em->persist($entity);

        if ($flush) {
            $this->_em->flush();
        }
    }
}
