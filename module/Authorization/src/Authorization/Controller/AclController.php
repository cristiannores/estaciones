<?php

namespace Authorization\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AclController extends AbstractActionController
{

    public function indexAction()
    {
        
       $auth = new AuthenticationService();
       
       if($auth->hasIdentity()){
           return $this->redirect()->toRoute("roles",array("controller" => "roles","action" => "index"));
       }else{
           return $this->redirect()->toRoute("usuario",array("controller" => "index","action" => "index"));
       }
        
        
        
        
        
        
        return new ViewModel();
    }


}

