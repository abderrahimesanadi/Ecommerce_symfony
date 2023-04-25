<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category_index")
     */
    public function index(CategoryRepository $rep, Request $request): Response
    {
        $categories = $rep->findAll();
        $request->getSession()->set("categories", $categories);
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/products/{id}", name="category_products")
     */
    public function getProductsByCategory($id, ProductRepository $rep_p, CategoryRepository $rep_c): Response
    {
        $products = $rep_p->getProductsByCategory($id);
        $category = $rep_c->find($id);
        return $this->render('category/products.html.twig', [
            'products' => $products,
            'category' => $category,
        ]);
    }
}
