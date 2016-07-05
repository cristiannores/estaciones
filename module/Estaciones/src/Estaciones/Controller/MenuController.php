<?php

namespace Estaciones\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MenuController extends AbstractActionController
{


    public function __construct()
    {
    }

    public function indexAction()
    {    
        
        return new ViewModel();
    }
    
    public function temperaturaChartAction(){
        return new ViewModel();
    }
    
    
  
     

}

