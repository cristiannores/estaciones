<?php

namespace Usuario\Controller;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Mappers\Model\Usuario\Usuario;
use Mappers\Service\Usuario\UsuarioService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController {

    protected  $usuarioservice;
            
    public function __construct(UsuarioService $usuario) {
        $this->usuarioservice = $usuario;
    }
    
    public function indexAction() {
//        $url = $this->urlBotonFacebookLogin();
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
//        $viewModel->setVariable("urlFacebookLogin", $url);
        return $viewModel;
    }

    public function ManualAction() {

        $usuario = $this->params()->fromPost("email");
        $pass = $this->params()->fromPost("password");
        $remember = $this->params()->fromPost("recuerdame");
        
       
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        

        $authAdapter = new AuthAdapter(
                $dbAdapter, "usuario", "correo", "password",'MD5(MD5(MD5(?))) AND habilitado = 1'
        );
        $authAdapter->setIdentity($usuario);
        $authAdapter->setCredential($pass);

        $auth = new AuthenticationService();
        $result = $auth->authenticate($authAdapter);


        $view = new ViewModel();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $view->setTerminal(true);
        }
         $jsonModel = new JsonModel();
                $jsonModel->setVariables(array("code" => -1, "message" => "Usuario ss"));
                return $jsonModel;
        
        switch ($result->getCode()) {
            case Result::FAILURE_IDENTITY_NOT_FOUND:
                $jsonModel = new JsonModel();
                $jsonModel->setVariables(array("code" => -1, "message" => "Usuario inválido"));
                return $jsonModel;
                break;
            case Result::FAILURE:
                $jsonModel = new JsonModel();
                $jsonModel->setVariables(array("code" => 0, "message" => "Usuario inválido"));
                return $jsonModel;
                break;
            case Result::FAILURE_IDENTITY_AMBIGUOUS:
                $jsonModel = new JsonModel();
                $jsonModel->setVariables(array("code" => -2, "message" => "Usuario inválido"));
                return $jsonModel;
                break;
            case Result::FAILURE_CREDENTIAL_INVALID:
                $jsonModel = new JsonModel();
                $jsonModel->setVariables(array("code" => -3, "message" => "Usuario inválido"));
                return $jsonModel;
                break;
            case Result::SUCCESS:
                $storage = $auth->getStorage();
                $user = $authAdapter->getResultRowObject(
                        null, "password"
                );
                $storage->write($user);

                $rolMapper = $sm->get('Mappers\Service\Rol\RolService');
                $rolObject = $rolMapper->find($user->rol_id);

                $storage->write(array("roles" => $rolObject, "user" => $user));


                $time = 1209600;
                if ($remember) {
                    $sessionManager = new SessionManager();
                    $sessionManager->rememberMe($time);
                }

                $jsonModel = new JsonModel();
                $jsonModel->setVariables(array("code" => 1, "message" => "Usuario encontrado"));
                return $jsonModel;
                break;
            default:
                $jsonModel = new JsonModel();
                $jsonModel->setVariables(array("code" => -4, "message" => "Falla desconocida"));
                return $jsonModel;
                break;

                $jsonModel = new JsonModel();
                $jsonModel->setVariables(array("hola" => "hola"));
                return $jsonModel;
        }
    }
    
    
    
    public function logoutAction(){
        @session_start();

        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
        }

        $auth->clearIdentity();

        $sessionManager = new SessionManager();
        $sessionManager->forgetMe();

        return $this->redirect()->toRoute("home", array("controller" => "index", "action" => "index"));
    }
    
    
    public function loginUserFacebookAction(){
        
        if (!session_id()) {
            session_start();
        }        
        $config = $this->getServiceLocator()->get("Config");
        $facebookCredentials = $config["facebook-credentials"];
        $fb = new Facebook($facebookCredentials);
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            Debug::dump($e->getMessage());exit;
            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            Debug::dump($e->getMessage());exit;
            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
          } catch(FacebookResponseException $e){
             Debug::dump($e->getMessage());exit;
            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
               Debug::dump($e->getMessage());exit;
            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
          }
          $user = $response->getGraphUser();
          
          $this->loginRedSocial($user["email"]);
          
    }
    
    


    /**
     * Retorna la url de facebook en base a los parametros de la credenciales del
     * config.
     * @return url
     * @author Cristian Nores
     */
    private function urlBotonFacebookLogin()
    {
        if (!session_id()) {
            session_start();
        }
        
        
        $config = $this->getServiceLocator()->get("Config");
        $facebookCredentials = $config["facebook-credentials"];
        $fb = new Facebook($facebookCredentials);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['public_profile'];
        $loginUrl = $helper->getLoginUrl($config['basePath'].'/usuario/login/login-user-facebook', $permissions);

        return $loginUrl;
    }
    
    
    private function loginRedSocial($email){
        
         
        $usuario = $this->usuarioservice->find($email);
        
        if($usuario != null){
            if($usuario instanceof Usuario)
            {
                $sm = $this->getServiceLocator();
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                
                $authAdapter = new AuthAdapter(
                        $dbAdapter, "usuario", "correo", "password",'MD5(MD5(MD5(?)))'
                );

                $authAdapter->setIdentity($usuario->getCorreo());
                if($usuario->getPassword() == null){
                    $authAdapter->setCredential("");
                }else{
                    $authAdapter->setCredential($usuario->getPassword());
                }

                $auth = new AuthenticationService();

                $storage = $auth->getStorage();
                $user = $authAdapter->getResultRowObject(
                        null, "password"
                );
                $storage->write($user);

                $rolMapper = $sm->get('Mappers\Service\Rol\RolService');
                $rolObject = $rolMapper->find($usuario->getRol_id());

                $storage->write(array("roles" => $rolObject, "user" => $user));


                $time = 1209600;
                if ($remember) {
                    $sessionManager = new SessionManager();
                    $sessionManager->rememberMe($time);
                }
                
                return $this->redirect()->toRoute("usuario", array("controller" => "index", "action" => "perfil-usuario"));
                
            }
            
        }else{
            return $this->redirect()->toRoute("usuario", array("controller" => "index", "action" => "index"));
        }
        
        
        
    }
    
}
