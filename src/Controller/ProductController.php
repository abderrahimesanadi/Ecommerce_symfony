<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index")
     */
    public function index(ProductRepository $productRepository,CacheInterface $cache,Stopwatch $stopwatch)
    {
        $stopwatch->start("rep_cache");
        $cache->get("list_product",function(ItemInterface $item) use ($productRepository){
            $item->expiresAfter(60);
            return $productRepository->findAll();
        });

        $stopwatch->stop("rep_cache");

        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }

    /**
     * @Route("/products/search/", name="product_search")
     */
    public function search(ProductRepository $productRepository,$searched)
    {
        $products = $productRepository->search($searched);

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
    
}
