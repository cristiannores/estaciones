<?php

namespace Estaciones\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DescargasController extends AbstractActionController
{


    public function __construct()
    {
    }

    public function indexAction()
    {    
        
        return new ViewModel();
    }
    
    
  
     

}

