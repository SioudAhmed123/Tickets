<?php

namespace App\Repository;

use App\Entity\Tickets;
use App\Entity\Events;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tickets>
 *
 * @method Tickets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tickets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tickets[]    findAll()
 * @method Tickets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tickets::class,Events::class);
    }
    public function findSimilarTicketsByCategory($categoryId, $currentTicketId)
{
    return $this->createQueryBuilder('t')
        ->innerJoin('t.event_id', 'e')
        ->where('e.Category = :categoryId')
        ->andWhere('t.id != :currentTicketId')
        ->setParameter('categoryId', $categoryId)
        ->setParameter('currentTicketId', $currentTicketId)
        ->getQuery()
        ->getResult();
}

//    /**
//     * @return Tickets[] Returns an array of Tickets objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tickets
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
