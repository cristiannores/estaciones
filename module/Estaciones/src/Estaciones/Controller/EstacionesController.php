<?php

namespace Estaciones\Controller;

use Mappers\Service\Rol\RolService;
use Mappers\Service\Usuario\UsuarioService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EstacionesController extends AbstractActionController
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
        return new ViewModel();
    }
    
    public function agregarEstacionAction(){
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    
    public function habilitarEstacionAction(){
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function EditarEstacionAction(){
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    
  
     

}

