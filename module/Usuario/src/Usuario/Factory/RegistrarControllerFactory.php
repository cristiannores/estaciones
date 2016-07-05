<?php
namespace Usuario\Factory;

use Usuario\Controller\RegistrarController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegistrarControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        $servicio = $serviceLocator->getServiceLocator("");
         //Mappers
        $usuarioMapper = $servicio->get("Mappers\Service\Usuario\UsuarioService");
        $rolMapper = $servicio->get("Mappers\Service\Rol\RolService");
        
        
        $renderer = $servicio->get('Zend\View\Renderer\PhpRenderer');
        $renderer->inlineScript()->prependFile('/js/modulos/Usuario/registrar.js');
        
        return new RegistrarController($usuarioMapper,$rolMapper);        
        
    }
}