<?php

namespace App\Controller;

use App\Services\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService)
    {
        $panierwithData = $cartService->getFullCart(); 
        $total = $cartService->getTotal($panierwithData);
       
        return $this->render('cart/index.html.twig', ["panier" => $panierwithData,"total" => $total]);
    }

    /**
    * @Route("/panier/add/{id}", name="panier_add")
     */
    public function panierAction($id,CartService $cartService){
        $cartService->add($id);  
        return $this->redirectToRoute('cart_index');
    }

    /**
    * @Route("/panier/remove/{id}", name="panier_remove")
     */
    public function removeAction($id,CartService $cartService){
        $cartService->remove($id);  

        return $this->redirectToRoute('cart_index');
    }
}
