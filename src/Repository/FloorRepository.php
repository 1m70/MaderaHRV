<?php

namespace App\Repository;

use App\Entity\Floor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Floor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Floor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Floor[]    findAll()
 * @method Floor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FloorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Floor::class);
    }

    // /**
    //  * @return Floor[] Returns an array of Floor objects
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
    public function findOneBySomeField($value): ?Floor
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
