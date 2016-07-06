<?php

namespace Mappers\Factory\Indicadores;

use Mappers\Service\Indicadores\IndicadoresService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Clase factory Indicadores
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class IndicadoresServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new IndicadoresService($serviceLocator->get('Mappers\Mapper\Indicadores\ZendDbSqlMapper'));
    }


}
