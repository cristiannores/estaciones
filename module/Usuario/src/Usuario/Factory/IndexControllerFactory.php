<?php
namespace Usuario\Factory;

use Usuario\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        $servicios = $serviceLocator->getServiceLocator();
        
        //Mappers
        $usuarioMapper = $servicios->get("Mappers\Service\Usuario\UsuarioService");
        
        $renderer = $servicios->get('Zend\View\Renderer\PhpRenderer');
        $renderer->inlineScript()->prependFile('/js/jquery.fullPage.js');
        $renderer->inlineScript()->prependFile('/js/modulos/Usuario/index.js');
        $renderer->inlineScript()->prependFile('/js/modulos/Usuario/registrar.js');
        $renderer->inlineScript()->prependFile('/js/modulos/Usuario/login.js');
        
        $renderer->headLink()->appendStylesheet('/css/jquery.fullPage.css');
        
        
        
        
        return new IndexController($usuarioMapper);        
        
    }
    
}