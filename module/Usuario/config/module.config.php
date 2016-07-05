<?php

return array(
    'router' => array(
        'routes' => array(
            'usuario' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/usuario/[:controller[/:action]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Usuario\Controller',
                        'controller' => 'Index',
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
//            'Usuario\Controller\Index' => 'Usuario\Controller\IndexController',
//            'Usuario\Controller\Registrar' => 'Usuario\Controller\RegistrarController',
        ),
        'factories' => array(
            'Usuario\Controller\Index' => 'Usuario\Factory\IndexControllerFactory',
            'Usuario\Controller\Registrar' => 'Usuario\Factory\RegistrarControllerFactory',
            'Usuario\Controller\Login' => 'Usuario\Factory\LoginControllerFactory',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
