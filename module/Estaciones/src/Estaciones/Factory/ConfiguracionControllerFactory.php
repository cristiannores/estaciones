<?php
namespace Estaciones\Factory;

use Estaciones\Controller\ConfiguracionController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConfiguracionControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        $servicios = $serviceLocator->getServiceLocator();
        //Mappers
        $renderer = $servicios->get('Zend\View\Renderer\PhpRenderer');
        $renderer->inlineScript()->prependFile('/js/modulos/Estaciones/configuracion.js');
        return new ConfiguracionController();        
        
    }
    
}