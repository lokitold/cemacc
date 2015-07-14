<?php

class Logistica_AdquisicionController extends Core_Controller_Logistica {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->view->title = "Adquisiciones";
        $this->view->headTitle($this->view->title, 'APPEND');
        $this->view->adquisicion = Application_Entity_Adquisicion::getAdquisicionByEmpresa((int)$this->_identity->empresa_id);
    }

}
