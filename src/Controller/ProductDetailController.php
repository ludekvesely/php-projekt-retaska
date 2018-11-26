<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product-detail")
 */
class ProductDetailController extends AbstractController
{
    /**
     * @Route("/{id}", name="product_detail_index")
     */
    public function index(Product $product): Response
    {
        return $this->render('product_detail/index.html.twig', ['product' => $product]);
    }
}
