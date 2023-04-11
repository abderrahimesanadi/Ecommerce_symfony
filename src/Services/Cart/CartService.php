<?php
namespace App\Services\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

protected $session;
protected $productRepository;

public function __construct(SessionInterface $session,ProductRepository $productRepository){
  $this->session = $session;
  $this->productRepository = $productRepository;
}


public function add(int $id){
    $panier=$this->session->get('panier',[]);
    if(!empty($panier[$id])){
        $panier[$id]++;  
    }else{
        $panier[$id] = 1;
    }
   
    $this->session->set('panier',$panier);  
}

public function remove(int $id){
    $panier=$this->session->get('panier',[]);
    if(!empty($panier[$id])){
        unset($panier[$id]);  
    }
   
    $this->session->set('panier',$panier);
}

public function getFullCart() : array{
    $panier=$this->session->get('panier',[]);
    $panierwithData = [];
    foreach($panier as $p =>$q){
        if(!is_null($this->productRepository->find($p))){
            $panierwithData[] = [
                "pr" => $this->productRepository->find($p),
                "qantity" => $q
               ];
        }
    }
    $this->session->set('panier',$panierwithData); 
    
    return $panierwithData;
}

public function getTotal() : float{
    $total = 0;
    $panierwithData = $this->getFullCart();
    foreach($panierwithData as $item){
            $total+=$item["pr"]->getPrice() * $item["qantity"];
    }

    return $total;
}
}