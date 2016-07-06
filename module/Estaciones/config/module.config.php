<?php

return array(
    'router' => array(
        'routes' => array(
            'estaciones' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/estaciones/[:controller[/:action]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Estaciones\Controller',
                        'controller' => 'Menu',
                        'action' => 'index',
                    ),
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
//            'Estaciones\Controller\Index' => 'Estaciones\Controller\IndexController',
//            'Estaciones\Controller\Registrar' => 'Estaciones\Controller\RegistrarController',
        ),
        'factories' => array(
            'Estaciones\Controller\Menu' => 'Estaciones\Factory\MenuControllerFactory',
            'Estaciones\Controller\Descargas' => 'Estaciones\Factory\DescargasControllerFactory',
            'Estaciones\Controller\Usuarios' => 'Estaciones\Factory\UsuariosControllerFactory',
            'Estaciones\Controller\Estaciones' => 'Estaciones\Factory\EstacionesControllerFactory',
            'Estaciones\Controller\Configuracion' => 'Estaciones\Factory\ConfiguracionControllerFactory',
        ),
    ),
     'service_manager' => array(
        'aliases' => array(
            'Zend\Authentication\AuthenticationService' => 'my_auth_service',
        ),
        'invokables' => array(
            'my_auth_service' => 'Zend\Authentication\AuthenticationService',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'estaciones/layout' => __DIR__ . '/../view/layout/editor.phtml',
        ),
    ),
);
