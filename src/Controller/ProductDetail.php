<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product-detail")
 */
class ProductDetail extends AbstractController
{
    /**
     * @Route("/", name="product_detail_index")
     */
    public function index(Request $request): Response
    {
        return $this->render('product_detail/index.html.twig');
    }
}
