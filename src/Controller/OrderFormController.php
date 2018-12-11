<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Form\OrderType;
use App\Repository\BasketRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order-form")
 */
class OrderFormController extends AbstractController
{
    /**
     * @Route("/confirm", name="order_form_confirm")
     */
    public function confirm(BasketRepository $basketRepository): Response
    {
        $basketRepository->clear();
        return $this->render('order_form/confirmation.html.twig');
    }

    /**
     * @Route("/", name="order_form_index", methods="GET|POST")
     */
    public function index(
        Request $request,
        BasketRepository $basketRepository,
        ProductRepository $productRepository
    ): Response {
        $em = $this->getDoctrine()->getManager();
        $order = new Order;

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($basketRepository->getBasket() as $orderProductData) {

                $product = $productRepository->find($orderProductData[BasketRepository::KEY_PRODUCT_ID]);

                if (!$product || ($product->getStock() - $orderProductData[BasketRepository::KEY_PRODUCT_AMOUNT]) < 0) {
                    return $this->render('order_form/index.html.twig', [
                        'order' => $order,
                        'form' => $form->createView(),
                        'remainingOnStock' => $product ? $product->getStock() : null
                    ]);
                }

                $orderProduct = new OrderProduct();
                $orderProduct->setName($orderProductData[BasketRepository::KEY_PRODUCT_NAME]);
                $orderProduct->setUnitPrice($orderProductData[BasketRepository::KEY_PRODUCT_PRICE]);
                $orderProduct->setAmount($orderProductData[BasketRepository::KEY_PRODUCT_AMOUNT]);
                $em->persist($orderProduct);
                $order->addProduct($orderProduct);

                $product->setStock($product->getStock() - $orderProductData[BasketRepository::KEY_PRODUCT_AMOUNT]);
            }

            $order->updateTotalPrice();
            $order->setCreated(new \DateTime);
            $em->persist($order);
            $em->flush();

            return $this->redirectToRoute('order_form_confirm');
        }

        return $this->render('order_form/index.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
            'basket' => $basketRepository->getBasket()
        ]);
    }
}
