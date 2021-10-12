<?php

namespace App\Repository;

use App\Entity\Adventurer;
use App\Entity\VehiclePassenger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VehiclePassenger|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehiclePassenger|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehiclePassenger[]    findAll()
 * @method VehiclePassenger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiclePassengerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehiclePassenger::class);
    }

    // /**
    //  * @return VehiclePassenger[] Returns an array of VehiclePassenger objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VehiclePassenger
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function findByAdventurerWithVehicle(Adventurer $adventurer): ?VehiclePassenger
    {
        return $this->createQueryBuilder('p')
                ->addSelect('v')
                ->leftJoin('p.vehicle', 'v')
                ->where('p.adventurer = :a')
                ->setParameter('a', $adventurer)
                ->getQuery()
                ->getOneOrNullResult();
    }
}
