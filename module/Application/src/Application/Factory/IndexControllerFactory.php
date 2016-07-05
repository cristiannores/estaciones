<?php

namespace Application\Factory;

use Zend\Debug\Debug;
use Application\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface {

    /**
     * Metodo que genera los servicios.
     * @param ServiceLocatorInterface $serviceLocator
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        //llamada al locator.
        $servicios = $serviceLocator->getServiceLocator();
        
        $fecha = date_format($date, 'Y.m.d.H.i.s');
        $renderer = $servicios->get('Zend\View\Renderer\PhpRenderer');
        $renderer->inlineScript()->prependFile('/js/modulos/Application/login.js?Rev='.$fecha);
        
         //Mappers
        $usuarioMapper = $servicios->get("Mappers\Service\Usuario\UsuarioService");
        $rolMapper = $servicios->get("Mappers\Service\Rol\RolService");
        
        return new IndexController($usuarioMapper,$rolMapper);     
    }

}
