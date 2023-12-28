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
    if(isset($panier[$id])){
        $panier[$id]++; 
    }else{
        $panier[$id] = 1;
    }
   
    $this->session->set('panier',$panier); 
}

public function remove($id){
    $panier=$this->session->get('panier',[]);
    if(!empty($panier[$id])){
        unset($panier[$id]);  
    }
   
    $this->session->set('panier',$panier);
    $this->getTotal($this->getFullCart());
}

public function getFullCart() : array{
    $panier=$this->session->get('panier',[]);
    $panierwithData = [];
    foreach($panier as $p => $q){
        $product = $this->productRepository->find($p);
        if(!is_null($product)){
            $panierwithData[$p] = [
                    "pr" => $product,
                    "qantity" => $q
            ];
        }
    }
    //$this->session->set('panier',$panierwithData); 

    return $panierwithData;
}

public function getTotal($panierwithData) : float{
    $total = 0;
    foreach($panierwithData as $item){
      $total= $total + ($item["pr"]->getPrice() * $item["qantity"]);
    }
    return $total;
}
}