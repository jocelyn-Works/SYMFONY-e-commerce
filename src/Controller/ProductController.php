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
        return $this->render('product/index.html.twig', [
            
        ]);
    }

    #[Route('/M/hommes', name: 'product_Men')]
    public function Men(ProductRepository $productrepositoty,
    ImageProductRepository $imageProductrepository): Response
    {
        $product = $productrepositoty->findall();
        $images = $imageProductrepository->findall();
        return $this->render('product/hommes.html.twig', [
            'products' => $product,
            'images' => $images
            
        ]);
    }
}
