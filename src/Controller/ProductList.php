<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product-list")
 */
class ProductList extends AbstractController
{
    /**
     * @Route("/", name="product_list_index")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('product_list/index.html.twig', ['products' => $products]);
    }
}
