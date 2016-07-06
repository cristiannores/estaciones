<?php

namespace Mappers\Factory\Dominios;

use Mappers\Service\Dominios\DominiosService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Clase factory Dominios
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class DominiosServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new DominiosService($serviceLocator->get('Mappers\Mapper\Dominios\ZendDbSqlMapper'));
    }


}
