<?php
namespace Estaciones\Factory;

use Estaciones\Controller\UsuariosController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsuariosControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        $servicios = $serviceLocator->getServiceLocator();
        //Mappers
        $renderer = $servicios->get('Zend\View\Renderer\PhpRenderer');
        $renderer->inlineScript()->prependFile('/js/modulos/Estaciones/usuarios.js');
        
          //Mappers
        $usuarioMapper = $servicios->get("Mappers\Service\Usuario\UsuarioService");
        $rolMapper = $servicios->get("Mappers\Service\Rol\RolService");
        
        return new UsuariosController($usuarioMapper,$rolMapper);        
        
    }
    
}