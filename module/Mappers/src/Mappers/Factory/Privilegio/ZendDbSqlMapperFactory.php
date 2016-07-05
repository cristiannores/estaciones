<?php

namespace Mappers\Factory\Privilegio;

use Mappers\Mapper\Privilegio\ZendDbSqlMapper;
use Mappers\Model\Privilegio\Privilegio;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Clase ZendDbSqlMapperFactory  Privilegio
 *
 * This is a class generated with Zend\Code\Generator.
 *
 * @version 1.0
 * @license Creado por cristian nores para ipservice.cl
 */
class ZendDbSqlMapperFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ZendDbSqlMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),new ClassMethods(false),new Privilegio());
    }


}
