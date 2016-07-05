<?php
/**
 * File for Acl Class
 *
 * @category  User
 * @package   User_Acl
 * @author    Marco Neumann <webcoder_at_binware_dot_org>
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 * http://p0l0.binware.org/index.php/2012/02/18/zend-framework-2-authentication-acl-using-eventmanager/
 */
/**
 * @namespace
 */
namespace Authorization\Acl;
// namespace User\Acl;
/**
 * @uses Zend\Acl\Acl
 * @uses Zend\Acl\Role\GenericRole
 * @uses Zend\Acl\Resource\GenericResource
 */
use Zend\Permissions\Acl\Acl as ZendAcl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;
// use Zend\Acl\Acl as ZendAcl,
//    Zend\Acl\Role\GenericRole as Role,
//    Zend\Acl\Resource\GenericResource as Resource;
/**
 * Class to handle Acl
 *
 * This class is for loading ACL defined in a config
 *
 * @category User
 * @package  User_Acl
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
class Acl extends ZendAcl {
    /**
     * Default Role
     */
    const DEFAULT_ROLE = 'invitado';
    const ALLOW = 1;
    const DENY  = 0;
    /**
     * Constructor
     *
     * @param $entityManager Inject Doctrine's entity manager to load ACL from Database
     * @return void
     */
    public function __construct($entityManager)
    {
        $rolMapper = $entityManager->get('Mappers\Service\Rol\RolService');
        $roles = $rolMapper->getRolesHabilitados();
        
        $recursoMapper = $entityManager->get('Mappers\Service\Recurso\RecursoService');
        $recursos = $recursoMapper->findAll();
                
        $privileges = $entityManager->get('Mappers\Service\Privilegio\PrivilegioService')->getAllPrivilegios();
        
        $this->_addRoles($roles,$rolMapper)
             ->_addAclRules($recursos, $privileges);
    }

    /**
     * Adds Roles to ACL
     *
     * @param array $roles
     * @return CsnAuthorization\Acl\AclDb
     */
    protected function _addRoles($roles,$rolMapper)
    {
        foreach($roles as $role) {
            
            if (!$this->hasRole($role->getNombre())) {
                $parents = $rolMapper->getRolPadres($role);
                $parentNames = array();
                foreach($parents as $parent) {
                    
                    $parentNames[] = $parent->getNombre();
                }
                $this->addRole(new Role($role->getNombre()), $parentNames);
                
                
            }
        }
        return $this;
    }
    /**
     * Adds Resources/privileges to ACL
     *
     * @param $resources
     * @param $privileges
     * @return User\Acl
     * @throws \Exception
     */
    protected function _addAclRules($resources, $privileges)
    {
        foreach ($resources as $resource) {
            if (!$this->hasResource($resource->getController())) {
                $this->addResource(new Resource($resource->getController()));
            }
        }
        foreach ($privileges as $privilege) {
            if($privilege["estado"] == self::ALLOW) {
                $this->allow($privilege["nombreRol"], $privilege["nombreController"], $privilege["nombreAction"]);
            } 
            if($privilege["estado"] == self::DENY) {
                $this->deny($privilege["nombreRol"], $privilege["nombreController"], $privilege["nombreAction"]);
            }
        }
        return $this;
    }
}


/**
<?php

return array(
    'service_manager' => array(
        'factories' => array(
            // Tabla Componentes 
            'Mappers\Mapper\Componentes\ZendDbSqlMapper' => 'Mappers\Factory\Componentes\ZendDbSqlMapperFactory',
            'Mappers\Service\Componentes\ComponentesService' => 'Mappers\Factory\Componentes\ComponentesServiceFactory',
            // Tabla Empresa 
            'Mappers\Mapper\Empresa\ZendDbSqlMapper' => 'Mappers\Factory\Empresa\ZendDbSqlMapperFactory',
            'Mappers\Service\Empresa\EmpresaService' => 'Mappers\Factory\Empresa\EmpresaServiceFactory',
            // Tabla Privilegio 
            'Mappers\Mapper\Privilegio\ZendDbSqlMapper' => 'Mappers\Factory\Privilegio\ZendDbSqlMapperFactory',
            'Mappers\Service\Privilegio\PrivilegioService' => 'Mappers\Factory\Privilegio\PrivilegioServiceFactory',
            // Tabla Recurso 
            'Mappers\Mapper\Recurso\ZendDbSqlMapper' => 'Mappers\Factory\Recurso\ZendDbSqlMapperFactory',
            'Mappers\Service\Recurso\RecursoService' => 'Mappers\Factory\Recurso\RecursoServiceFactory',
            // Tabla Rol 
            'Mappers\Mapper\Rol\ZendDbSqlMapper' => 'Mappers\Factory\Rol\ZendDbSqlMapperFactory',
            'Mappers\Service\Rol\RolService' => 'Mappers\Factory\Rol\RolServiceFactory',
            // Tabla Rol 
            'Mappers\Mapper\Usuario\ZendDbSqlMapper' => 'Mappers\Factory\Usuario\ZendDbSqlMapperFactory',
            'Mappers\Service\Usuario\UsuarioService' => 'Mappers\Factory\Usuario\UsuarioServiceFactory',
// Adaptador
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        )
    )
);
**/