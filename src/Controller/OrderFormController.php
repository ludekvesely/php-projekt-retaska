<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order-form")
 */
class OrderFormController extends AbstractController
{
    /**
     * @Route("/", name="order_form_index")
     */
    public function index(): Response
    {
        return $this->render('order_form/index.html.twig');
    }
}
