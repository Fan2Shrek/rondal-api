<?php

namespace App\Repository;

use App\Entity\ProviderAdapter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProviderAdapter>
 *
 * @method ProviderAdapter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProviderAdapter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProviderAdapter[]    findAll()
 * @method ProviderAdapter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProviderAdapterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProviderAdapter::class);
    }
}
