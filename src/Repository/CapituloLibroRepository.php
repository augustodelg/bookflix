<?php

namespace App\Repository;

use App\Entity\CapituloLibro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CapituloLibro|null find($id, $lockMode = null, $lockVersion = null)
 * @method CapituloLibro|null findOneBy(array $criteria, array $orderBy = null)
 * @method CapituloLibro[]    findAll()
 * @method CapituloLibro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapituloLibroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CapituloLibro::class);
    }

    // /**
    //  * @return CapituloLibro[] Returns an array of CapituloLibro objects
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
    public function findOneBySomeField($value): ?CapituloLibro
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
