<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'maker.doctrine_helper' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/maker-bundle/src/Doctrine/DoctrineHelper.php';

return $this->privates['maker.doctrine_helper'] = new \Symfony\Bundle\MakerBundle\Doctrine\DoctrineHelper('App\\Entity', ($this->privates['maker.php_compat_util'] ?? $this->load('getMaker_PhpCompatUtilService.php')), ($this->services['doctrine'] ?? $this->getDoctrineService()), false, ['default' => [0 => [0 => 'App\\Entity', 1 => ($this->privates['doctrine.orm.default_annotation_metadata_driver'] ?? $this->load('getDoctrine_Orm_DefaultAnnotationMetadataDriverService.php'))]]]);
