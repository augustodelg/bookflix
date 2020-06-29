<?php

namespace App\Repository;

use App\Entity\CalificacionComentario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CalificacionComentario|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalificacionComentario|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalificacionComentario[]    findAll()
 * @method CalificacionComentario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalificacionComentarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalificacionComentario::class);
    }

    // /**
    //  * @return CalificacionComentario[] Returns an array of CalificacionComentario objects
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
    public function findOneBySomeField($value): ?CalificacionComentario
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
