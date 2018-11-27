<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
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
