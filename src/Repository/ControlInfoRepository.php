<?php

namespace App\Repository;

use App\Entity\Adventurer;
use App\Entity\ControlInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ControlInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ControlInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ControlInfo[]    findAll()
 * @method ControlInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControlInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ControlInfo::class);
    }

    // /**
    //  * @return ControlInfo[] Returns an array of ControlInfo objects
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
    public function findOneBySomeField($value): ?ControlInfo
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function findByAdventurerWithUser(Adventurer $adventurer): array
    {
        return $this->createQueryBuilder('c')
                ->addSelect('u')
                ->leftJoin('c.user', 'u')
                ->where('c.adventurer = :a')
                ->setParameter('a', $adventurer)
                ->getQuery()
                ->getResult();
    }
}
