<?php

namespace Generador;

return array(
    'router' => array(
        'routes' => array(
            'generador' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/generador/[:controller[/:action]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Generador\Controller',
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
            'Generador\Controller\Index' => 'Generador\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
