<?php

namespace App\Repository;

use App\Entity\DescriptionUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DescriptionUser>
 *
 * @method DescriptionUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method DescriptionUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method DescriptionUser[]    findAll()
 * @method DescriptionUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescriptionUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DescriptionUser::class);
    }

//    /**
//     * @return DescriptionUser[] Returns an array of DescriptionUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

public function findUserDescription($userId): array
{
    return $this->createQueryBuilder('d')
        ->leftJoin('d.author', 'a') 
        ->andWhere('a.id = :userId')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getResult();
}
}
