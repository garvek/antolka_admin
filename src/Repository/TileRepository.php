<?php

namespace App\Repository;

use App\Entity\Tile;
use App\Entity\Zone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tile[]    findAll()
 * @method Tile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tile::class);
    }

    // /**
    //  * @return Tile[] Returns an array of Tile objects
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
    public function findOneBySomeField($value): ?Tile
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function findByIdWithZoneAndRegion(int $id): ?Tile
    {
        return $this->createQueryBuilder('t')
                ->addSelect('z')
                ->addSelect('r')
                ->leftJoin('t.zone', 'z')
                ->leftJoin('z.region', 'r')
                ->where('t.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
    }
    
    public function findByAreaWithZoneAndImage(int $x1, int $y1, int $x2, int $y2, int $z): array
    {
        return $this->createQueryBuilder('t')
                ->addSelect('z')
                ->addSelect('i')
                ->leftJoin('t.zone', 'z')
                ->leftJoin('t.image', 'i')
                ->where('t.x >= :x1')
                ->andWhere('t.y >= :y1')
                ->andWhere('t.x <= :x2')
                ->andWhere('t.y <= :y2')
                ->andWhere('t.z = :z')
                ->setParameter('x1', $x1)
                ->setParameter('y1', $y1)
                ->setParameter('x2', $x2)
                ->setParameter('y2', $y2)
                ->setParameter('z', $z)
                ->getQuery()
                ->getResult();
    }
}
