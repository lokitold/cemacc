<?php

class Default_RecuperarPasswordController extends Core_Controller_Default {

    public function init() {
        parent::init();
        $this->view->headTitle('Recuperar Contraseña');
        $this->_helper->layout->setLayout('layout_login');
    }

    public function indexAction() {
        $form = new Application_Form_EnviarEmailContrasenaForm();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->_getAllParams())) {
                $usuario = new Application_Entity_Usuario();
                if ($usuario->enviarEmailRecuperarContrasena($form->getValue('email'))){
                    $this->getMessenger()->success('Se ha enviado un correo electrónico con sus nuevas credenciales');
                    $this->_redirect('/recuperar-password');
                }
                else {
                    $this->getMessenger()->error($usuario->getMessage());
                    $this->_redirect('/recuperar-password');
                }
            }
        }
        $this->view->form = $form;
    }
}

