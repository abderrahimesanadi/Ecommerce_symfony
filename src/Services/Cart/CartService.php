<?php

namespace App\Services\Cart;

use App\Entity\Panier;
use App\Repository\ProductRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class CartService
{

    protected $session;
    protected $productRepository;
    protected $panierRepository;
    protected $normalizer;
    protected $em;

    public function __construct(
        SessionInterface $session,
        ProductRepository $productRepository,
        PanierRepository $panierRepository,
        EntityManagerInterface $em,
        NormalizerInterface $normalizer
    ) {
        $this->session = $session;
        $this->em = $em;
        $this->productRepository = $productRepository;
        $this->panierRepository = $panierRepository;
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
        return $this->session->get('panier', $panier);
    }
    public function remove($id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
        $this->getTotal($this->getFullCart($panier));
    }

    public function getFullCart($panier = null)
    {
        if (is_null($panier)) {
            $panier = $this->session->get('panier', []);
        }
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
        return $panierwithData;
    }

    public function getTotal($panierwithData): float
    {
        $total = 0;
        foreach ($panierwithData as $item) {
            $total = $total + ($item["pr"]->getPrice() * $item["qantity"]);
        }
        return $total;
    }
}
