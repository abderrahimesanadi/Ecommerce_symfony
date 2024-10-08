<?php

namespace App\Controller;

use App\Services\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{

    /**
     * @Route("api/panier", name="cart_index")
     */
    public function index(CartService $cartService)
    {

        $panierwithData = $cartService->getFullCart();
        $total = $cartService->getTotal($panierwithData);

        return $this->json(["panier" => $panierwithData, "total" => $total], 200);
    }

    /**
     * @Route("api/panier/add/{id}", name="panier_add")
     */
    public function panierAction($id, CartService $cartService)
    {
        $panier = $cartService->add($id);
        $panierwithData = $cartService->getFullCart($panier);

        return $this->json($panierwithData, 200);
    }

    /**
     * @Route("api/panier/remove/{id}", name="panier_remove", methods={"GET"})
     */
    public function removeAction($id, CartService $cartService, Request $request)
    {
        $cartService->remove($id);
        return new JsonResponse("Produit supprimé avec succes");
    }

    /**
     * @Route("api/panier/total", name="panier_total", methods={"GET"})
     */
    public function setTotal(CartService $cartService)
    {
        $panierwithData = $cartService->getFullCart();
        $total = $cartService->getTotal($panierwithData);

        return new JsonResponse($total);
    }
}
