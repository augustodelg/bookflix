<?php

namespace App\Repository;

use App\Entity\Libro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Libro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Libro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Libro[]    findAll()
 * @method Libro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LibroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Libro::class);
    }

    public function portadasIndex ()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT l.foto FROM App:Libro l'
        )->setMaxResults(10)->getResult();
    }
    public function librosHome ()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT l.foto, l.titulo, l.descripcion, l.id FROM App:Libro l'
        )->setMaxResults(10)->getResult();
    }
    
    public function buscarLibro($texto, $criterio)
    {   
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('l')
            ->from('App\Entity\Libro','l');

        switch ($criterio) {
            case "titulo":
                $qb->andWhere( $qb->expr()->like('l.titulo', ':search') );
                break;
            case "autor":
                $qb->innerJoin('l.autor','au')->andWhere($qb->expr()->like('au.nombre', ':search'));
                break;
            case "editorial":
                $qb->innerJoin('l.editorial','ed')->andWhere($qb->expr()->like('ed.nombre', ':search'));
                break;
        } 

         $qb->setParameter('search', '%'.$texto.'%');
                
         $qb->orderBy('l.titulo','ASC');

        return $qb->getQuery()->execute(); //ejecuto el query        


    }



    // /**
    //  * @return Libro[] Returns an array of Libro objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Libro
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
