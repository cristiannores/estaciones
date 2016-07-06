<?php

namespace Mappers\Factory\Recurso;

use Mappers\Service\Recurso\RecursoService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Clase factory Recurso
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class RecursoServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RecursoService($serviceLocator->get('Mappers\Mapper\Recurso\ZendDbSqlMapper'));
    }


}
