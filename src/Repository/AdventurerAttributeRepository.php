<?php

namespace App\Repository;

use App\Entity\AdventurerAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdventurerAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdventurerAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdventurerAttribute[]    findAll()
 * @method AdventurerAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdventurerAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdventurerAttribute::class);
    }

    // /**
    //  * @return AdventurerAttribute[] Returns an array of AdventurerAttribute objects
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
    public function findOneBySomeField($value): ?AdventurerAttribute
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
