<?php

namespace App\Repository;

use App\Entity\Edificio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Edificio>
 *
 * @method Edificio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Edificio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Edificio[]    findAll()
 * @method Edificio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EdificioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Edificio::class);
    }

    //    /**
    //     * @return Edificio[] Returns an array of Edificio objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Edificio
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
