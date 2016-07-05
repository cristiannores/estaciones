<?php
namespace Estaciones\Factory;

use Estaciones\Controller\MenuController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MenuControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        $servicios = $serviceLocator->getServiceLocator();
        //Mappers
        $renderer = $servicios->get('Zend\View\Renderer\PhpRenderer');
        $renderer->inlineScript()->prependFile('/js/modulos/Estaciones/estaciones.js');
        return new MenuController();        
        
    }
    
}