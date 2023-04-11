<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(SessionInterface $session,ProductRepository $repo)
    {
        $panier=$session->get('panier',[]);
        dd($panier);
        $panierwithData = [];
        foreach($panier as $p =>$q){
            if(!is_null($repo->find($p))){
                $panierwithData[] = [
                    "pr" => $repo->find($p),
                    "qantity" => $q
                   ];
            }
        }
        $session->set('panier',$panierwithData);  

        return $this->render('cart/index.html.twig', ["panier" => $panierwithData]);
    }

    /**
    * @Route("/panier/add/{id}", name="panier_add")
     */
    public function panierAction($id,SessionInterface $session){
        $panier=$session->get('panier',[]);
        if(!empty($panier[$id])){
            $panier[$id]++;  
        }else{
            $panier[$id] = 1;
        }
       
        $session->set('panier',$panier);  
        //dd($session->get('panier'));
        return $this->redirectToRoute('cart_index');
    }
}
