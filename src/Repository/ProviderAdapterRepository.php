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
final class ProviderAdapterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProviderAdapter::class);
    }

    public function findByProviderName(string $providerName): ?ProviderAdapter
    {
        return $this->createQueryBuilder('pa')
            ->join('pa.provider', 'p')
            ->where('p.name = :providerName')
            ->setParameter('providerName', $providerName)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
