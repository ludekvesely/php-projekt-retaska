<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/basket")
 */
class BasketController extends AbstractController
{
    /**
     * @Route("/", name="basket_index")
     */
    public function index(BasketRepository $basketRepository): Response
    {
        return $this->render('basket/index.html.twig', [
            'basket' => $basketRepository->getBasket()
        ]);
    }

    /**
     * @Route("/add-product/{id}", name="basket_add")
     */
    public function addProduct(BasketRepository $basketRepository, Product $product): Response
    {
        $basketRepository->addProductToBasket($product);

        return $this->redirectToRoute('basket_index');
    }

    /**
     * @Route("/update-product/{id}/{amount}", name="basket_update")
     */
    public function updateProduct(BasketRepository $basketRepository, Product $product, int $amount): Response
    {
        $basketRepository->updateProductInBasket($product, $amount);

        return $this->redirectToRoute('basket_index');
    }
}
