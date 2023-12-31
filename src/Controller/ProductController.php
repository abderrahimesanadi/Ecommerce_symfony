<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchProductFormType;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="products_index")
     */
    public function index(ProductRepository $productRepository, CacheInterface $cache)
    {
        //$stopwatch->start("rep_cache");

        $products = $productRepository->findAll();
        $cache->get("list_product", function (ItemInterface $item) use ($products) {
            $item->expiresAfter(60);
            return  $products;
        });
        //$stopwatch->stop("rep_cache");

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }


    /**
     * @Route("/products/search", name="product_search")
     */
    public function search(Request $request, ProductRepository $productRepository)
    {
        $formSearch = $this->createForm(SearchProductFormType::class);
        $formSearch->handleRequest($request);
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            $searched = $formSearch->get("searched")->getData();
            $products = $productRepository->searchProducts($searched);
        } else {
            $products = $productRepository->findAll();
        }
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'formSearch' => $formSearch->createView(),

        ]);
    }

    /**
     * @Route("/product/{slug}", name="product_show")
     */

    public function show($slug, Request $request, ProductRepository $productRepository)
    {
        $product = $productRepository->findOneBySlug($slug);
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
