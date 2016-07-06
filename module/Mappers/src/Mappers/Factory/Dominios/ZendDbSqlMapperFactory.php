<?php

namespace Mappers\Factory\Dominios;

use Mappers\Mapper\Dominios\ZendDbSqlMapper;
use Mappers\Model\Dominios\Dominios;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Clase ZendDbSqlMapperFactory  Dominios
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
        return new ZendDbSqlMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),new ClassMethods(false),new Dominios());
    }


}
