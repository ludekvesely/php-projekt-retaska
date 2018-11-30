<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product-list")
 */
class ProductListController extends AbstractController
{
    /**
     * @Route("/{id}", name="product_list_category")
     */
    public function category(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        Category $category
    ): Response {
        $products = $productRepository->findBy(['category' => $category]);
        $categories = $categoryRepository->findAll();

        return $this->render('product_list/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $category
        ]);
    }

    /**
     * @Route("/", name="product_list_index")
     */
    public function index(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    ): Response {
        return $this->render('product_list/index.html.twig', [
            'products' => $productRepository->findAll(),
            'categories' => $categoryRepository->findAll()
        ]);
    }
}
