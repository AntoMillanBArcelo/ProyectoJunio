<?php

namespace App\Repository;

use App\Entity\NivelEducativo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NivelEducativo>
 *
 * @method NivelEducativo|null find($id, $lockMode = null, $lockVersion = null)
 * @method NivelEducativo|null findOneBy(array $criteria, array $orderBy = null)
 * @method NivelEducativo[]    findAll()
 * @method NivelEducativo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NivelEducativoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NivelEducativo::class);
    }

    //    /**
    //     * @return NivelEducativo[] Returns an array of NivelEducativo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?NivelEducativo
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
