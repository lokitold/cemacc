<?php

class Default_LoginController extends Core_Controller_Default
{
    public function init() {
        parent::init();
        $this->_helper->layout->setLayout('layout_login');
        
    }
    public function indexAction()
    {
        $params = $this->getAllParams();
        if($this->getRequest()->isPost()){
            $usuario = new Application_Entity_Usuario();
                if ($usuario->login($params['username'], $params['password'])) {
                    $attempts->number = 0;
                    if($this->session->lastUri==''){
                        $role = Application_Entity_Usuario::getModuleByUsuario($params['username']);
                        $module = strtolower($role['module']);
                        $this->_redirect(BASE_URL.'/'.$module);
                    }else{
                        $url = $this->session->lastUri;
                        unset($this->session->lastUri);
                        $this->_redirect($url);
                    }
                } else {
                    $attempts->number++;
                    $this->getMessenger()->error('Usuario No valido');
                    $this->_redirect(BASE_URL . '/login');
                }
        }
       
    }
   
    
}

