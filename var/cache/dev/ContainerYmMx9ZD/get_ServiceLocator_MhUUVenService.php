<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.mhUUVen' shared service.

return $this->privates['.service_locator.mhUUVen'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'repo' => ['privates', 'App\\Repository\\ProductRepository', 'getProductRepositoryService.php', true],
    'session' => ['services', 'session', 'getSessionService.php', true],
], [
    'repo' => 'App\\Repository\\ProductRepository',
    'session' => '?',
]);
