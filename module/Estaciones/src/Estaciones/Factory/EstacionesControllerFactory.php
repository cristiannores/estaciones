<?php
namespace Estaciones\Factory;

use Estaciones\Controller\EstacionesController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EstacionesControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        $servicios = $serviceLocator->getServiceLocator();
        //Mappers
        $renderer = $servicios->get('Zend\View\Renderer\PhpRenderer');
        $renderer->inlineScript()->prependFile('/js/modulos/Estaciones/estaciones-adm.js');
        
          //Mappers
        $usuarioMapper = $servicios->get("Mappers\Service\Usuario\UsuarioService");
        $rolMapper = $servicios->get("Mappers\Service\Rol\RolService");
        
        return new EstacionesController($usuarioMapper,$rolMapper);        
        
    }
    
}