<?php

namespace Mappers\Factory\Privilegio;

use Mappers\Service\Privilegio\PrivilegioService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Clase factory Privilegio
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class PrivilegioServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PrivilegioService($serviceLocator->get('Mappers\Mapper\Privilegio\ZendDbSqlMapper'));
    }


}
