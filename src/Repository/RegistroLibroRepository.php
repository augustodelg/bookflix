<?php

namespace App\Repository;

use App\Entity\RegistroLibro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RegistroLibro|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegistroLibro|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegistroLibro[]    findAll()
 * @method RegistroLibro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistroLibroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegistroLibro::class);
    }

    // /**
    //  * @return RegistroLibro[] Returns an array of RegistroLibro objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RegistroLibro
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
