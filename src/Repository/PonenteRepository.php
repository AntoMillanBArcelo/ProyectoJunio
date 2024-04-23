<?php

namespace App\Repository;

use App\Entity\Ponente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ponente>
 *
 * @method Ponente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ponente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ponente[]    findAll()
 * @method Ponente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PonenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ponente::class);
    }

    //    /**
    //     * @return Ponente[] Returns an array of Ponente objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ponente
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
