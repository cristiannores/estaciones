<?php

namespace Authorization\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RolesController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

