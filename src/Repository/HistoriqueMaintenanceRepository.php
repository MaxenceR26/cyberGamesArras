<?php

namespace App\Repository;

use App\Entity\HistoriqueMaintenance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoriqueMaintenance>
 *
 * @method HistoriqueMaintenance|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoriqueMaintenance|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoriqueMaintenance[]    findAll()
 * @method HistoriqueMaintenance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriqueMaintenanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoriqueMaintenance::class);
    }

//    /**
//     * @return HistoriqueMaintenance[] Returns an array of HistoriqueMaintenance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HistoriqueMaintenance
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
