<?php

namespace Mappers\Factory\IndicadorEstacion;

use Mappers\Service\IndicadorEstacion\IndicadorEstacionService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Clase factory IndicadorEstacion
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class IndicadorEstacionServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new IndicadorEstacionService($serviceLocator->get('Mappers\Mapper\IndicadorEstacion\ZendDbSqlMapper'));
    }


}
