<?php
namespace Usuario\Factory;

use Usuario\Controller\LoginController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        $servicio = $serviceLocator->getServiceLocator();
        //Mappers
        $usuarioMapper = $servicio->get("Mappers\Service\Usuario\UsuarioService");
        return new LoginController($usuarioMapper);        
        
    }
}