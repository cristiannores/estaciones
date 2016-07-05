<?php

namespace Mappers\Factory\Rol;

use Mappers\Service\Rol\RolService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Clase factory Rol
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class RolServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RolService($serviceLocator->get('Mappers\Mapper\Rol\ZendDbSqlMapper'));
    }


}
