<?php

namespace Mappers\Factory\RolJerarquia;

use Mappers\Service\RolJerarquia\RolJerarquiaService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Clase factory RolJerarquia
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class RolJerarquiaServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RolJerarquiaService($serviceLocator->get('Mappers\Mapper\RolJerarquia\ZendDbSqlMapper'));
    }


}
