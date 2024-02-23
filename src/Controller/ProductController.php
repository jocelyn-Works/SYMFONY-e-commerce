<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function index(Environment $environement): Response
    {
        return $this->render('product/index.html.twig', []);
    }

    #[Route('/h/{category}', name: 'product_category')]
    public function Category(
        $category,
        ProductRepository $productrepository,
    ): Response {

        $product = $productrepository->findProductCategory($category);

        $totalProducts = count($product);

        return $this->render('product/category.html.twig', [
            'products' => $product,
            'category' => $category,
            'totalProducts' => $totalProducts,


        ]);
    }

    #[Route('/h/{category}/{id}', name: 'product_show')]
    public function ProductShow(
        int $id,
        $category,
        ProductRepository $productRepository
    ): Response {
        $product = $productRepository->findProductWithId($id, $category);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        

        return $this->render('product/product_show.html.twig', [
            'product' => $product,
            'category' => $category,
        ]);
    }


    #[Route('/hh/{category}/{subCategory}', name: 'category_subCategory')]
    public function subCategory(
        $category,
        $subCategory,
        ProductRepository $productrepository,
    ): Response {
        $product = $productrepository->findProductCategory_subCategory($category, $subCategory);
        // dd($product,$category, $subCategory);
        $totalProducts = count($product);

        return $this->render('product/category_subCategory.html.twig', [
            'products' => $product,
            'category' => $category,
            'subCategory' => $subCategory,
            'totalProducts' => $totalProducts,

        ]);
    }




    #[Route('/hh/{category}/{subCategory}/{id}', name: 'product_show_category')]
    public function ProductShowCategory(
        int $id,
        $category,
        $subCategory,
        ProductRepository $productRepository
    ): Response {
        $product = $productRepository->findProductWithIdCategory($id, $category, $subCategory);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('product/product_show_category.html.twig', [
            'product' => $product,
            'category' => $category,
            'subCategory' => $subCategory,
        ]);
    }
}
