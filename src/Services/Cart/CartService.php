<?php

namespace App\Services\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CartService
{

    protected $session;
    protected $productRepository;
    protected $normalizer;

    public function __construct(SessionInterface $session, ProductRepository $productRepository, NormalizerInterface $normalizer)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->normalizer = $normalizer;
    }


    public function add(int $id)
    {
        $panier = $this->session->get('panier', []);
        if (isset($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function remove($id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
        $this->getTotal($this->getFullCart());
    }

    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);
        $panierwithData = [];
        foreach ($panier as $p => $q) {
            $product = $this->productRepository->find($p);
            if (!is_null($product)) {
                $panierwithData[] = [
                    "pr" => $this->normalizer->normalize($product, null, ["groups" => "product_details"]),
                    "quantity" => $q
                ];
            }
        }
        //$this->session->set('panier',$panierwithData); 
        return $panierwithData;
    }

    public function getTotal($panierwithData): float
    {
        $total = 0;
        foreach ($panierwithData as $item) {
            $total = $total + ($item["pr"]["price"] * $item["qantity"]);
        }
        return $total;
    }
}
