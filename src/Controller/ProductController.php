<?php

namespace App\Controller;

use App\Repository\ImageProductRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', []);
    }

    #[Route('/chaussures_hommes', name: 'product_category')]
    public function Men(
        ProductRepository $productrepository,
    ): Response {
        $product = $productrepository->findAllProduct();
        return $this->render('product/category.html.twig', [
            'products' => $product,

        ]);
    }
    // $images = $imageProductrepository->findall();
    // 'images' => $images

    #[Route('/hommes-chaussures/{id}', name: 'product_show')]
    public function Productid(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findProductWithImages($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('product/product_show.html.twig', [
            'product' => $product
        ]);
    }
}
