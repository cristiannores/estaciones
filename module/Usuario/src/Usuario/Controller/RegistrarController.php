<?php

namespace Usuario\Controller;

use DateInterval;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Mappers\Model\Rol\Rol;
use Mappers\Model\Usuario\Usuario;
use Mappers\Service\Rol\RolService;
use Mappers\Service\Usuario\UsuarioService;
use Exception;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use DateTime;

class RegistrarController extends AbstractActionController
{

    const FACEBOOK = 1;

    const GMAIL = 2;

    protected $usuarioService = null;

    protected $rolService = null;

    public function __construct(UsuarioService $usuarioService, RolService $rolService)
    {
        $this->usuarioService = $usuarioService;
                $this->rolService = $rolService;
    }

    public function indexAction()
    {   if ($this->getRequest()->isXmlHttpRequest()) {
            $viewModel = new ViewModel();
            $viewModel->setTerminal(true);
//            $viewModel->setVariables(array("urlFacebook" => $this->urlBotonFacebookRegistro()));
//            Debug::dump($_SESSION);
            return $viewModel;
        }
        return new ViewModel();
    }

    /**
     * Registro manual de usuarios
     */
    public function manualAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {

                    $viewModel = new ViewModel();
                    $viewModel->setTerminal(true);

                    $jsonModel = new JsonModel();

                    $userForm = $this->params()->fromPost();

                    try {
                        $userRes = $this->usuarioService->find($userForm["email"]);
                        if ($userRes instanceof Usuario) {
                            $jsonModel->setVariables(array("codigo" => "0", "mensaje" => "Usuario ya existe"));
                            return $jsonModel;
                        } else {
                            $fecha = new DateTime("now");
                            
                            $userModel = new Usuario();
                            $userModel->setCorreo($userForm["email"]);
                            $userModel->setPassword(md5(md5(md5($userForm["password"]))));
                            $userModel->setRol_id(Rol::USUARIO);
                            $userModel->setNombres($userForm["nombre"]);
                            $userModel->setAp_pat($userForm["apellido"]);
                            $userModel->setFecha_registro($fecha->format('Y-m-d H:i:s'));
                            $userModel->setHabilita_correo(1);

                            $this->usuarioService->insert($userModel);
                            @session_destroy();
                            $session = new Container();
                            $session->offsetSet("correo", $userForm["email"]);
                            $session->offsetSet("verificar", 0);
                            //guardamos en sesion para verificar el correo 
                            $jsonModel->setVariables(array("codigo" => "1", "mensaje" => "Se ha creado su cuenta correctamente"));
                            return $jsonModel;
                        }
                    } catch (Exception $ex) {
                        $jsonModel->setVariables(array("codigo" => "0", "mensaje" => "Ocurrio un error intentelo mas tarde"));
                        return $jsonModel;
                    }
                    $jsonModel->setVariables(array("codigo" => "0", "mensaje" => "Ocurrio un error intentelo mas tarde, contacte al administrador"));
                    return $jsonModel;
                } else {

                    $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "index"));
                }
    }

    /**
     * Método que da el mensaje al usuario de la verificacion que se puede hacer
     * mediante
     * facebook gmail o el correo que se le envia.
     * @return ViewModel
     */
    public function verificaUserAction()
    {
        $viewModel = new ViewModel();
        $request = $this->getRequest()->getMethod();
        $session = new Container();
        
        if ($this->getRequest()->isPost()) {

            $viewModel->setVariables(array(
                "nombre" => $this->params()->fromPost("v_nombre"),
                "apellido" => $this->params()->fromPost("v_apellido"),
                "correo" => $this->params()->fromPost("v_correo"),
            ));
            $viewModel->setVariables(array("facebookUrl" => $this->urlBotonFacebook()));
            return $viewModel;
            
        }else if ($session->offsetExists("UserVerificado")){
            
        }else{
            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "index"));
        }
    }

    /**
     * Método que realiza la verificacion de usuario a traves de facebook si ocurre
     * algun error
     * redirecciona al inicio de registro
     * @return ViewModel
     */
    public function verificaUserFacebookAction()
    {
        session_start();
                
                $session = new Container();
                $Scorreo = $session->offsetGet("correo");
                $Sverificar = $session->offsetGet("verificar");
                
                $config = $this->getServiceLocator()->get("Config");
                $facebookCredentials = $config["facebook-credentials"];
                $fb = new Facebook($facebookCredentials);
                $helper = $fb->getRedirectLoginHelper();

                try {
                    $accessToken = $helper->getAccessToken();
                } catch (FacebookResponseException $e) {
                    // When Graph returns an error
                    return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
                } catch (FacebookSDKException $e) {
                    // When validation fails or other local issues
                    return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
                }
                
                $_SESSION['fb_access_token'] = (string) $accessToken;

                try {
                    // Returns a `Facebook\FacebookResponse` object
                    $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
                  } catch(FacebookResponseException $e){
                      Debug::dump($e); 
                      Debug::dump("llega acaasdasdass"); exit;
                    return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
                  } catch(Facebook\Exceptions\FacebookSDKException $e) {
                       Debug::dump($e);
                       Debug::dump("llega acaasdasdas"); exit;
                    return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
                  }
                  $user = $response->getGraphUser();
                  if($Sverificar == 0){
                    if($user["email"] == $Scorreo){
                        //Realizar update a la verificacion y login 
                        if($this->verificarUsuario($user["email"], self::FACEBOOK, $user["id"])){
                            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "usuario-verificado"));
                        }else{
                            
                            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"),[],true);
                        }  
                    }else{
                        //La cuenta de facebook no es la misma.
                    }
                  }else{
                      Debug::dump("llega aca" );exit;
                      return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "index"));
                  }
                return new ViewModel();
    }

    /**
     * Retorna la url de facebook en base a los parametros de la credenciales del
     * config.
     * @return url
     * @author Cristian Nores
     */
    public function urlBotonFacebook()
    {
        session_start();
        $config = $this->getServiceLocator()->get("Config");
        $facebookCredentials = $config["facebook-credentials"];
        $fb = new Facebook($facebookCredentials);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['public_profile', 'user_likes','user_friends'];
        $rutaFacebook = $this->url()->fromRoute("usuario", array("controller" => "registrar","action" => "verificaUserFacebook"));
        $loginUrl = $helper->getLoginUrl($config['basePath'].'/usuario/registrar/verifica-user-facebook', $permissions);

        return $loginUrl;
    }
    /**
     * Retorna la url de facebook en base a los parametros de la credenciales del
     * config.
     * @return url
     * @author Cristian Nores
     */
    private function urlBotonFacebookRegistro()
    {
        session_start();
        $config = $this->getServiceLocator()->get("Config");
        $facebookCredentials = $config["facebook-credentials"];
        $fb = new Facebook($facebookCredentials);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['public_profile'];
        $loginUrl = $helper->getLoginUrl($config['basePath'].'/usuario/registrar/registra-user-facebook', $permissions);

        return $loginUrl;
    }

    /**
     * Confirma la verificaciond el usuario
     */
    private function verificarUsuario($correo, $tipo, $id = null)
    {
        if(!empty($correo)){
            if($tipo == self::FACEBOOK){
                $fecha = new DateTime("now");
                $fecha->add(new DateInterval('P5Y'));
                $usuario = new Usuario();
                $usuario->setCorreo($correo);
                $usuario->setVerifica_facebook(1);
                $usuario->setId_facebook($id);
                $usuario->setEmail_confirmado(1);
                $usuario->setHabilitado(1);
                $usuario->setFecha_expiracion($fecha->format('Y-m-d H:i:s'));

                if($this->usuarioService->verificarUsuarioFacebook($usuario))
                {

                    $usuarioCreado = $this->usuarioService->find($correo);

                    if($usuarioCreado instanceof Usuario){
                        $session = new Container();
                        $session->offsetSet("UserVerificado", 1);    
                        $session->offsetSet("nombre", $usuarioCreado->getNombres());
                        $session->offsetSet("apellido", $usuarioCreado->getAp_pat());
                    }



                    return true;
                }else{
                    return false;                    
                }
            }else if($tipo == self::GMAIL){

            }else{
                return false;
            } 
        }else{
            return false;
        }
    }

    public function usuarioVerificadoAction()
    {
        $session = new Container();
        $viewModel = new ViewModel();
        if($session->offsetExists("UserVerificado")){
            if($session->offsetGet("UserVerificado") == 1){
                $viewModel->setVariables(array(
                    "correo" => $session->offsetGet("correo"),
                    "nombre" => $session->offsetGet("nombre"),
                    "apellido" => $session->offsetGet("apellido")                      
                ));                
                return $viewModel;
            }
        }else{
            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "index"));
        }
        
        
    }
    
    public function registraUserFacebookAction(){
        @session_start();
        $config = $this->getServiceLocator()->get("Config");
        $facebookCredentials = $config["facebook-credentials"];
        $fb = new Facebook($facebookCredentials);
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
          } catch(FacebookResponseException $e){
              Debug::dump($e); 
              Debug::dump("llega acaasdasdass"); exit;
            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
               Debug::dump($e);
               Debug::dump("llega acaasdasdas"); exit;
            return $this->redirect()->toRoute("usuario", array("controller" => "registrar", "action" => "verifica-user"));
          }
          $user = $response->getGraphUser();
          
          $usuario = $this->usuarioService->find($user["email"]);
          
          if($usuario instanceof Usuario){
              Debug::dump($usuario);
              Debug::dump("Usuario ya existe");
          }else{
              Debug::dump($user);
              Debug::dump("Se creara el usuario");
          }
        return new ViewModel();
    }


}

