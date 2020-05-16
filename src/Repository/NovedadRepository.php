<?php

namespace App\Repository;

use App\Entity\Novedad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Novedad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Novedad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Novedad[]    findAll()
 * @method Novedad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NovedadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Novedad::class);
    }

    // /**
    //  * @return Novedad[] Returns an array of Novedad objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Novedad
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
