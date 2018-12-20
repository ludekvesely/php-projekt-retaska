<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product-list")
 */
class ProductListController extends AbstractController
{
    /**
     * @Route("/search", name="product_list_search")
     */
    public function search(
        CategoryRepository $categoryRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $search = $request->query->get('search');

        $products = $entityManager
            ->createQuery("SELECT p FROM " . Product::class . " p WHERE p.name LIKE :search")
            ->setParameter('search', "%$search%")
            ->getResult();

        return $this->render('product_list/index.html.twig', [
            'products' => $products,
            'categories' => $categoryRepository->findAll(),
            'search' => $search
        ]);
    }

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
