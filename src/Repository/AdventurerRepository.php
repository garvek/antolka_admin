<?php

namespace App\Repository;

use App\Entity\Adventurer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Adventurer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adventurer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adventurer[]    findAll()
 * @method Adventurer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdventurerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adventurer::class);
    }

    // /**
    //  * @return Adventurer[] Returns an array of Adventurer objects
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
    public function findOneBySomeField($value): ?Adventurer
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function findByIdWithAttributesAndZone(int $id): ?Adventurer
    {
        return $this->createQueryBuilder('a')
                ->addSelect('t')
                ->addSelect('i')
                ->addSelect('z')
                ->leftJoin('a.attributes', 't')
                ->leftJoin('a.tile', 'i')
                ->leftJoin('i.zone', 'z')
                ->where('a.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
    }
    
    public function findByAreaWithAttributesAndZone(int $x1, int $y1, int $x2, int $y2, int $z): array
    {
        return $this->createQueryBuilder('a')
                ->addSelect('t')
                ->addSelect('i')
                ->addSelect('z')
                ->leftJoin('a.attributes', 't')
                ->leftJoin('a.tile', 'i')
                ->leftJoin('i.zone', 'z')
                ->where('i.x >= :x1')
                ->andWhere('i.y >= :y1')
                ->andWhere('i.x <= :x2')
                ->andWhere('i.y <= :y2')
                ->andWhere('i.z = :z')
                ->setParameter('x1', $x1)
                ->setParameter('y1', $y1)
                ->setParameter('x2', $x2)
                ->setParameter('y2', $y2)
                ->setParameter('z', $z)
                ->getQuery()
                ->getResult();
    }
}
