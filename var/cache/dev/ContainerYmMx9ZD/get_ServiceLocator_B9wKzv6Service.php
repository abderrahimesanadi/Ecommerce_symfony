<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.b9wKzv6' shared service.

return $this->privates['.service_locator.b9wKzv6'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'App\\Controller\\CartController::index' => ['privates', '.service_locator.mhUUVen', 'get_ServiceLocator_MhUUVenService.php', true],
    'App\\Controller\\ProductController::index' => ['privates', '.service_locator.PeS.Fgc', 'get_ServiceLocator_PeS_FgcService.php', true],
    'App\\Controller\\CartController:index' => ['privates', '.service_locator.mhUUVen', 'get_ServiceLocator_MhUUVenService.php', true],
    'App\\Controller\\ProductController:index' => ['privates', '.service_locator.PeS.Fgc', 'get_ServiceLocator_PeS_FgcService.php', true],
], [
    'App\\Controller\\CartController::index' => '?',
    'App\\Controller\\ProductController::index' => '?',
    'App\\Controller\\CartController:index' => '?',
    'App\\Controller\\ProductController:index' => '?',
]);
