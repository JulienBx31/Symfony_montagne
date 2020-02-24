<?php

namespace App\Repository;

use App\Entity\Custumer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Custumer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Custumer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Custumer[]    findAll()
 * @method Custumer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustumerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Custumer::class);
    }

    // /**
    //  * @return Custumer[] Returns an array of Custumer objects
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
    public function findOneBySomeField($value): ?Custumer
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
