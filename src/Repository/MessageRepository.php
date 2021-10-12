<?php

namespace App\Repository;

use App\Entity\Adventurer;
use App\Entity\Message;
use App\Entity\Region;
use App\Entity\Zone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOneByIdWithRecipients(int $id): ?Message
    {
        return $this->createQueryBuilder('m')
            ->addSelect('r')
            ->addSelect('rs')
            ->leftJoin('m.recipients', 'rs')
            ->leftJoin('rs.recipient', 'r')
            ->andWhere('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByZoneOrRegion(Zone $zone, Region $region)
    {
        return $this->createQueryBuilder('m')
            ->where('(m.type = :zType) AND (m.tag = :zId)')
            ->orWhere('(m.type = :rType) AND (m.tag = :rId)')
            ->setParameter('zType', Message::TYPE_ZONE)
            ->setParameter('zId', $zone->getId())
            ->setParameter('rType', Message::TYPE_REGION)
            ->setParameter('rId', $region->getId())
            ->getQuery()
            ->getResult();
    }

    public function findByRecipient(Adventurer $recipient): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.recipients', 'rs')
            ->leftJoin('rs.recipient', 'r')
            ->andWhere('r = :r')
            ->setParameter('r', $recipient)
            ->getQuery()
            ->getResult();
    }

    public function findByRecipientAfter(Adventurer $recipient, \DateTimeInterface $after): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.recipients', 'rs')
            ->leftJoin('rs.recipient', 'r')
            ->andWhere('r = :r')
            ->setParameter('r', $recipient)
            ->andWhere('m.published > :after')
            ->setParameter('after', $after)
            ->getQuery()
            ->getResult();
    }
}
