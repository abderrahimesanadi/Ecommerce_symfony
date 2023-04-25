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
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService)
    {

        $panierwithData = $cartService->getFullCart();
        $total = $cartService->getTotal($panierwithData);

        return $this->render('cart/index.html.twig', ["panier" => $panierwithData, "total" => $total]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function panierAction($id, CartService $cartService)
    {
        $cartService->add($id);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/panier/remove/{id}", name="panier_remove", methods={"GET"})
     */
    public function removeAction($id, CartService $cartService, Request $request)
    {
        // $id = $request->attributes->get('_route_params')['id'];
        //$id = $request->request->get('p_id');
        $cartService->remove($id);

        //return $this->json(['message' => 'Produit supprimé avec succes']);
        //return $this->redirectToRoute('cart_index');
        return new JsonResponse("Produit supprimé avec succes");
    }

    /**
     * @Route("/panier/total", name="panier_total", methods={"GET"})
     */
    public function setTotal(CartService $cartService)
    {
        $panierwithData = $cartService->getFullCart();
        $total = $cartService->getTotal($panierwithData);

        return new JsonResponse($total);
    }
}
