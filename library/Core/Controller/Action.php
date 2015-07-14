<?php

class Core_Controller_Action extends Zend_Controller_Action {

    /**
     *
     * @var Zend_Form_Element_Hash
     */
    protected $_hash = null;
    protected $_identity = null;
    protected $paramsConsole = null;
    /**
     *
     * @var App_Controller_Action_Helper_FlashMessengerCustom
     */
    protected $_flashMessenger;
    protected $_objectUser;
    protected $_acl;
    protected $_controller;
    protected $_module;
    protected $_action;

    public function init() {
        $this->view->headTitle('CEMACC');
        $this->view->headTitle()->setSeparator(' - ');
        $this->_flashMessenger = new Core_Controller_Action_Helper_FlashMessengerCustom();
        parent::init();
        $this->view->flagShowError = true;
        $this->view->moduleName = $this->getRequest()->getModuleName();
        $this->session = new Zend_Session_Namespace('sessionGeneral');
        $this->_identity = Zend_Auth::getInstance()->getIdentity();
        $this->view->identity = $this->_identity;
        $this->_controlador = $this->getRequest()->getControllerName();
        $this->_modulo = $this->getRequest()->getModuleName();
        $this->_action = $this->getRequest()->getActionName();
        
        $dir=$this->view->moduleName.$this->_controlador.$this->_action;
        switch ($dir) {
            case 'defaultindexindex':
                $this->view->classMenu1 = 'active';
                break;
            case 'defaultcentro-empresarialindex':
                $this->view->classMenu2 = 'active';
                break;
            case 'defaultcentro-formacionindex':
                $this->view->classMenu3 = 'active';
                break;
            case 'defaultcentro-formacioncapacitacion':
                $this->view->classMenu3 = 'active';
                break;
            case 'defaultdirectorioindex':
                $this->view->classMenu4 = 'active';
                break;
            case 'defaultboletinindex':
                $this->view->classMenu5 = 'active';
                break;
            case 'defaultcontactoindex':
                $this->view->classMenu6 = 'active';
                break;

        }
        $data = array();
        if (empty($this->_identity)) {
            $rol = 'Public';
            $data[] = $rol;
            if ((!($this->_controlador == 'login' || $this->_controlador == 'registro' 
                    || $this->_controlador == 'index' || $this->_controlador == 'centro-empresarial'
                    || $this->_controlador == 'centro-formacion' || $this->_controlador == 'directorio' || $this->_controlador == 'contacto'))  && $this->_modulo == 'default' && $this->_action == 'index' &&
                    !($this->_controlador == 'boletin' )) {
                $this->redirect('/login');
            }
        }else{
        $dataRoles = explode('|',$this->_identity->roles);
        foreach ($dataRoles as $roles){
            $datos = explode(',',$roles);
            $data[] = $datos[1];
        }
            if(count($data) == 1){
            $data[0] = $this->_identity->role_nombre;
            }
        }
        
        $navigation = new Zend_Navigation($this->getNavigation());
        $this->view->navigation($navigation);
        $acl = new Zend_Acl();
        $roles = Application_Entity_Usuario::getRoles();
        foreach($roles as $index){
            if($index['extend']==''){
                $acl->addRole(new Zend_Acl_Role($index['role']));
            }else{
                $acl->addRole(new Zend_Acl_Role($index['role']),$index['extend']);
            }
        }
        $resources = Application_Entity_Usuario::getResources();
        foreach ($resources as $index){
            $acl->add(new Zend_Acl_Resource($index['resource_nombre']));
        }
        $permissions = Application_Entity_Usuario::getPermissions();
        foreach ($permissions as $index){
            $acl->allow($index['role'], $index['resource']);
        }
        $count = count($data);
        $times = 0;
        foreach ($data as $index=>$rol){
            //echo $val; exit();
        $this->view->navigation()->setAcl($acl)->setRole($rol);
        $this->view->acl = $this->_acl = $acl;
        try {
            if(!$acl->isAllowed($rol, $this->_modulo.'-'.$this->_controlador.'-'.$this->_action)) {
                if($count == $times){
                $this->getMessenger()->error('No tiene Permisos Asignados para esta Opción');
                $module_active  = Application_Entity_Usuario::getModuleByUsuario($this->_identity->usuario_identity);
                //echo  $this->_identity->usuario_id; exit();
                $this->redirect(BASE_URL.'/'.$module_active['module']);
                // echo 'No tiene Permisos Asignados para esta Opción';
                }
                $count++;
            }else{
                //echo $rol.'-'.$this->_modulo.$this->_controlador.$this->_action;
                break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
//            if (!empty($this->_identity)) {
//                $auth = Zend_Auth::getInstance();
//                $auth->clearIdentity();
//                $this->redirect('/login');
//            }
        }
        }
    }

    public function selectNaviation($uri) {
        $activeNav = $this->view->navigation()->findByUri($uri);
        $activeNav->active = true;
    }
    
    /**
     * Pre-dispatch routines
     * Asignar variables de entorno
     *
     * @return void
     */
    public function preDispatch() {
        parent::preDispatch();
    }

    /**
     * Post-dispatch routines
     * Asignar variables de entorno
     *
     * @return void
     */
    public function postDispatch() {
        parent::postDispatch();
        //$this->timePerformance();
    }
    
    public function timePerformance(){
        $writer = new Zend_Log_Writer_Firebug();
        $logger = new Zend_Log($writer);
        $end  = microtime(true);
        $microsegundos =$end-MICROTIME_START;
        $logger->log('Tiempo de respuesta Final '.$microsegundos, Zend_Log::INFO);
    }

    /**
     * Retorna la instancia personalizada de FlashMessenger
     * Forma de uso:
     * $this->getMessenger()->info('Mensaje de información');
     * $this->getMessenger()->success('Mensaje de información');
     * $this->getMessenger()->error('Mensaje de información');
     *
     * @return App_Controller_Action_Helper_FlashMessengerCustom
     */
    public function getMessenger() {
        return $this->_flashMessenger;
    }

    /**
     *
     * @see Zend/Controller/Zend_Controller_Action::getRequest()
     * @return Zend_Controller_Request_Http
     */
    public function getRequest() {
        return parent::getRequest();
    }

    /**
     * Retorna un objeto Zend_Config con los parámetros de la aplicación
     *
     * @return Zend_Config
     */
    public function getConfig() {
        return Zend_Registry::get('config');
    }

    /**
     * Retorna el objeto cache de la aplicación
     *
     * @return Zend_Cache_Core
     */
    public function getCache() {
        return Zend_Registry::get('cache');
    }

    /**
     * Retorna el objeto Zend_Log de la aplicación
     *
     * @return Zend_Log
     */
    public function getLog() {
        return Zend_Registry::get('log');
    }

    public function __call($methodName, $args) {
        //  $this->_forward('error404');
    }
    
    public function getNavigation() {
        return Application_Entity_Resource::getNavigation();
    }

}