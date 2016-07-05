<?php
return array(
    'service_manager' => array(
        'factories' => array(
            // Tabla Privilegio 
            'Mappers\Mapper\Privilegio\ZendDbSqlMapper' => 'Mappers\Factory\Privilegio\ZendDbSqlMapperFactory',
            'Mappers\Service\Privilegio\PrivilegioService' => 'Mappers\Factory\Privilegio\PrivilegioServiceFactory',
            // Tabla Recurso 
            'Mappers\Mapper\Recurso\ZendDbSqlMapper' => 'Mappers\Factory\Recurso\ZendDbSqlMapperFactory',
            'Mappers\Service\Recurso\RecursoService' => 'Mappers\Factory\Recurso\RecursoServiceFactory',
            // Tabla Rol 
            'Mappers\Mapper\Rol\ZendDbSqlMapper' => 'Mappers\Factory\Rol\ZendDbSqlMapperFactory',
            'Mappers\Service\Rol\RolService' => 'Mappers\Factory\Rol\RolServiceFactory',
            // Tabla RolJerarquia 
            'Mappers\Mapper\RolJerarquia\ZendDbSqlMapper' => 'Mappers\Factory\RolJerarquia\ZendDbSqlMapperFactory',
            'Mappers\Service\RolJerarquia\RolJerarquiaService' => 'Mappers\Factory\RolJerarquia\RolJerarquiaServiceFactory',
            // Tabla Usuario 
            'Mappers\Mapper\Usuario\ZendDbSqlMapper' => 'Mappers\Factory\Usuario\ZendDbSqlMapperFactory',
            'Mappers\Service\Usuario\UsuarioService' => 'Mappers\Factory\Usuario\UsuarioServiceFactory',
            // Adaptador
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        )
    )
);
