<?php

namespace App\Repository;

use App\Entity\TeacherHasBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeacherHasBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeacherHasBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeacherHasBook[]    findAll()
 * @method TeacherHasBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherHasBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeacherHasBook::class);
    }

    // /**
    //  * @return TeacherHasBook[] Returns an array of TeacherHasBook objects
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
    public function findOneBySomeField($value): ?TeacherHasBook
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
