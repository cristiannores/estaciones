<?php

namespace Mappers\Factory\Recurso;

use Mappers\Mapper\Recurso\ZendDbSqlMapper;
use Mappers\Model\Recurso\Recurso;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Clase ZendDbSqlMapperFactory  Recurso
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
        return new ZendDbSqlMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),new ClassMethods(false),new Recurso());
    }


}
