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

    #[Route('/M/hommes', name: 'product_Men')]
    public function Men(
        ProductRepository $productrepositoty,
        ImageProductRepository $imageProductrepository
    ): Response {
        $product = $productrepositoty->findall();
        $images = $imageProductrepository->findall();
        return $this->render('product/hommes.html.twig', [
            'products' => $product,
            'images' => $images

        ]);
    }

    #[Route('/product/{id}', name: 'product_show')]
    public function Productid(int $id, ProductRepository $productRepository, ImageProductRepository $imageProductRepository): Response
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
