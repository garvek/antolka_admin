<?php

namespace App\Repository;

use App\Entity\GameLogReader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameLogReader|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameLogReader|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameLogReader[]    findAll()
 * @method GameLogReader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameLogReaderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameLogReader::class);
    }

    // /**
    //  * @return GameLogReader[] Returns an array of GameLogReader objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameLogReader
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
