<?php

namespace App\Repository;

use App\Entity\TileImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TileImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TileImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TileImage[]    findAll()
 * @method TileImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TileImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TileImage::class);
    }

    // /**
    //  * @return TileImage[] Returns an array of TileImage objects
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
    public function findOneBySomeField($value): ?TileImage
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
