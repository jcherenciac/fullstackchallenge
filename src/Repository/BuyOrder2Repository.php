<?php

namespace App\Repository;

use App\Entity\BuyOrder2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuyOrder2|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuyOrder2|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuyOrder2[]    findAll()
 * @method BuyOrder2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuyOrder2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuyOrder2::class);
    }

    // /**
    //  * @return BuyOrder2[] Returns an array of BuyOrder2 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BuyOrder2
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
