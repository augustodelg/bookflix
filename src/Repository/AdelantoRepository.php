<?php

namespace App\Repository;

use App\Entity\Adelanto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Adelanto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adelanto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adelanto[]    findAll()
 * @method Adelanto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdelantoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adelanto::class);
    }

    public function AdelantosInicio()
    {
        return $this -> getEntityManager()

        ->createQuery(
            'SELECT a.titulo , a.contenido , a.id
            FROM App:Adelanto a '
        )->getResult();
    }

    // /**
    //  * @return Adelanto[] Returns an array of Adelanto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Adelanto
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
