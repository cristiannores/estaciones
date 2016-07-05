<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Mappers\Model\Rol\Rol;
use Mappers\Model\Usuario\Usuario;
use Mappers\Service\Rol\RolService;
use Mappers\Service\Usuario\UsuarioService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Debug\Debug;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\View\Model\JsonModel;
use DateTime;

class IndexController extends AbstractActionController
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
    
    public function crearCuentaAction()
    {
        return new ViewModel();
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
                $jsonModel->setVariables(array("code" => -3, "message" => "Usuario inválido o inhabilitado"));
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
    
    /**
     * Registro manual de usuarios
     */
    public function registroAction()
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
                            $userModel->setRol_id(1);
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
}
