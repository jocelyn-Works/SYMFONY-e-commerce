<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    // produit ->  images -> category //
    public function findProductCategory($category)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.images', 'i')
            ->addSelect('i')
            ->leftJoin('p.categories', 'c') 
            ->leftJoin('c.kindCategory', 'k')
            ->andWhere('k.name = :category') 
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    // produit ->  stock  -> genre -> taille
    public function findProductStock($gender)
    {
        return $this->createQueryBuilder('p')
            ->select(['p', 's', 'g', 'size'])
            ->leftJoin('p.stocks', 's')
            ->leftJoin('s.gender', 'g')
            ->andWhere('g.name = :gender')
            ->setParameter('gender', $gender)
            ->leftJoin('s.size', 'size')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    // produit  ->  images -> category -> produit id  //
    public function findProductWithId($id, $category)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.images', 'i')
            ->addSelect('i')
            ->leftJoin('p.categories', 'c') 
            ->leftJoin('c.kindCategory', 'k')
            ->andWhere('k.name = :category') 
            ->setParameter('category', $category)
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

            
    }


    // produit  ->  stock -> genre -> taille -> pour un produit ( $id )  //
    public function findProductStockId($gender, $id)
    {
        return $this->createQueryBuilder('p')
            ->select(['p', 's', 'g', 'size'])
            ->leftJoin('p.stocks', 's')
            ->leftJoin('s.gender', 'g')
            ->andWhere('g.name = :gender')
            ->setParameter('gender', $gender)
            ->leftJoin('s.size', 'size')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    // produit ->  images -> category -> sous category //
    public function findProductCategory_subCategory($category, $subCategory)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.images', 'i')
            ->addSelect('i')
            ->leftJoin('p.categories', 'c') 
            ->leftJoin('c.kindCategory', 'k')
            ->andWhere('k.name = :category') 
            ->setParameter('category', $category)
            ->leftJoin('c.subCategory', 's')
            ->andWhere('s.name = :subCategory')
            ->setParameter('subCategory', $subCategory)
            ->getQuery()
            ->getResult();
    }


    
  

    // produit ->  images -> category -> sous category -> pour un produit ( $id )//
    public function findProductWithIdCategory($id, $category, $subCategory)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.images', 'i')
            ->addSelect('i')
            ->leftJoin('p.categories', 'c') 
            ->leftJoin('c.kindCategory', 'k')
            ->andWhere('k.name = :category') 
            ->setParameter('category', $category)
            ->leftJoin('c.subCategory', 's')
            ->andWhere('s.name = :subCategory')
            ->setParameter('subCategory', $subCategory)
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

            
    }







    

   

 

//    /**
//     * @return Product[] Returns an array of Product objects
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

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
