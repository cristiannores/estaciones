<?php

namespace Mappers\Factory\Usuario;

use Mappers\Service\Usuario\UsuarioService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Clase factory Usuario
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class UsuarioServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UsuarioService($serviceLocator->get('Mappers\Mapper\Usuario\ZendDbSqlMapper'));
    }


}
