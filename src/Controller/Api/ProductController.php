<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\DBAL\MultiDbConnectionWrapper;
use phpDocumentor\Reflection\Types\Integer;

class ProductController extends AbstractController
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     *@Route("/api/products", name="app_json") 
     */

    public function getAllProducts(ProductRepository $repo): Response
    {
        //$connection = $this->em->getConnection();
        //$connection->selectDatabase($databaseName);

        $products = $repo->findAll();
        return $this->json($products, 200, [], ["groups" => "list_product"]);
    }

    /**
     *@Route("/api/details/{slug}", name="product_detail") 
     */

    public function getProduct(ProductRepository $repo, $slug): Response
    {

        $product = $repo->findOneBySlug($slug);
        return $this->json($product, 200, [], ["groups" => "product_details"]);
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
