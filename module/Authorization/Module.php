<?php

namespace Authorization;

// for Acl


use Authorization\Acl\Acl;
use Exception;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    // FOR Authorization
    public function onBootstrap(MvcEvent $e) { // use it to attach event listeners
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $em = $application->getEventManager();
        $config = $sm->get('Config');
        if($config["enableAcl"]){
            $em->attach('route', array($this, 'onRoute'), -100);
        }
    }

    // WORKING the main engine for ACL
    public function onRoute(MvcEvent $e) { // Event manager of the app

        $application = $e->getApplication();
        $routeMatch = $e->getRouteMatch();
        $sm = $application->getServiceManager();
        $auth = new AuthenticationService();
        $config = $sm->get('Config');
        $acl = new Acl($sm);
        // everyone is guest untill it gets logged in
        // everyone is guest until logging in
        $role = Acl::DEFAULT_ROLE; // The default role is guest $acl
        if ($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            $role = $user["roles"]->getNombre();
        }

        $controller = $routeMatch->getParam('controller');
        $action = $routeMatch->getParam('action');
        
        
        if($controller != "ZFTool\Controller\Create")
        {
            if (!$acl->hasResource($controller)) {
            throw new \Exception('Resource ' . $controller . ' not defined');
            }
            if (!$acl->isAllowed($role, $controller, $action)) {
                $response = $e->getResponse();
                $config = $sm->get('config');
                if (!empty($redirect_route)) {
                    $url = $e->getRouter()->assemble(array(), array("usuario"));
                    $response->getHeaders()->addHeaderLine('Location', $url);
                    // The HTTP response status code 302 Found is a common way of performing a redirection.
                    // http://en.wikipedia.org/wiki/HTTP_302
                    $response->setStatusCode(302);
                    $response->sendHeaders();
                    exit;
                } else {
                    //Status code 403 responses are the result of the web server being configured to deny access,
                    //for some reason, to the requested resource by the client.
                    //http://en.wikipedia.org/wiki/HTTP_403
                    $url = $e->getRouter()->assemble(array(), array("name" => "usuario"));
                    $response->getHeaders()->addHeaderLine('Location', $url);
                    // The HTTP response status code 302 Found is a common way of performing a redirection.
                    // http://en.wikipedia.org/wiki/HTTP_302
                    $response->setStatusCode(403);
                    $response->sendHeaders();
                    exit;
                }
            }
            
        }
        
        
    }

}
