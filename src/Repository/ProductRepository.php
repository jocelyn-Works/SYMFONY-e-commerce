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


        public function findAllProduct()
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.images', 'i')
            ->addSelect('i')
            ->getQuery()
            ->getResult();
    }

    public function findProductCategory($category)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.images', 'i')
            ->addSelect('i')
            ->leftJoin('p.categories', 'c') // Assurez-vous que la relation dans Product est bien "categories"
            ->leftJoin('c.kindCategory', 'k')
            ->andWhere('k.name = :category') // Assurez-vous que le champ est correct, utilisez "nom" d'après votre exemple
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function findProductCategory_subCategory($category, $subCategory)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.images', 'i')
            ->addSelect('i')
            ->leftJoin('p.categories', 'c') // Assurez-vous que la relation dans Product est bien "categories"
            ->leftJoin('c.kindCategory', 'k')
            ->andWhere('k.name = :category') // Assurez-vous que le champ est correct, utilisez "nom" d'après votre exemple
            ->setParameter('category', $category)
            ->leftJoin('c.subCategory', 's')
            ->andWhere('s.name = :subCategory')
            ->setParameter('subCategory', $subCategory)
            ->getQuery()
            ->getResult();
    }

    public function findSubCategoriesForCategory()
    {
        return $this->createQueryBuilder('p')
        ->leftJoin('p.categories', 'c')
        ->leftJoin('c.subCategory', 's')
        ->select('s.name as subCategory')
        ->distinct()
        ->getQuery()
        ->getResult();
    }

    public function findProductWithId($id, $category)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.images', 'i')
            ->addSelect('i')
            ->leftJoin('p.categories', 'c') // Assurez-vous que la relation dans Product est bien "categories"
            ->leftJoin('c.kindCategory', 'k')
            ->andWhere('k.name = :category') // Assurez-vous que le champ est correct, utilisez "nom" d'après votre exemple
            ->setParameter('category', $category)
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

            
    }
  

    public function findProductWithIdCategory($id, $category, $subCategory)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.images', 'i')
            ->addSelect('i')
            ->leftJoin('p.categories', 'c') // Assurez-vous que la relation dans Product est bien "categories"
            ->leftJoin('c.kindCategory', 'k')
            ->andWhere('k.name = :category') // Assurez-vous que le champ est correct, utilisez "nom" d'après votre exemple
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
