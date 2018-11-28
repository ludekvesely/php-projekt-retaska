<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use App\Repository\CountryRepository;
use App\Repository\DeliveryRepository;
use App\Repository\PaymentRepository;
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
     * @Route("/create/{id}", name="order_form_create_order")
     */
    public function createOrder(
        DeliveryRepository $deliveryRepository,
        PaymentRepository $paymentRepository,
        CountryRepository $countryRepository,
        Product $product
    ): Response {
        $order = new Order();
        $order->setProduct($product);
        $order->setQuantity(1);
        $order->setDelivery($deliveryRepository->findFirst());
        $order->setPayment($paymentRepository->findFirst());
        $order->setCountry($countryRepository->findFirst());
        $order->updateTotalPrice();

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();

        return $this->redirectToRoute('order_form_index', ['id' => $order->getId()]);
    }

    /**
     * @Route("/{id}", name="order_form_index", methods="GET|POST")
     */
    public function index(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_form_index', ['id' => $order->getId()]);
        }

        return $this->render('order_form/index.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }
}
