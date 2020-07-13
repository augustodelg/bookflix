<?php

namespace App\Repository;

use App\Entity\RegistroEventos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RegistroEventos|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegistroEventos|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegistroEventos[]    findAll()
 * @method RegistroEventos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistroEventosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegistroEventos::class);
    }

    public function buscarRegistros($libro_id,$perfil_id,$cuenta_id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT DISTINCT r.id_cuenta, r.id_perfil, r.id_libro, r.id_capitulo
             FROM App\Entity\RegistroEventos r
             WHERE r.id_cuenta = :cuenta and r.id_perfil = :perfil and r.id_libro = :libro
                "
        );
        $query->setParameter('cuenta',$cuenta_id);
        $query->setParameter('perfil',$perfil_id);
        $query->setParameter('libro',$libro_id);
        
        return $query->getResult();
    }

    // /**
    //  * @return RegistroEventos[] Returns an array of RegistroEventos objects
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
    public function findOneBySomeField($value): ?RegistroEventos
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
