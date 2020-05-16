<?php

namespace App\Repository;

use App\Entity\Tarjeta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tarjeta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tarjeta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tarjeta[]    findAll()
 * @method Tarjeta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TarjetaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tarjeta::class);
    }

    // /**
    //  * @return Tarjeta[] Returns an array of Tarjeta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tarjeta
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
