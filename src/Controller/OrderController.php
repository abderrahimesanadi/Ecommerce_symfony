<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Cart\CartService;
use App\Entity\Order;
use App\Entity\Panier;
use App\Repository\PanierRepository;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\User;
use App\Form\RegistrationFormType;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="app_order")
     */
    public function index(CartService $cartService,PanierRepository $panierRep,SessionInterface $session): Response
    {
        $panierwithData = $cartService->getFullCart();
        $total = $cartService->getTotal($panierwithData);
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
            $panier = new Panier();
            foreach($panierwithData as $p){
                $panier->addProduct($p["pr"]);
                $panier->setQuantity(1);
                $panier->setTotal($total);
    
            }
            $panierRep->add($panier,true);
            return $this->render('order/index.html.twig', ["panier" => $panierwithData, "total" => $total,'form' => $form->createView()]);
    }

    /**
     * @Route("/order/create", name="order_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($order);
            $em->flush();

            $this->addFlash(
                'notice',
                'order crée avec succes!'
            );
        }
        
        return $this->redirectToRoute('app_order');
        
    }
}
