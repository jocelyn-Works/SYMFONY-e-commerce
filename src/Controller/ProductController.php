<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    // #[Route('/product', name: 'product')]
    // public function index(): Response
    // {
    //     return $this->render('product/index.html.twig', []);
    // }

    #[Route('/fr/{gender}/{category}', name: 'product_category')]
    public function Category(
        $category,
        $gender,
        ProductRepository $productRepository,
    ): Response {

        $product = $productRepository->findProductCategory($category);

        $stock = $productRepository->findProductStock($gender);

        $totalProducts = count($product);

        return $this->render('product/category.html.twig', [
            'products' => $product,
            'category' => $category,
            'gender' => $gender,
            'stocks' => $stock,
            'totalProducts' => $totalProducts,


        ]);
    }

    #[Route('/fr/{gender}/{category}/{productName}/{id}', name: 'product_show')]
    public function ProductShow(
        int $id,
        $productName,
        $category,
        $gender,
        ProductRepository $productRepository
    ): Response {

        $product = $productRepository->findProductWithId($id, $category);

        // dd($product);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $stock = $productRepository->findProductStockId($productName, $gender);


        // dd($stock);
        return $this->render('product/product_show.html.twig', [
            'product' => $product,
            'productName' => $productName,
            'category' => $category,
            'gender' => $gender,
            'stocks' => $stock
        ]);
    }


    #[Route('/fr/{gender}/{category}/{subCategory}', name: 'category_subCategory')]
    public function subCategory(
        $category,
        $subCategory,
        $gender,
        ProductRepository $productRepository,
    ): Response {
        $product = $productRepository->findProductCategory_subCategory($category, $subCategory);
        // dd($product,$category, $subCategory);

        $stock = $productRepository->findProductStock($gender);

        $totalProducts = count($product);

        return $this->render('product/category_subCategory.html.twig', [
            'products' => $product,
            'category' => $category,
            'subCategory' => $subCategory,
            'stocks' => $stock,
            'gender' => $gender,
            'totalProducts' => $totalProducts,

        ]);
    }




    #[Route('/fr/{gender}/{category}/{subCategory}/{productName}/{id}', name: 'product_show_category')]
    public function ProductShowCategory(
        int $id,
        $productName,
        $category,
        $subCategory,
        $gender,
        ProductRepository $productRepository
    ): Response {

        $product = $productRepository->findProductWithIdCategory($id, $category, $subCategory);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $stock = $productRepository->findProductStockId($productName, $gender);

        return $this->render('product/product_show_category.html.twig', [
            'product' => $product,
            'productName' => $productName,
            'category' => $category,
            'subCategory' => $subCategory,
            'gender' => $gender,
            'stocks' => $stock
        ]);
    }
}
