<?php

namespace Usuario\Controller;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Mappers\Service\Usuario\UsuarioService;
use Usuario\Form\LoginForm;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Driver\Sqlsrv\Result;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    protected $usuarioMapper = null;

    public function __construct(UsuarioService $usuarioMapper)
    {
        $this->usuarioMapper = $usuarioMapper;
    }

    public function indexAction()
    {
//                $auth = new AuthenticationService();
//
//                if ($auth->hasIdentity()) {
//                    $identity = $auth->getIdentity();
//                    echo "logeado";
//                    var_dump($_SESSION);
//                }
//
//
//                @session_start();
//
//
//
//                $config = $this->getServiceLocator()->get("Config");
//                $facebookCredentials = $config["facebook-credentials"];
//
//                $fb = new Facebook($facebookCredentials);
//                $helper = $fb->getRedirectLoginHelper();
//                $permissions = ['email', 'user_likes'];
//                $loginUrl = $helper->getLoginUrl('http://cms.ipservice.cl/usuario/facebook-callback', $permissions);
//
//
//
//
//                $renderer = $this->getServiceLocator()->get(
//                        'Zend\View\Renderer\PhpRenderer');
//
//                $renderer->inlineScript()->prependFile('/js/modulos/Usuario/usuario.js');
//
//
//
//                $form = new LoginForm();
//
//                return array('form' => $form, "urlFacebook" => $loginUrl);
        
        
        
        return new ViewModel();
    }
     /* Retorna la url de facebook en base a los parametros de la credenciales del
     * config.
     * @return url
     * @author Cristian Nores
     */
    public function urlBotonFacebookAction()
    {
        if (!session_id()) {
            session_start();
        }
        $config = $this->getServiceLocator()->get("Config");
        $login = $config['basePath'].'/usuario/login/login-user-facebook';
        $register = $config['basePath'].'/usuario/registrar/registra-user-facebook';
        $facebookCredentials = $config["facebook-credentials"];
        $fb = new Facebook($facebookCredentials);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['public_profile'];
        $jsonModel = new JsonModel();
        if($this->params()->fromPost("accion") == "login"){
            $urlLogin = $helper->getLoginUrl($login, $permissions);
             $jsonModel->setVariable("url", $urlLogin);
        }else{
            $urlRegister = $helper->getLoginUrl($register, $permissions);
             $jsonModel->setVariable("url", $urlRegister);
         }     
         
        return  $jsonModel;
    }
    public function loginAction()
    {
        $request = $this->getRequest();

                if ($request->isPost()) {
                    $usuario = $this->params()->fromPost("user");
                    $pass = $this->params()->fromPost("pass");
                    $remember = $this->params()->fromPost("remember");

                    $sm = $this->getServiceLocator();
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');


                    $authAdapter = new AuthAdapter(
                            $dbAdapter, "usuario", "run", "password"
                    );

                    $authAdapter->setIdentity($usuario);
                    $authAdapter->setCredential($pass);

                    $auth = new AuthenticationService();
                    $result = $auth->authenticate($authAdapter);




                    $view = new ViewModel();
                    if ($this->getRequest()->isXmlHttpRequest()) {
                        $view->setTerminal(true);
                    }

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
                    }
                }
    }

    public function FacebookCallbackAction()
    {
        session_start();
                $fb = new Facebook([
                    'app_id' => '715596125250939',
                    'app_secret' => 'a2d7fedbc2196480c996e5d570b08398',
                    'default_graph_version' => 'v2.4',
                ]);
                $helper = $fb->getRedirectLoginHelper();

                try {
                    $accessToken = $helper->getAccessToken();
                } catch (FacebookResponseException $e) {
                    // When Graph returns an error
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch (FacebookSDKException $e) {
                    // When validation fails or other local issues
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }

                if (isset($accessToken)) {
                    Debug::dump($accessToken);
                    // Logged in!
                    $_SESSION['facebook_access_token'] = (string) $accessToken;

                    // Now you can redirect to another page and use the
                    // access token from $_SESSION['facebook_access_token']
                }
                return new ViewModel();
    }

    public function LogoutAction()
    {
        session_start();

                $auth = new AuthenticationService();

                if ($auth->hasIdentity()) {
                    $identity = $auth->getIdentity();
                }

                $auth->clearIdentity();

                $sessionManager = new SessionManager();
                $sessionManager->forgetMe();

                return $this->redirect()->toRoute("usuario", array("controller" => "usuario", "action" => "index"));
    }

    public function RequestFacebookAction()
    {
        session_start();
                $fb = new Facebook([
                    'app_id' => '715596125250939',
                    'app_secret' => 'a2d7fedbc2196480c996e5d570b08398',
                    'default_graph_version' => 'v2.4',
                ]);


                // Sets the default fallback access token so we don't have to pass it to each request
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

                try {
                    $response = $fb->get('/me');
                    $userNode = $response->getGraphUser();
                    Debug::dump($userNode);
                } catch (FacebookResponseException $e) {     // When Graph returns an error
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch (FacebookSDKException $e) {
                    // When validation fails or other local issues
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
                $plainOldArray = $response->getDecodedBody();
                Debug::dump($plainOldArray);

                try {
                    // Returns a `Facebook\FacebookResponse` object
                    // getHometown
                    $response = $fb->get('/me?fields=id,email,gender,link,first_name,last_name,name', $_SESSION['facebook_access_token']);
                } catch (FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch (FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
                // Get the base class GraphNode from the response
                // Get the response typed as a GraphUser
                $user = $response->getGraphUser();

                // Get the response typed as a GraphPage


                Debug::dump($user);


                return new ViewModel();
    }

    public function perfilUsuarioAction()
    {
        return new ViewModel();
    }

    public function RegistrarAction()
    {
        return new ViewModel();
    }


}

