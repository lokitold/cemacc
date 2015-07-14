<?php

class Core_Controller_Abogado extends Core_Controller_Action {

    public function init() {
        parent::init();
        $this->_helper->layout->setLayout('layout');
        $this->view->layoutUsuario = $this->_identity;
    }
}
