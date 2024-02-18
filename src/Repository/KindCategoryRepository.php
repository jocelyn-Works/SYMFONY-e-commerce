<?php

namespace App\Repository;

use App\Entity\KindCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<KindCategory>
 *
 * @method KindCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method KindCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method KindCategory[]    findAll()
 * @method KindCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KindCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KindCategory::class);
    }

//    /**
//     * @return KindCategory[] Returns an array of KindCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('k.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?KindCategory
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
