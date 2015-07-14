<?php

class Default_LogoutController extends Core_Controller_Default
{
    public function init() {
        parent::init();
        
    }
    public function indexAction()
    {
       $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect(BASE_URL);
    }
   
    
}

