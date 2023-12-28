<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchProductFormType;

class BaseController extends AbstractController
{

    /**
     * @Route("/", name="home_index")
     */

    public function index(CategoryRepository $rep, ProductRepository $productRepository, Request $request): Response
    {
        //return $this->redirectToRoute("app_admin");
        $categories = $rep->findAllAndCount();
        $request->getSession()->set("categories", $categories);
        $products = $productRepository->findAll();
        return $this->render('base.html.twig', [
            'categories' => $categories,
            'products' => $products

        ]);
    }


    public function searchBar()
    {
        $formSearch = $this->createForm(SearchProductFormType::class);

        return $this->render('searchBar.html.twig', [
            'formSearch' => $formSearch->createView(),
        ]);
    }
}
