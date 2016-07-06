<?php

namespace Mappers\Factory\Estacion;

use Mappers\Service\Estacion\EstacionService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Clase factory Estacion
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class EstacionServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new EstacionService($serviceLocator->get('Mappers\Mapper\Estacion\ZendDbSqlMapper'));
    }


}
