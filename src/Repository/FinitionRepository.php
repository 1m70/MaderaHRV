<?php

namespace App\Repository;

use App\Entity\Finition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Finition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Finition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Finition[]    findAll()
 * @method Finition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinitionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Finition::class);
    }

    // /**
    //  * @return Finition[] Returns an array of Finition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Finition
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
