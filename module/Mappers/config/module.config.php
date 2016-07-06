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
            // Tabla Dominios 
            'Mappers\Mapper\Dominios\ZendDbSqlMapper' => 'Mappers\Factory\Dominios\ZendDbSqlMapperFactory',
            'Mappers\Service\Dominios\DominiosService' => 'Mappers\Factory\Dominios\DominiosServiceFactory',
            // Tabla Estacion 
            'Mappers\Mapper\Estacion\ZendDbSqlMapper' => 'Mappers\Factory\Estacion\ZendDbSqlMapperFactory',
            'Mappers\Service\Estacion\EstacionService' => 'Mappers\Factory\Estacion\EstacionServiceFactory',
            // Tabla EstacionUsuario 
            'Mappers\Mapper\EstacionUsuario\ZendDbSqlMapper' => 'Mappers\Factory\EstacionUsuario\ZendDbSqlMapperFactory',
            'Mappers\Service\EstacionUsuario\EstacionUsuarioService' => 'Mappers\Factory\EstacionUsuario\EstacionUsuarioServiceFactory',
            // Tabla IndicadorEstacion 
            'Mappers\Mapper\IndicadorEstacion\ZendDbSqlMapper' => 'Mappers\Factory\IndicadorEstacion\ZendDbSqlMapperFactory',
            'Mappers\Service\IndicadorEstacion\IndicadorEstacionService' => 'Mappers\Factory\IndicadorEstacion\IndicadorEstacionServiceFactory',
            // Tabla Indicadores 
            'Mappers\Mapper\Indicadores\ZendDbSqlMapper' => 'Mappers\Factory\Indicadores\ZendDbSqlMapperFactory',
            'Mappers\Service\Indicadores\IndicadoresService' => 'Mappers\Factory\Indicadores\IndicadoresServiceFactory',
            // Adaptador
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        )
    )
);
