<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    // /**
    //  * @return Vehicle[] Returns an array of Vehicle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vehicle
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function findByIdWithPassengerAdventurerAndZone(int $id): ?Vehicle
    {
        return $this->createQueryBuilder('v')
                ->addSelect('p')
                ->addSelect('a')
                ->addSelect('i')
                ->addSelect('z')
                ->leftJoin('v.passengers', 'p')
                ->leftJoin('p.adventurer', 'a')
                ->leftJoin('v.tile', 'i')
                ->leftJoin('i.zone', 'z')
                ->where('v.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
    }
    
    public function findByAreaWithPassengerAdventurerAndZone(int $x1, int $y1, int $x2, int $y2, int $z): array
    {
        return $this->createQueryBuilder('v')
                ->addSelect('p')
                ->addSelect('a')
                ->addSelect('i')
                ->addSelect('z')
                ->leftJoin('v.passengers', 'p')
                ->leftJoin('p.adventurer', 'a')
                ->leftJoin('v.tile', 'i')
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
