<?php

namespace Mappers\Factory\EstacionUsuario;

use Mappers\Service\EstacionUsuario\EstacionUsuarioService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Clase factory EstacionUsuario
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class EstacionUsuarioServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new EstacionUsuarioService($serviceLocator->get('Mappers\Mapper\EstacionUsuario\ZendDbSqlMapper'));
    }


}
