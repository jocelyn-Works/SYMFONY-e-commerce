<?php

namespace App\Repository;

use App\Entity\AdressUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DescriptionUser>
 *
 * @method AdressUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdressUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdressUser[]    findAll()
 * @method AdressUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdressUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdressUser::class);
    }

//    /**
//     * @return AdressUser[] Returns an array of AdressUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('A')
//            ->andWhere('A.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('A.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

public function findUserAdress($userId): array
{
    return $this->createQueryBuilder('A')
        ->leftJoin('A.author', 'a') 
        ->andWhere('a.id = :userId')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getResult();
}
}
