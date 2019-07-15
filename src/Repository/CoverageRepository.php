<?php

namespace App\Repository;

use App\Entity\Coverage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Coverage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coverage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coverage[]    findAll()
 * @method Coverage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoverageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Coverage::class);
    }

    // /**
    //  * @return Coverage[] Returns an array of Coverage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Coverage
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
