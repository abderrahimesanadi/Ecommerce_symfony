<?php

namespace App\EventSubscriber;

use App\Repository\CategoryRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use App\Controller\BaseController;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestSubscriber implements EventSubscriberInterface
{
    public $cat_rep;
    public $product_rep;
    public $b_c;

    public function __construct(CategoryRepository $cat_rep, ProductRepository $productRepository, BaseController $b_c)
    {
        $this->cat_rep = $cat_rep;
        $this->b_c = $b_c;
        $this->product_rep = $productRepository;
    }
    public function onKernelRequest(RequestEvent $event)
    {
        //$event->getRequest()->attributes->add(["baseController" => "App\Controller\BaseController::index"]);
        //$event->getRequest()->attributes->add(["base_route_param" => ["rep"  => $this->cat_rep, "productRepository" => $this->product_rep, "request" => $event->getRequest()]]);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
