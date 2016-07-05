<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Authorization\Controller\Acl' => 'Authorization\Controller\AclController',
             'Authorization\Controller\Roles' => 'Authorization\Controller\RolesController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'authorization' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/authorization[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Authorization\Controller\Acl',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'roles' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/roles[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Authorization\Controller\Roles',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'authorization' => __DIR__ . '/../view',
         ),
     ),
 );