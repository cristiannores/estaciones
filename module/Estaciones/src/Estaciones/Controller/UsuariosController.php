<?php

namespace Estaciones\Controller;

use Mappers\Service\Rol\RolService;
use Mappers\Service\Usuario\UsuarioService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UsuariosController extends AbstractActionController
{

    protected $usuarioService = null;

    protected $rolService = null;
    
    
    public function __construct(UsuarioService $usuarioService, RolService $rolService)
    {
        $this->usuarioService = $usuarioService;
        $this->rolService = $rolService;
    }

    public function indexAction()
    {    
        $usuario = $this->usuarioService->listarUsuarios();
        return new ViewModel(array("usuario" => $usuario));
    }
    
    
  
     

}

