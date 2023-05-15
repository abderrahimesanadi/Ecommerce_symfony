<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{

    /**
     *@Route("/api/products", name="app_json") 
     */

    public function getAllProducts(ProductRepository $repo): Response
    {
        $products = $repo->findAll();
        return $this->json($products, 200, [], ["groups" => "list_product"]);
    }

    /**
     *@Route("/api/categories", name="app_category") 
     */

    public function getAllCategories(CategoryRepository $repo): Response
    {
        $products = $repo->findAll();
        return $this->json($products, 200, [], ["groups" => "list_category"]);
    }
}
